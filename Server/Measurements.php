<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("propel_init.php");

class Measurements
{
    
    /**
     * @param string $searchdate
     *
     * @return null|stdClass
     * @url GET {searchdate}
     */
    
    
    function getMeasurementsBySearchdate($searchdate)
    {
        
        getAllFromDB($searchdate);
        
    }
    
    /**
     * @url GET
     */
    function getAllCurrentMeasurements()
    {
        getAllFromDB();
        
    }
    
    /*
     *This function queries the db for Stations, Sensors and their Measurements
     *If a searchdate is given, every measurements >=now()-$searchdate are returned
     *if no searchdate is given, only the newest measurements are returned
     */
    function getAllFromDB()
    {
        
        $json         = new stdClass();
        $stations     = StationQuery::create()->joinWith('Station.Sensor')->find();
        $stationArray = array();
        foreach ($stations as $stat) {
            $jStation     = new stdClass();
            $jMeasurement = new stdClass();
            
            $jStation->stationId    = $stat->getId();
            $jStation->name         = $stat->getName();
            $jStation->description  = $stat->getDescription();
            $jStation->urlSensor    = $stat->getUrlSensor();
            $jStation->urlNetmodule = $stat->getUrlNetmodule();
            $jStation->urlTissan    = $stat->getUrlTissan();
            
            $sensorArray = array();
            $sensors     = $stat->getSensors();
            foreach ($sensors as $sen) {
                $jSensor              = new stdClass();
                $jSensor->sensorId    = $sen->getId();
                $jSensor->name        = $sen->getName();
                $jSensor->description = $sen->getDescription();
                $jSensor->status      = $sen->getStatus();
                $jSensor->delay       = $sen->getDelay();
                
                $sensorType          = SensorTypeQuery::create()->filterById($sen->getStypeId())->findOne();
                $jSensor->sensorType = $sensorType->getName();
                
                
                $searchdate = func_get_arg(1); 
                if ($searchdate != NULL) {
                    
                    $today   = date('Y-m-d');
                    $newdate = strtotime('-' . $searchdate . ' day', strtotime($today));
                    $newdate = date('Y-m-j', $newdate);
                    
                    $latestMeasurements = MesaurementQuery::create()->filterBySensorId($sen->getId())->filterByTimestamp(array(
                        'min' => $newdate
                    ))->orderByTimestamp('desc')->find();
                    
                } else {
                    
                    $latestMeasurements = MesaurementQuery::create()->filterBySensorId($sen->getId())->orderByTimestamp('desc')->find();
                }
                
                
                
                $measurementArray = array();
                foreach ($latestMeasurements as $mes) {
                    $jMeasurement              = new stdClass();
                    $jMeasurement->name        = $mes->getName();
                    $jMeasurement->timestamp   = $mes->getTimestamp("Y-m-d H:i:s");
                    $jMeasurement->valueFloat  = $mes->getValueFloat();
                    $jMeasurement->valueString = $mes->getValueString();
                    $jMeasurement->unit        = $mes->getUnit();
                    $measurementArray[]        = $jMeasurement;
                }
                $jSensor->measurements = $measurementArray;
                $sensorArray[]         = $jSensor;
            }
            $jStation->sensors = (object) $sensorArray;
            $stationArray[]    = $jStation;
        }
        $json->stations = $stationArray;
        
        return $json;
        
        
    }
    
}
