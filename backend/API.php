<?php
include_once "Config.php"; // definitions of database credentials

//NOTE: The includes for Controller and Database may need to have their filepaths modified
require_once "Database.php"; // database class: handles db connection and statement execution
require_once "Controller.php"; // handles incoming resp and req calls

include "login_register.php"; // user verification and signup
include "Reviews.php"; // review endpoint
include "Wineries.php"; // wineries endpoint
include "Wines.php"; // wines endpoint

$controller = new Controller(); //create controller class

try {
    $controller->allowed_methods(["POST"]); // forces user to use POST
    $controller->assert_params(["api_key", "type"]); // ensures requests contain an API key and request type
    $db = new Database(); // create connection to database

    $conn = $db->get_connection(); // retrieve connection instance
    $input_json = $controller->get_post_json(); // request JSON parsed as associative array

    /**
     * 
     * 
     * 
     * 
     * please add the relevant endpoint functions in the switch case below
     * They should all echo the result data out by themselves, it you used Vincent's stuff correctly
     * All error hangling will be done here
     * 
     * 
     * 
     */
    switch ($data["type"]) {
        case "wines":
            direct($controller);
            return;
        case "login":
            validateDetails($controller);
            return;
        case "register":
            registerUser($controller);
            return;
        case "getWineReviews":
            getWineReviews($controller);
            return;
        case "getWineryReviews":
            getWineryReviews($controller);
            return;
        case "getWineAverage":
            averagePointsPerWine($controller);
            return;
        case "getWineryAverage":
            averagePointsPerWinery($controller);
            return;
        case "insertReviewWines":
            insertReviewWines($controller);
            return;
        case "insertReviewWinery":
            insertReviewWinery($controller);
            return;
        case "getCountries":
            getCountries($controller);
            return;
        default:
            throw new Exception("not a valid type, you are dom >:|");
    }

    //handle endpoints according to request type here
} catch (exception $e) //handle any caught exceptions
{
    $controller->error($e->getMessage(), $e->getCode());
}


/**
 * 
 * fuction that returns true if a users apik-key is linked to a record of a manager,
 * else throws a very lovely error message to the unauthorised user
 * fair warning this function is untested and may need changes
 * 
 */
function checkPermission($controller)
{
    $data = $controller->get_post_json();
    $db = new Database();

    $res = $db->query("SELECT * FROM users WHERE api_key = ?", 's', [$data['api_key']]);

    if ($res != null) {
        if ($res[0]["user_type"] == 'Manager') {
            return true;
        } else {

            throw new Exception("YOU don't have permission FOR THAT ACTION, now get outa here and DON'T COME BACK!", 400);
        }
    } else {
        throw new Exception("Nice try but you don't even exist in the database... L", 400);
    }

}


?>