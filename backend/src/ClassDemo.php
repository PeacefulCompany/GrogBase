<?php


require_once "lib/Database.php";
require_once "lib/Controller.php";


// sets up base response headers
$controller = new Controller();

try {
    // forces user to use POST
    $controller->allowed_methods(["POST"]);

    // ensures requests contain an API key and request type
    $controller->assert_params(["api_key", "type"]);

    // establishes database connection
    $db = new Database();

    // executes query and gets result
    $res = $db->query("SELECT * FROM wines");
    
    // send success response with query result
    $controller->success($res);
}
catch(exception $e) {
    // sends error response with error message and HTTP code
    $controller->error($e->getMessage(), $e->getCode());
}

?>
