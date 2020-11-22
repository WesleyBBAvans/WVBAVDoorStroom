<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
} else {
    // since the username is not set in session, the user is not-logged-in
    // he is trying to access this page unauthorized
    // so let's clear all session variables and redirect him to index
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
}

?>


<?php
use Phppot\Room;

    if (isset($_POST['create-room'])) 
    {
//        $buildingName = $_POST['buildingName'];
        require_once __DIR__ . '/Model/room.php';
        $room = new Room();
        $room->insertRoom($_POST['roomName'], $_POST['buildingId']);
    }
    
    if (isset($_POST['delete-building'])) 
    {
        require_once __DIR__ . '/Model/room.php';
        $room = new Room();
        $room->deleteRoomByName($_POST['roomName']);
    }
    
    if (isset($_POST['reserve-room'])) 
    {
        require_once __DIR__ . '/Model/room.php';
        $room = new Room();
        
        if(isset($_POST['reserve'])){
            //$stok is checked and value = 1
            $stok = 1;
        }
        else{
            //$stok is nog checked and value=0
            $stok=0;
        }
        
//        $room->reserveRoom($_POST['roomId'], $_POST['reserve']);
        $room->reserveRoom($_POST['roomId'], $stok);
    }
?>

<html lang="en">
<head>
  <title>Building</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Avans Doorstroom opdracht</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="home.php">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Building...<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <?php

        require_once __DIR__ . '/Model/building.php';
        $building = new \Phppot\Building();
        $buildingResult = $building->readAllBuildings();
        
        // Iterating through the buildings array
        foreach($buildingResult as $building){
            echo "<li><a href='../building.php/selectBuilding($building[id])'>$building[buildingName]</a></li>";
        }
        ?>
        </ul>
      </li>
      <li><a href="buildings.php">All buildings</a></li>
      <li><a href="rooms.php">All rooms</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
    <div class="container">
  <h2>All available rooms</h2>
  <p>Create, delete or reserve rooms</p> 
  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalForm">New room</button>
  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete room</button>
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#reserveModal">Reserve room</button>
  <table class="table">
    <thead>
          <tr>
            <th>Building name</th>
            <th>Room name</th>
            <th>reserved</th>
          </tr>
    </thead>
    <?php

    require_once __DIR__ . '/Model/room.php';
    $room = new \Phppot\Room();
    $roomResultSet = $room->readAllRooms();
    
    // Iterating through the rooms array
    foreach($roomResultSet as $room){
        if ($room['reserved']) 
        {
            $reserved = 'Reserved';
        }
        else 
        {
           $reserved = 'Not reserved'; 
        }
        
      echo "<tr>"
        . "<td>$room[buildingName]</td>"
        . " <td>$room[roomName]</td>"
        . "<td>$reserved</td>"
        . "</tr>";
    }
    ?>
  
</table>
</div>
        <!-- Modal -->
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Create new building</h4>
            </div>
            <form action="" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <select name="buildingId">
        <?php
        
        // Iterating through the buildings array
        foreach($buildingResult as $building){
            
            echo "<option name='buildingId' value='$building[id]'>$building[buildingName]</option>";
        }
        ?>
                      </select>   
                    </div>
                    <div class="form-group">
                        <label for="roomName">Name</label>
                         <input type="text" class="form-control" name="roomName" placeholder="Enter the room name">
                    </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--<button type="submit" class="btn btn-primary submitBtn" name="create-building" id="create-building">Create</button>-->
                <button type="submit" class="btn btn-primary submitBtn" name="create-room">Create</button>
            </div>
            </form>
        </div>
    </div>
</div>
    
    <!-- Delete Modal -->
<div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Delete room</h4>
            </div>
            <form action="" method="POST">
            <div class="modal-body">
                <h4>Wich room do you want to delete?</h4>
                    <div class="form-group">
                        <label for="roomName">Name</label>
                         <input type="text" class="form-control" name="roomName" placeholder="Enter the room name">
                    </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No, I don't want to delete</button>
                <button type="submit" class="btn btn-primary submitBtn" name="delete-building">Yes, delete</button>
            </div>
            </form>
        </div>
    </div>
</div>
    
            <!-- Modal -->
<div class="modal fade" id="reserveModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Create new building</h4>
            </div>
            <form action="" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <select name="roomId">
        <?php
        
        // Iterating through the buildings array
            foreach($roomResultSet as $room){
            
            echo "<option name='roomId' value='$room[roomName]'>$room[roomName]</option>";
        }
        ?>
                      </select>   
                    </div>
            <div class="form-group">
                 <label for="reserve">Reserve</label>
                  <input type="checkbox" class="form-control" name="reserve">
             </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--<button type="submit" class="btn btn-primary submitBtn" name="create-building" id="create-building">Create</button>-->
                <button type="submit" class="btn btn-primary submitBtn" name="reserve-room">Create</button>
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>