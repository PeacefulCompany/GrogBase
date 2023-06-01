<?php
    //Get connection from database class in config file
    include 'Config.php';
    $GLOBALS['conn'] = $connection;
    //Check to see if API key exists

    //Send to correct endpoint based on type

    include_once 'Wine.php';
    include_once 'Wineries.php';
    include_once 'review.php';

    /*We expect something like:
    {
    "type":"addWineries",
    "api_key":"a9198b68355f78830054c31a39916b7f",
    ...
    }
    */

    header('Content-Type: application/json');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');

    $input_json = json_decode(file_get_contents("php://input"),true);    // retrieve json from API call

    if(isset($input_json["type"]))
    {
        switch($input_json["type"])
        {
            case "getWines":
                getWines($GLOBALS['conn'],json_encode($input_json));
                break;
            case "getWineries":
                getWineries($GLOBALS['conn'],json_encode($input_json));
                break;
            case "getWineryReviews":
                getWineryReviews($input_json,$GLOBALS['conn']);
                break;
            case "getWineReviews":
                getWineReviews($input_json,$GLOBALS['conn']);
                break;
            case "insertWineries":
                addWineries($GLOBALS['conn'],json_encode($input_json));
            case "deleteWinery":
            case "updateWinery":
            default:

        }
    }

    
?>