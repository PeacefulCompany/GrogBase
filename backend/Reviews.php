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
    $query = "Select " . $feilds . " FROM reviews_winery NATURAL JOIN (Select user_id, first_name, last_name, email from users) AS u NATURAL JOIN (Select winery_id, name AS 'winery_name', active FROM wineries) as w";


    // if (in_array("rating_avg", $data['return'])) {

    // asd

    // }


    $query .= " WHERE active = 1 ";


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
    // $averagerating = false;

    // handles return part of the query
    $controller->assert_params(["return"]);

    // $index = array_search('avg_rating', $data['return']);

    //creating fields params
    $feilds = "";
    $feilds = "";
    if ($data["return"] == '*') {
        $feilds = $data["return"];
    } else {
        //setup for select string
        $feilds = implode(",", $data["return"]);
    }

    // if($averagerating)
    // {
    //     $feilds .= ", AVG(points) ";
    // }


    // handles the sort setup of the query and throws and error if incorrect json is created

    $searchFeild = [];



    //build init query
    $query = "Select " . $feilds . " FROM reviews_wine NATURAL JOIN (Select user_id, first_name, last_name, email from users) as u NATURAL JOIN (Select wine_id, name as 'wine_name', type, active from wines) as w";



    // if (in_array("rating_avg", $data['return'])) {
    //     $subquery = "NATURAL JOIN (
    //         SELECT
    //             `wines`.`wine_id` AS `wine_id`,
    //             `wines`.`name` AS `name`,
    //             `wines`.`description` AS `description`,
    //             `wines`.`type` AS `type`,
    //             `wines`.`year` AS `year`,
    //             `wines`.`price` AS `price`,
    //             `wines`.`winery` AS `winery`,
    //             `R`.`rating_avg` AS `rating_avg`
    //         FROM
    //             `wines`
    //         LEFT JOIN (
    //             SELECT
    //                 `reviews_wine`.`wine_id` AS `wine_id`,
    //                 ROUND(AVG(`reviews_wine`.`points`), 2) AS `rating_avg`
    //             FROM
    //                 `reviews_wine`
    //             GROUP BY `reviews_wine`.`wine_id`
    //         ) `R` ON (`wines`.`wine_id` = `R`.`wine_id`)
    //     ) AS `subquery_alias` ";

    //     $query .= str_replace(array("\n", "\r"), '', $subquery);
    // }


    $query .= " WHERE active = 1 ";


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
    $userID = getUserID($controller);


    $query = "INSERT INTO reviews_wine VALUES(?,?,?,?,?)";

    if (isset($data['target']['wine_id']) && isset($data['values']['points']) && isset($data['values']['review']) && isset($data['values']['drunk'])) {
        $arr = [];
        array_push($arr, $userID);
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
    $userID = getUserID($controller);

    $query = "INSERT INTO reviews_winery VALUES(?,?,?,?)";

    if (isset($data['target']['wine_id']) && isset($data['values']['points']) && isset($data['values']['review'])) {
        $arr = [];
        array_push($arr, $userID);
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


/*
 {
    api_key: "...",
    type : "",
    target:{user_id: int , wine_id: int}
 } 
 */


/**
 * 
 * deletes a wine review based in the primary key of the record determined by the passed in json
 * 
 */

function deleteWineReview($controller)
{
    $data = $controller->get_post_json();

    $controller->assert_params(["target"]);
    $userID = getUserID($controller);


    if (isset($data["target"]["wine_id"])) {
        $query = "DELETE FROM reviews_wine WHERE user_id = ? AND wine_id = ?";
        $db = new Database();

        $db->query($query, "ii", [$userID, $data["target"]["wine_id"]]);

    } else {
        throw new Exception("huh, your json is missing a couple of things... double check that you have user_id and wine_id");
    }

}


/**
 * 
 * deletes a winery review based in the primary key of the record determined by the passed in json
 * 
 */

function deleteWineryReview($controller)
{
    $data = $controller->get_post_json();

    $controller->assert_params(["target"]);
    $userID = getUserID($controller);

    if (isset($data["target"]["winery_id"])) {

        $query = "DELETE FROM reviews_wine WHERE user_id = ? AND winery_id = ?";
        $db = new Database();

        $db->query($query, "ii", [$userID, $data["target"]["winery_id"]]);

    } else {
        throw new Exception("huh, your json is missing a couple of things... double check that you have user_id and winery_id");
    }

}

function getUserID($controller)
{
    $data = $controller->get_post_json();
    $db = new Database();

    $res = $db->query("SELECT * FROM users WHERE api_key = ?", 's', [$data['api_key']]);

    if ($res != null) {
        return $res[0]["user_id"];
    } else {
        throw new Exception("Nice try but you don't even exist in the database... L", 400);
    }

}





?>