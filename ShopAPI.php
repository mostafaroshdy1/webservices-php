<?php
require_once "vendor/autoload.php";
$resources = ["items"];
$urlParts = explode("/", $_SERVER["REQUEST_URI"]);
$resource = $urlParts[4];
$resource_id = $urlParts[5] && is_numeric($urlParts[5]) ? (int) $urlParts[5] : 0;



$db = new DB();
$db->connect();

header("Content-type: application/json");

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $res = handleGet($resource, $resource_id);
        $statusCode = is_null($res) ? 404 : 200;
        http_response_code($statusCode);
        echo $res ? json_encode($res) : json_encode(["error" => "Resource dosn't exist"]);
        break;
    case "POST":
        handlePost($resource);
        break;
    default:
        $statusCode = 405;
        http_response_code($statusCode);
        echo json_encode(["error" => "method not allowed!"]);
        break;
}


function handleGet($resource, $resource_id)
{
    global $resources;
    if (!in_array($resource, $resources)) {
        return null;
    }
    if ($resource == "items") {
        $item = Items::find($resource_id);
        if ($item) {
            return $item;
        }
    }
}
function handlePost($resource)
{
    global $resources;
    if (!in_array($resource, $resources)) {
        return null;
    }
    // $item = new Items();
    $rawData = file_get_contents("php://input");
    $jsonData = json_decode($rawData, true);
    if ($jsonData === null) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON data"]);
    } else {
        try {
            $item = Items::create($jsonData);
        } catch (\Exception $e) {
            var_dump($e);
        }
        http_response_code(200);
        echo json_encode(["message" => "Data is successfully stored", "data" => $item]);

    }
}


// public function get_item(int $id)
// {
//     $item = Items::where('id', $id)->get();
//     return count($item) > 0 ? $item : null;
// }
// public function store(array $item)
// {

//     return Items::create($item);
// }