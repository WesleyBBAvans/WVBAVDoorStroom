<?php
namespace Phppot;

class Room
{

    private $ds;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    /**
     * to check if the room already exists
     *
     * @param string $roomName
     * @return boolean
     */
    public function existsRoom($roomName)
    {
        $query = 'SELECT * FROM tbl_buildingRoom where roomName = ?';
        $paramType = 's';
        $paramValue = array($roomName);
        $resultArray = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function findBuildingByRoom($buildingId)
    {
        $query = 'SELECT * FROM tbl_building where id = ?';
        $paramType = 's';
        $paramValue = array(
            $buildingId
        );
        $buildingRecord = $this->ds->select($query, $paramType, $paramValue);
        return $buildingRecord;
    }

    /**
     * to create a room
     *
     * @return string[] creation status message
     */
    public function insertRoom($roomName, $buildingId) {
     $exists = $this->existsRoom($roomName);
        if ($exists) {
            $response = array(
                "status" => "error",
                "message" => "Room already exists."
            );
        } else {
            $query = 'INSERT INTO tbl_buildingRoom (roomName, buildingId) VALUES (?, ?)';
            $paramType = 'ss';
            $paramValue = array(
                $roomName,
                $buildingId
            );
            $buildingId = $this->ds->insert($query, $paramType, $paramValue);
            if (! empty($buildingId)) {
                $response = array(
                    "status" => "success",
                    "message" => "You have created successfully.");
            }
        }
    }

    public function findRoom($roomName)
    {
        $query = 'SELECT * FROM tbl_buildingRoom where roomName = ?';
        $paramType = 's';
        $paramValue = array(
            $roomName
        );
        $buildingRecord = $this->ds->select($query, $paramType, $paramValue);
        return $buildingRecord;
    }
    
    public function readAllRooms()
    {
        $query = 'SELECT * FROM tbl_buildingRoom JOIN tbl_building on tbl_buildingRoom.buildingId = tbl_building.id';
        $paramType = 's';
        $paramValue = array();
        
        $buildings = $this->ds->select($query, $paramType, $paramValue);
        
        return $buildings;
    }
    
    public function reserveRoom($roomName, $reserved)
    {
        $query = 'update tbl_buildingRoom SET reserved = ? WHERE roomName = ?';
        $paramType = 'ss';
        $paramValue = array(
            $reserved,
            $roomName
        );
        $buildingRecord = $this->ds->insert($query, $paramType, $paramValue);
        return $buildingRecord;
    }
    
        public function deleteRoomByName($roomName)
    {
        $query = 'DELETE FROM tbl_buildingRoom where roomName = ?';
        $paramType = 's';
        $paramValue = array(
            $roomName
        );
        $buildingRecord = $this->ds->insert($query, $paramType, $paramValue);
        return $buildingRecord;
    }
}
