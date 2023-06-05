<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "Config.php"; // definitions of database credentials

//NOTE: The includes for Controller and Database may need to have their filepaths modified
require_once "lib/Database.php"; // database class: handles db connection and statement execution
require_once "lib/Controller.php"; // handles incoming resp and req calls

require_once "LoginRegister.php"; // user verification and signup
require_once "Reviews.php"; // review endpoint
require_once "Wineries.php"; // wineries endpoint
require_once "Wines.php"; // wines endpoint



$controller = new Controller(); //create controller class

// Angular does an OPTIONS request before sending the actual
// request. This is added such that the API doesn't bomb
// when this is request is made
if($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit(0);
}

define("PERM_NOAUTH", ['register', 'login']);

try {
    $controller->allowed_methods(["POST"]); // forces user to use POST
    $controller->assert_params(["type"]); // ensures requests contain an API key and request type
    $data = $controller->get_post_json(); // request JSON parsed as associative array

    if(!in_array($data['type'], PERM_NOAUTH)) {
        $controller->assert_params(["api_key"]);
        checkPermission($controller);
    }

    /**
     * please add the relevant endpoint functions in the switch case below
     * They should all echo the result data out by themselves, it you used Vincent's stuff correctly
     * All error hangling will be done here
     */
    switch ($data["type"]) {
    // Wine CRUD
        case "wines":
            direct($controller);
            return;
        case "updateWine":
            updateWine($controller);
            return;
        case "deleteWine":
            deleteWine($controller);
            return;

    // Wine Reviews
        case "getWineAverage":
            averagePointsPerWine($controller);
            return;
        case "getWineReviews":
            getWineReviews($controller);
            return;
        case "deleteWineReview":
            deleteWineReview($controller);
            return;
        case "insertReviewWines":
            insertReviewWines($controller);
            return;

    // Login & Register
        case "login":
            validateDetails($controller);
            return;
        case "register":
            createUser($controller);
            return;

    // Winery CRUD
        case "getWineries":
            getWineries($controller);
            return;
        case "addWinery":
            addWineries($controller);
            return;
        case "updateWinery":
            updateWinery($controller);
            return;
        case "deleteWinery":
            deleteWinery($controller);
            return;
        
    // Winery review
        case "getWineryReviews":
            getWineryReviews($controller);
            return;
        case "getWineryAverage":
            averagePointsPerWinery($controller);
            return;
        case "deleteWineryReview":
            deleteWineryReview($controller);
            return;
        case "insertReviewWinery":
            insertReviewWinery($controller);
            return;

    // Utilities
        case "getCountries":
            getCountries($controller);
            return;
        default:
            throw new Exception($data['type'] . " is not a valid type, you are dom >:|", 400);
    }

    //handle endpoints according to request type here
} catch (Exception $e) //handle any caught exceptions
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
    /**
     * 
     * ||---------------------------------------------------------------------------------------------------------||
     * ||=========================================================================================================||
     * ||please add the endpoints that specific users types can access in your endpoints to the assoc array below ||
     * ||=========================================================================================================||
     * ||---------------------------------------------------------------------------------------------------------||
     * 
     */
    $perms = [
        'login' => ['login', 'register'],
        'view' => ['getWineries', 'wines', 'getWineReviews', 'getWineryReviews', 'getWineryAverage', 'getWineAverage'],
        'review' => ["insertReviewWinery", "insertReviewWines", "deleteWineryReview", "deleteWineReview"],
        'util' => ['getCountries'],
        'admin-winery' => ['updateWinery', 'addWinery'],
        'admin-wine' => ['updateWine', 'addWine']
    ];

    $permArray = [
        "Manager" => array_merge($perms['login'], $perms['util'], $perms['admin-winery'], $perms['admin-wine']),
        "Critic" => array_merge($perms['login'], $perms['util'], $perms['view'], $perms['review']),
        "User" => array_merge($perms['login'], $perms['util'], $perms['view'], $perms['review'])
    ];


    $data = $controller->get_post_json();
    $db = new Database();

    $res = $db->query("SELECT * FROM users WHERE api_key = ?", 's', [$data['api_key']]);

    if ($res != null) {
        if (in_array($data['type'],$permArray[$res[0]["user_type"]]) ) {
            return true;
        } else {

            throw new Exception("YOU don't have permission FOR THAT ACTION, now get outa here and DON'T COME BACK!", 400);
        }
    } else {
        throw new Exception("Nice try but you don't even exist in the database... L", 400);
    }

}


?>
