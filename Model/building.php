<?php
namespace Phppot;

class Building
{

    private $ds;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    /**
     * to check if the building already exists
     *
     * @param string $buildingName
     * @return boolean
     */
    public function existsBuilding($buildingName)
    {
        $query = 'SELECT * FROM tbl_building where buildingName = ?';
        $paramType = 's';
        $paramValue = array($buildingName);
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


    /**
     * to create a building
     *
     * @return string[] creation status message
     */
    public function insertBuilding($buildingName) {
     $exists = $this->existsBuilding($buildingName);
        if ($exists) {
            $response = array(
                "status" => "error",
                "message" => "Building already exists."
            );
        } else {
            $query = 'INSERT INTO tbl_building (buildingName) VALUES (?)';
            $paramType = 's';
            $paramValue = array(
                $buildingName
            );
            $buildingId = $this->ds->insert($query, $paramType, $paramValue);
            if (! empty($buildingId)) {
                $response = array(
                    "status" => "success",
                    "message" => "You have created successfully.");
            }
        }
        return $response;
    }

    /*
     * to find a specific building record
     * 
     * @return building
     */
    public function findBuilding($buildingName)
    {
        $query = 'SELECT * FROM tbl_building where buildingName = ?';
        $paramType = 's';
        $paramValue = array(
            $buildingName
        );
        $buildingRecord = $this->ds->select($query, $paramType, $paramValue);
        return $buildingRecord;
    }
    
        /*
     * to find a specific building record
     * 
     * @return building
     */
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
    
    public function deleteBuildingByName($buildingName)
    {
        $query = 'DELETE FROM tbl_building where buildingName = ?';
        $paramType = 's';
        $paramValue = array(
            $buildingName
        );
        $buildingRecord = $this->ds->insert($query, $paramType, $paramValue);
        return $buildingRecord;
    }
    
    public function readAllBuildings()
    {
        $query = 'SELECT * FROM tbl_building';
        $paramType = 's';
        $paramValue = array();
        
        $buildings = $this->ds->select($query, $paramType, $paramValue);
        
        return $buildings;
    }
}
