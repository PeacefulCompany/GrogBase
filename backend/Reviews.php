<?php


    // function wineTypeHandler()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     switch ($data["type"]) {
    //         case "getWineReviews":
    //             return $this->getWineReviews($data);

    //         case "getWineryReviews":
    //             return $this->getWineryReviews($data);

    //         default;
    //     }

    // }

    require_once "Database.php";
    require_once "Controller.php";




     function getWineryReviews($data, $connection) //determines the amount of join that will need to be setup
    {
        echo ("winery");
        $params = "";

        // handles return part of the query

        $feilds = "";
        if (isset($data["return"])) {
            $feilds = "";
            if ($data["return"] == '*') {
                $feilds = $data["return"];
            } else {
                //setup for select string
                for ($i = 0; $i < count($data["return"]) - 1; $i++) {

                    if ($data["return"][$i] == "winery_id") {
                        $feilds .= "wineries.winery_id";
                    } elseif ($data["return"][$i] == "user_id") {
                        $feilds .= "users.user_id";
                    } else {
                        $feilds = $feilds . $data["return"][$i]; // should maybe add some sanitiasion here
                    }

                    if ($i + 1 < count($data["return"]) - 1) {
                        $feilds .= ', ';
                    }

                }
            }
        } else {
            throw new Exception("missing return in json", 400);
        }


        // handles the sort setup of the query and throws and error if incorrect json is created

        $searchFeild = [];



        //build init query
        $query = "Select " . $feilds . " FROM reviews_winery, users, wineries WHERE reviews_winery.user_id = users.user_id AND wineries.winery_id = reviews_winery.winery_id";


        //adding search clause to query

        if (!isset($data['search']) && isset($data['fuzzy'])) {
            throw new Exception("Cannot have a fuzzy parameter without a search parameter", 400);
        }

        if (isset($data['search'])) {

            foreach ($data['search'] as $key => $value) {

                $keyS = mysqli_real_escape_string($connection, $key);


                $params .= "s";


                if (isset($data['fuzzy']) && $data['fuzzy']) {
                    $query .= " AND $keyS LIKE ? ";
                    $searchValue = str_replace('%', '', $value);
                    array_push($searchFeild, '%' . $searchValue . '%');
                } else {
                    $query .= " AND $keyS = ? ";
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
            $sort = "";
            for ($i = 0; $i < count($rogue) - 1; $i++) {
                $temp = mysqli_real_escape_string($connection, $rogue[$i]);
                $sort = $sort . $temp . ',';
            }

            $temp = mysqli_real_escape_string($connection, $rogue[count($rogue) - 1]);
            $sort = $sort . $temp;

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
        // echo $query;


        try {
            return $connection->query($query, $params, $searchFeild);
        } catch (Exception $e)
        {
            throw $e;
        }

        // $prepared = mysqli_prepare($connection, $query);
        // if (!$prepared) {
        //     return errorThrower("Error in query");

        // }
        // if ($params != "") {
        //     $prepared->bind_param($params, ...$searchFeild);
        // }

        // $prepared->execute();
        // $res = $prepared->get_result();
        // $formattedRes = mysqli_fetch_all($res, MYSQLI_ASSOC);
        // return messageFormatter($formattedRes);

    }



     function getWineReviews($data, $connection) //determines the amount of join that will need to be setup
    {
        $params = "";

        // handles return part of the query

        $feilds = "";
        if (isset($data["return"])) {
            $feilds = "";
            if ($data["return"] == '*') {
                $feilds = $data["return"];
            } else {
                //setup for select string
                for ($i = 0; $i < count($data["return"]) - 1; $i++) {

                    if ($data["return"][$i] == "user_id") {
                        $feilds .= "users.user_id";
                    } else if($data["return"][$i] == "winery_id"){
                        $feilds .= "wines.wine_id";
                    }
                    else {
                        $feilds = $feilds . $data["return"][$i]; // should maybe add some sanitiasion here
                    }

                    if ($i + 1 < count($data["return"]) - 1) {
                        $feilds .= ', ';
                    }

                }
            }
        } else {
            throw new Exception("missing return in json", 400);
        }


        // handles the sort setup of the query and throws and error if incorrect json is created

        $searchFeild = [];



        //build init query
        $query = "Select " . $feilds . " FROM reviews_wine, users, wines WHERE reviews_wine.user_id = users.user_id AND wines.wine_id = reviews_wine.wine_id ";


        //adding search clause to query

        if (!isset($data['search']) && isset($data['fuzzy'])) {
            throw new Exception("Cannot have a fuzzy parameter without a search parameter", 400);
        }

        if (isset($data['search'])) {

            foreach ($data['search'] as $key => $value) {

                $keyS = mysqli_real_escape_string($connection, $key);


                $params .= "s";


                if (isset($data['fuzzy']) && $data['fuzzy']) {
                    $query .= " AND $keyS LIKE ? ";
                    $searchValue = str_replace('%', '', $value);
                    array_push($searchFeild, '%' . $searchValue . '%');
                } else {
                    $query .= " AND $keyS = ? ";
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
            $sort = "";
            for ($i = 0; $i < count($rogue) - 1; $i++) {
                $temp = mysqli_real_escape_string($connection, $rogue[$i]);
                $sort = $sort . $temp . ',';
            }

            $temp = mysqli_real_escape_string($connection, $rogue[count($rogue) - 1]);
            $sort = $sort . $temp;

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


        try {
            return $connection->query($query, $params, $searchFeild);
        } catch (Exception $e) {
            throw $e;   
        }




        // var_dump($searchFeild);

        // echo $query;
        // $prepared = mysqli_prepare($connection, $query);
        // if (!$prepared) {
        //     return errorThrower("Error in query");

        // }

        // if ($params != "") {
        //     $prepared->bind_param($params, ...$searchFeild);
        // }

        // $prepared->execute();
        // $res = $prepared->get_result();
        // $formattedRes = mysqli_fetch_all($res, MYSQLI_ASSOC);
        // return messageFormatter($formattedRes);

    }


     function setupSelectString($returnString) // handles the setup of the select part of the query statment though a passed in array of string values
    {
        $feilds = "";

        return $feilds;
    }

     function messageFormatter($jsonResponse)
    { //formats the response for a return message on a successful request
        $response = array(
            'status' => "success",
            'data' => $jsonResponse
        );

        return json_encode($response);
    }


     function errorThrower($message) //formats the response for a return message on a unsuccessful request
    {
        $data = array(
            'status' => 'failed',
            'data' => "error: " . $message
        );

        return json_encode($data);
    }



    /*
    
    {
        api_key:,
        type: "insertWineReview",
        target: {user_id: "", wine_id: ""},
        values: {points: "", review: "", drunk: ""}
    }
    
    */

    function insertReviewWines($data, $connection){
        $query = "INSERT INTO reviews_wine('user_id', 'wine_id', 'points', 'reviews', 'drunk') VALUES(?,?,?,?,?)";
        
        if(isset($data['target']) && isset($data['values']))
        {
            if(isset($data['target']['user_id']) && isset($data['target']['wine_id'])  && isset($data['values']['points'])  && isset($data['values']['review'])  && isset($data['values']['drunk']))
            {
                $arr = [];
                array_push($arr, $data['target']['user_id']);
                array_push($arr, $data['target']['wine_id']);
                array_push($arr, $data['values']['points']);
                array_push($arr, $data['values']['review']);
                array_push($arr, $data['values']['drunk']);

                try{
                    $connection->query($query,'sssss', $arr);
                }
                catch (Exception $e)
                {
                    throw $e;
                }
            }
            else
            {
                throw new Exception("missing feilds in target or values");
            }
        }
        else
        {
            throw new Exception("missing target or values", 400);
        }
    }


    /*
    
    {
        api_key:,
        type: "insertWineryReview",
        target: {user_id: "", wine_id: ""},
        values: {points: "", review: ""}
    }
    
    */

    function insertReviewWinery($data, $connection){
        $query = "INSERT INTO reviews_winery('winery_id', 'user_id', 'points', 'reviews') VALUES(?,?,?,?)";

        if(isset($data['target']) && isset($data['values']))
        {
            if(isset($data['target']['user_id']) && isset($data['target']['wine_id'])  && isset($data['values']['points'])  && isset($data['values']['review']))
            {
                $arr = [];
                array_push($arr, $data['target']['user_id']);
                array_push($arr, $data['target']['wine_id']);
                array_push($arr, $data['values']['points']);
                array_push($arr, $data['values']['review']);

                try{
                    $connection->query($query,'ssss', $arr);
                }
                catch (Exception $e)
                {
                    throw $e;
                }
            }
            else
            {
                throw new Exception("missing feilds in target or values");
            }
        }
        else
        {
            throw new Exception("missing target or values", 400);
        }
    }

    function averagePointsPerWinery(){

    }
    
    function averagePointsPerWine(){

    }





?>