<?php
header('content-type: application/octet-stream');
require_once 'vendor/autoload.php';

use GeoIp2\Database\Reader;

$reader = new Reader('GeoLite2-City.mmdb');

// Replace "city" with the appropriate method for your database, e.g.,
// "country".
$record = $reader->city($_GET['ip']);

/*
 * curl to test CORS
 * curl --header "Origin: http://localhost:8100/" --header "Access-Control-Request-Method: GET" --header "Access-Control-Request-Headers: content-type" -X OPTIONS --verbose "http://nice-informatique-service.fr/geoip_service/geoip_service.php?ip=79.141.163.88&data=json"
 */
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


switch ($_GET['data']) {
    case "isoCode" :
        print($record->country->isoCode . "\n"); // 'US'
        break;
    case "country" :
        print($record->country->name . "\n"); // 'United States'
        break;
    
    case "names" :
        print($record->country->names['zh-CN'] . "\n"); // '美国'
        break;
    
    case "subName" :
        print($record->mostSpecificSubdivision->name . "\n"); // 'Minnesota'
        break;
    
    case "subIsoCode" :
        print($record->mostSpecificSubdivision->isoCode . "\n"); // 'MN'
        break;
    
    case "city" :
        print($record->city->name . "\n"); // 'Minneapolis'
        break;
    
    case "PostalCode" :
        print($record->postal->code . "\n"); // '55455'
        break;

    case "latitude" :
        print($record->location->latitude . "\n"); // 44.9733
        break;
    
    case "longitude" :
        print($record->location->longitude . "\n"); // -93.2323
        break;
    
    case "all" :
        print($record->country->isoCode . "\n"); // 'US'
        print($record->country->name . "\n"); // 'United States'
        print($record->country->names['zh-CN'] . "\n"); // '美国'
        print($record->mostSpecificSubdivision->name . "\n"); // 'Minnesota'
        print($record->mostSpecificSubdivision->isoCode . "\n"); // 'MN'
        print($record->city->name . "\n"); // 'Minneapolis'
        print($record->postal->code . "\n"); // '55455'
        print($record->location->latitude . "\n"); // 44.9733
        print($record->location->longitude . "\n"); // -93.2323
        break;
    
    case "json":
        print("{");
        print("\"isoCode\":\"".$record->country->isoCode . "\","); // 'US'
        print("\"country\":\"".$record->country->name . "\","); // 'United States'
        print("\"names\":\"".$record->country->names['zh-CN'] . "\","); // '美国'
        print("\"subName\":\"".$record->mostSpecificSubdivision->name . "\","); // 'Minnesota'
        print("\"subIsoCode\":\"".$record->mostSpecificSubdivision->isoCode . "\","); // 'MN'
        print("\"city\":\"".$record->city->name . "\","); // 'Minneapolis'
        print("\"PostalCode\":\"".$record->postal->code . "\","); // '55455'
        print("\"latitude\":\"".$record->location->latitude . "\","); // 44.9733
        print("\"longitude\":\"".$record->location->longitude. "\""); // -93.2323
        print("}");
        break;
}
?>