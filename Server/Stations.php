<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("propel_init.php");

class Stations
{
    
    
    /**
     * @url GET
     */
    function getStations()
    {
        $json = new stdClass();
        
        $json->stations = $this->getStationsFromDB();
        return $json;
    }
    
    
    
    /**
     * @param string $stationId
     *
     * @return null|stdClass
     * @url GET {stationId}
     */
    function getByStationId($stationId)
    {
        $json = new stdClass();
        
        $json->stations = $this->getStationsFromDB($stationId);
        return $json;
    }
    
    /**
     * @param string $stationId
     *
     * @return null|stdClass
     * @url GET {stationId}/Sensors/
     */
    function getSensors($stationId)
    {
        $json = new stdClass();
        
        $json->sensors = $this->getSensorsFromDB($stationId);
        return $json;
    }
    /**
     *
     * @return null|stdClass
     * @url GET /Sensors/
     */
    function getAllSensors()
    {
        $json         = new stdClass();
        $stationArray = $this->getStationsFromDB();
        foreach ($stationArray as $stat) {
            $stat->sensors = $this->getSensorsFromDB($stat->stationId);
            
        }
        $json->station = $stationArray;
        
        return $json;
    }
    
    /**
     *
     * @return null|stdClass
     * @url GET /Sensors/Measurements
     */
    function getCurrentMeasurements()
    {
        
        $json = new stdClass();
        
        $json->station = $this->getMeasurementsFromDB();
        return $json;
    }
    /**
     * @param $daysBack
     * @return null|stdClass
     * @url GET /Sensors/Measurements/{daysBack}
     */
    function getAllMeasurements($daysBack)
    {
        $json          = new stdClass();
        $json->station = $this->getMeasurementsFromDB($daysBack);
        return $json;
    }
    
    /**
     * @param $stationId, $daysBack
     * @return null|stdClass
     * @url GET {stationId}/Sensors/Measurements/{daysBack}
     */
    function getCurrentMeasurementsFromStation($stationId, $daysBack)
    {
        $json          = new stdClass();
        $json->station = $this->getMeasurementsFromDBByStation($stationId, $daysBack);
        return $json;
    }
    
    /**
     * @param $stationId
     * @return null|stdClass
     * @url GET {stationId}/Sensors/Measurements/
     */
    function getAllMeasurementsFromStation($stationId)
    {
        $json          = new stdClass();
        $json->station = $this->getMeasurementsFromDBByStation($stationId);
        return $json;
    }
    
    function getMeasurementsFromDBByStation()
    {
        $numargs = func_num_args();
        if ($numargs < 2) {
            $stationId    = func_get_arg(0);
            $stationArray = $this->getStationsFromDB($stationId);
            
            return $this->getMeasurementsFromDBHelper($stationArray);
        } else {
            
            $stationId = func_get_arg(0);
            $daysBack  = func_get_arg(1);
            
            $stationArray = $this->getStationsFromDB($stationId);
            
            return $this->getMeasurementsFromDBHelper($stationArray, $daysBack);
        }
        
    }
    
    function getMeasurementsFromDB()
    {
        
        $stationArray = $this->getStationsFromDB();
        
        $numargs = func_num_args();
        if ($numargs >= 1) {
            $daysBack = func_get_arg(0);
            return $this->getMeasurementsFromDBHelper($stationArray, $daysBack);
        } else {
            return $this->getMeasurementsFromDBHelper($stationArray);
        }
        
        
    }
    
    function getMeasurementsFromDBHelper()
    {
        
        $numargs = func_num_args();
        if ($numargs >= 1) {
            $stationArray = func_get_arg(0);
            
            foreach ($stationArray as $stat) {
                $sensorArray = $this->getSensorsFromDB($stat->stationId);
                
                foreach ($sensorArray as $sen) {
                    
                    $numargs = func_num_args();
                    if ($numargs > 1) {
                        $searchdate = func_get_arg(1);
                        
                        $today   = date('Y-m-d');
                        $newdate = strtotime('-' . $searchdate . ' day', strtotime($today));
                        $newdate = date('Y-m-j', $newdate);
                        
                        $measurement = MeasurementQuery::create()->filterByStationId($stat->stationId)->filterBySensorId($sen->sensorId)->filterByTimestamp(array(
                            'min' => $newdate
                        ))->orderByTimestamp('desc')->find();
                    } else {
                        
                        $measurement = MeasurementQuery::create()->filterByStationId($stat->stationId)->filterBySensorId($sen->sensorId)->orderByTimestamp('desc')->findOne();
                    }
                    if ($measurement != NULL) {
                        
                        $measurementArray = array();
                        if ($measurement instanceof Measurement) {
                            $jMeasurement            = new stdClass();
                            $jMeasurement->timestamp = $measurement->getTimestamp()->getTimestamp();
                            $jMeasurement->value     = $measurement->getValue();
                            $measurementArray[]      = $jMeasurement;
                            
                            
                        } else {
                            foreach ($measurement as $mes) {
                                $jMeasurement            = new stdClass();
                                $jMeasurement->timestamp = $mes->getTimestamp()->getTimestamp();
                                $jMeasurement->value     = $mes->getValue();
                                $measurementArray[]      = $jMeasurement;
                            }
                            
                            
                        }
                        
                        $sen->measurements = $measurementArray;
                    }
                }
                
                
                $stat->sensors = $sensorArray;
            }
        }
        return $stationArray;
        
    }
    
    function getStationsFromDB()
    {
        
        $numargs = func_num_args();
        if ($numargs >= 1) {
            $stationId = func_get_arg(0);
            $stations  = StationQuery::create()->filterById($stationId)->find();
        } else {
            $stations = StationQuery::create()->find();
        }
        
        $stationArray = array();
        foreach ($stations as $stat) {
            $jStation               = new stdClass();
            $jStation->stationId    = $stat->getId();
            $jStation->name         = $stat->getName();
            $jStation->description  = $stat->getDescription();
            $jStation->urlSensor    = $stat->getUrlSensor();
            $jStation->urlNetmodule = $stat->getUrlNetmodule();
            $jStation->urlTissan    = $stat->getUrlTissan();
            $stationArray[]         = $jStation;
            
        }
        return $stationArray;
        
        
    }
    
    function getSensorsFromDB()
    {
        
        $numargs = func_num_args();
        if ($numargs >= 1) {
            $stationId     = func_get_arg(0);
            $sensorStation = SensorstationQuery::create()->filterByStationId($stationId)->find();
        } else {
            $sensorStation = SensorstationQuery::create()->filterByStationId($stationId)->find();
        }
        $sensorArray = array();
        foreach ($sensorStation as $itSensorStation) {
            
            $sensorId = $itSensorStation->getSensorId();
            $sensor   = SensorQuery::create()->filterById($sensorId)->findOne();
            
            $jSensor              = new stdClass();
            $jSensor->sensorId    = $sensor->getId();
            $jSensor->name        = $sensor->getName();
            $jSensor->description = $sensor->getDescription();
            $jSensor->unit 	  = $sensor->getUnit();
            $jSensor->title       = $sensor->getTitle();
            $jSensor->sortOrder   = $sensor->getSortorder();
	    $jSensor->delay	  = $itSensorStation->getDelay();
	    $jSensor->active	  = $itSensorStation->getActive();
            if($sensor->getDisplaytypeId() != NULL){
            	$jSensor->displayTypeId = $sensor->getDisplaytypeId();
	    	$displayType    = DisplaytypeQuery::create()->filterById($sensor->getDisplaytypeId())->findOne();
		$jSensor->displayType = $displayType->getName();
	    }
           
            
            $sensorArray[] = $jSensor;
            
        }
        
        return $sensorArray;
    }
    
    
}
