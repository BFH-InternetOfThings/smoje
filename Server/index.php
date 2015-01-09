<?php
require_once 'smoje-server/vendor/restler.php';
use Luracast\Restler\Restler;
$r = new Restler();
//$r->setSupportedFormats('JsonFormat', 'XmlFormat');
//$r->addAPIClass('Measurement');
//$r->addAPIClass('Measurements');
$r->addAPIClass('Stations');
$r->addAPIClass('Sensors');
//$r->addAuthenticationClass('AccessControl');
$r->handle(); //serve the response
