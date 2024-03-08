<?php
require_once "vendor/autoload.php";
$resources = ["items"];
$urlParts = explode("/", $_SERVER["REQUEST_URI"]);
$resource = $urlParts[4];
$resource_id = $urlParts[5] && is_numeric($urlParts[5]) ? (int) $urlParts[5] : 0;


header("Content-type: application/json");
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $res = handleGet($resource, $resource_id);
        $statusCode = is_null($res) ? 404 : 200;
        http_response_code($statusCode);
        echo $res ? json_encode($res) : json_encode(["error" => "Resource dosn't exist"]);
        break;
}


function handleGet($resource, $resource_id)
{
    global $resources;
    if (!in_array($resource, $resources)) {
        return null;
    }
    if ($resource == "items") {
        $item = (new Item)->get_Item($resource_id);
        if ($item) {
            return $item;
        }
    }
}