<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("propel_init.php");

class Sensors
{
    
    
    
    /**
     * @url GET
     */
    function getAllSensors()
    {
        
        $json = new stdClass();
        
        $json->sensors = $this->getSensorArray();
        
        return $json;
        
        
    }
    
    /**
     *
     * @return null|stdClass
     * @url GET /Stations/
     */
    function getStationsBySensors()
    {
        
        $json    = new stdClass();
        $sensors = $this->getSensorArray();
        
        foreach ($sensors as $sen) {
            
            $sensorStations = SensorstationQuery::create()->filterBySensorId($sen->sensorId)->find();
            $stationArray   = array();
            foreach ($sensorStations as $senstat) {
                
                $station = StationQuery::create()->filterById($senstat->getStationId())->findOne();
                
                $jStation               = new stdClass();
                $jStation->stationId    = $station->getId();
                $jStation->name         = $station->getName();
                $jStation->description  = $station->getDescription();
                $jStation->urlSensor    = $station->getUrlSensor();
                $jStation->urlNetmodule = $station->getUrlNetmodule();
                $jStation->urlTissan    = $station->getUrlTissan();
                $stationArray[]         = $jStation;
            }
            $sen->stations = $stationArray;
            
        }
        $json->sensors = $sensors;
        
        return $json;
        
        
    }
    
    
    function getSensorArray()
    {
        $sensors = SensorQuery::create()->find();
        
        foreach ($sensors as $sen) {
            $jSensor              = new stdClass();
            $jSensor->sensorId    = $sen->getId();
            $jSensor->name        = $sen->getName();
            $jSensor->description = $sen->getDescription();
            $jSensor->unit      = $sen->getUnit();
            
            $jSensor->title     = $sen->getTitle();
            $jSensor->sortOrder = $sen->getSortorder();
	    if($sen->getDisplaytypeId() != NULL){
            	$jSensor->displayTypeId = $sen->getDisplaytypeId();
	    	$displayType    = DisplaytypeQuery::create()->filterById($sen->getDisplaytypeId())->findOne();
		$jSensor->displayType = $displayType->getName();
	    }
            
            $sensorArray[] = $jSensor;
        }
        return $sensorArray;
        
    }
    
    
}
