<?php

require_once "Database.php";
require_once "Controller.php";


/**
 * 
 * gets specific records in review_winery based on the custom selected fields/sorts/searches in the json object posted to the php file
 * 
 */

function getWineryReviews($controller) //determines the amount of join that will need to be setup
{
    $data = $controller->get_post_json();
    $params = "";

    // handles return part of the query
    $controller->assert_params(["return"]);
    $feilds = "";
    if (isset($data["return"])) {
        $feilds = "";
        if ($data["return"] == '*') {
            $feilds = $data["return"];
        } else {
            //setup for select string
            $feilds = implode(",", $data["return"]);

        }
    } else {
        throw new Exception("missing return in json", 400);
    }


    // handles the sort setup of the query and throws and error if incorrect json is created

    $searchFeild = [];



    //build init query
    $query = "Select " . $feilds . " FROM reviews_winery NATURAL JOIN users NATURAL JOIN wineries WHERE 1=1";


    //adding search clause to query

    if (!isset($data['search']) && isset($data['fuzzy'])) {
        throw new Exception("Cannot have a fuzzy parameter without a search parameter", 400);
    }

    if (isset($data['search'])) {
        foreach ($data['search'] as $key => $value) {
            $params .= "s";
            if (isset($data['fuzzy']) && $data['fuzzy']) {
                $query .= " AND $key LIKE ? ";
                $searchValue = str_replace('%', '', $value);
                array_push($searchFeild, '%' . $searchValue . '%');
            } else {
                $query .= " AND $key = ? ";
                array_push($searchFeild, $value);

            }
        }
    }



    //adding sort clause to query
    if (!isset($data['sort']) && isset($data['order'])) {
        throw new Exception("Cannot have a order parameter without a sort parameter", 400);
    }

    if (isset($data['sort'])) {
        $sort = implode(",", $data["sort"]);

        //adding the order by caluse to query
        $order = "ASC";
        if (isset($data['order'])) {
            $order = $data['order'];
        }

        $query .= " ORDER BY " . $sort . " " . $order;
    }


    // handles the limit part of the query

    $limit = 20;
    if (isset($data["limit"])) {
        $limit = $data["limit"];
    }
    $query .= " limit " . $limit;

    // binding params to the query and executing

    $db = new Database();


    $data = $db->query($query, $params, $searchFeild);
    $controller->success($data);



}

/**
 * 
 * gets specific records in review_wines based on the custom selected fields/sorts/searches in the json object posted to the php file
 * 
 */

function getWineReviews($controller) //determines the amount of join that will need to be setup
{
    $data = $controller->get_post_json();
    $params = "";

    // handles return part of the query
    $controller->assert_params(["return"]);


    $feilds = "";
    $feilds = "";
    if ($data["return"] == '*') {
        $feilds = $data["return"];
    } else {
        //setup for select string
        $feilds = implode(",", $data["return"]);
    }


    // handles the sort setup of the query and throws and error if incorrect json is created

    $searchFeild = [];



    //build init query
    $query = "Select " . $feilds . " FROM reviews_wine NATURAL JOIN users NATURAL JOIN wines WHERE 1=1 ";


    //adding search clause to query

    if (!isset($data['search']) && isset($data['fuzzy'])) {
        throw new Exception("Cannot have a fuzzy parameter without a search parameter", 400);
    }

    if (isset($data['search'])) {

        foreach ($data['search'] as $key => $value) {

            $params .= "s";
            if (isset($data['fuzzy']) && $data['fuzzy']) {
                $query .= " AND $key LIKE ? ";
                $searchValue = str_replace('%', '', $value);
                array_push($searchFeild, '%' . $searchValue . '%');
            } else {
                $query .= " AND $key = ? ";
                array_push($searchFeild, $value);

            }
        }
    }



    //adding sort clause to query
    if (!isset($data['sort']) && isset($data['order'])) {
        throw new Exception("Cannot have a order parameter without a sort parameter", 400);
    }

    if (isset($data['sort'])) {
        $rogue = $data['sort'];
        $sort = implode(",", $data["sort"]);

        //adding the order by caluse to query
        $order = "ASC";
        if (isset($data['order'])) {
            $order = $data['order'];
        }

        $query .= " ORDER BY " . $sort . " " . $order;
    }


    // handles the limit part of the query

    $limit = 20;
    if (isset($data["limit"])) {
        $limit = $data["limit"];
    }
    $query .= " limit " . $limit;

    // binding params to the query and executing

    $db = new Database();


    $data = $db->query($query, $params, $searchFeild);
    $controller->success($data);


}




/**
 *  
 * inserts a new record into the review_wine table
 * note if there is a fuplicate key, an sql exception is thrown
 * 
*/

function insertReviewWines($controller)
{
    $data = $controller->get_post_json();
    $controller->assert_params(["target", 'values']);


    $query = "INSERT INTO reviews_wine VALUES(?,?,?,?,?)";

    if (isset($data['target']['user_id']) && isset($data['target']['wine_id']) && isset($data['values']['points']) && isset($data['values']['review']) && isset($data['values']['drunk'])) {
        $arr = [];
        array_push($arr, $data['target']['user_id']);
        array_push($arr, $data['target']['wine_id']);
        array_push($arr, $data['values']['points']);
        array_push($arr, $data['values']['review']);
        array_push($arr, $data['values']['drunk']);
        $db = new Database();

        $db->query($query, 'iiisi', $arr);

    } else {
        throw new Exception("missing feilds in target or values");
    }
}


/**
 * 
 * inserts a new record into the review_winery table
 * note if there is a fuplicate key, an sql exception is thrown
 * 
*/

function insertReviewWinery($controller)
{
    $data = $controller->get_post_json();
    $controller->assert_params(["target", 'values']);

    $query = "INSERT INTO reviews_winery VALUES(?,?,?,?)";

    if (isset($data['target']['user_id']) && isset($data['target']['wine_id']) && isset($data['values']['points']) && isset($data['values']['review'])) {
        $arr = [];
        array_push($arr, $data['target']['user_id']);
        array_push($arr, $data['target']['wine_id']);
        array_push($arr, $data['values']['points']);
        array_push($arr, $data['values']['review']);

        $db = new Database();

        $data = $db->query($query, 'iiis', $arr);
        $controller->success($data);


    } else {
        throw new Exception("missing feilds in target or values");
    }
}


/**
 * 
 * returns the average points per winery (average rating in other words) from the database
 * 
 */
function averagePointsPerWinery($controller)
{
    $db = new Database();
    // $query = "SELECT * FROM winery_list";

    $query = "SELECT 
    `wineries`.`winery_id` AS `winery_id`,
    `wineries`.`name` AS `name`,
    `wineries`.`description` AS `description`,
    `wineries`.`established` AS `established`,
    `wineries`.`location` AS `location`,
    `wineries`.`region` AS `region`,
    `wineries`.`country` AS `country`,
    `wineries`.`website` AS `website`,
    `wineries`.`manager_id` AS `manager_id`,
    `R`.`rating_avg` AS `rating_avg`
    FROM
    (`wineries`
    LEFT JOIN (SELECT 
        `reviews_winery`.`winery_id` AS `winery_id`,
            ROUND(AVG(`reviews_winery`.`points`), 2) AS `rating_avg`
    FROM
        `reviews_winery`
    GROUP BY `reviews_winery`.`winery_id`) `R` ON (`wineries`.`winery_id` = `R`.`winery_id`))";
    $data = $db->query($query);
    $controller->success($data);




}

/**
 * 
 * returns the average points per wine (average rating in other words) from the database
 * 
 */

function averagePointsPerWine($controller)
{
    $db = new Database();
    // $query = "SELECT * FROM wine_list";
    $query = "SELECT 
        `wines`.`wine_id` AS `wine_id`,
        `wines`.`name` AS `name`,
        `wines`.`description` AS `description`,
        `wines`.`type` AS `type`,
        `wines`.`year` AS `year`,
        `wines`.`price` AS `price`,
        `wines`.`winery` AS `winery`,
        `R`.`rating_avg` AS `rating_avg`
    FROM
        (`wines`
        LEFT JOIN (SELECT 
            `reviews_wine`.`wine_id` AS `wine_id`,
                ROUND(AVG(`reviews_wine`.`points`), 2) AS `rating_avg`
        FROM
            `reviews_wine`
        GROUP BY `reviews_wine`.`wine_id`) `R` ON (`wines`.`wine_id` = `R`.`wine_id`))";

    $data = $db->query($query);
    $controller->success($data);

}





?>