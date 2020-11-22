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
      <li class="active"><a href="../home.php">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Building...<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <?php
        use Phppot\Building;

        require_once __DIR__ . '/Model/building.php';
        $building = new Building();
        $buildingResult = $building->readAllBuildings();
        
        // Iterating through the buildings array
        foreach($buildingResult as $building){
            echo "<li><a href='../building.php/selectBuilding($building[id])'>$building[buildingName]</a></li>";
        }
        ?>
        </ul>
      </li>
      <li><a href="../buildings.php">All buildings</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  <h3>Building page</h3>
  <p>Here you will crud buildings</p>
</div>

</body>
</html>