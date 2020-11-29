<?php
include_once dirname(__FILE__) . '/app/BaseConverter.php';
include_once dirname(__FILE__) . '/app/config.php';
include_once dirname(__FILE__) . '/app/Connection.php';
include_once dirname(__FILE__) . '/app/GraphicUtil.php';
include_once dirname(__FILE__) . '/app/GeoJsonUtil.php';
include_once dirname(__FILE__) . '/app/SpaghettiJsonConverter.php';
include_once dirname(__FILE__) . '/app/SpaghettiGeoJsonConverter.php';
function print_json_response($object) {
    header ( 'Content-Type: application/json' );
    return json_encode($object);
}
$name = $_REQUEST['name'];
switch ($name) {
    case 'spaghetti_json':
        $converter = new SpaghettiJsonConverter();
        echo print_json_response($converter->getJsonData());
        break;
    case 'spaghetti_geojson':
        $converter = new SpaghettiGeoJsonConverter();
        echo print_json_response($converter->getJsonData());
        break;
    default:
        http_response_code(404);
}
