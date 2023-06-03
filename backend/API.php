<?php
    include_once "Config.php";// definitions of database credentials

    //NOTE: The includes for Controller and Database may need to have their filepaths modified
    require_once "Database.php";// database class: handles db connection and statement execution
    require_once "Controller.php";// handles incoming resp and req calls

    include "login_register.php";// user verification and signup
    include "Reviews.php";// review endpoint
    include "Wineries.php";// wineries endpoint
    include "Wines.php";// wines endpoint

    $controller = new Controller();//create controller class

    try
    {
        $controller->allowed_methods(["POST"]);// forces user to use POST
        $controller->assert_params(["api_key", "type"]);// ensures requests contain an API key and request type
        $db = new Database();// create connection to database
        
        $conn = $db->get_connection();// retrieve connection instance
        $input_json = $controller->get_post_json();// request JSON parsed as associative array

        //handle endpoints according to request type here
    }
    catch(exception $e)//handle any caught exceptions
    {
        $controller->error($e->getMessage(), $e->getCode());
    }
?>