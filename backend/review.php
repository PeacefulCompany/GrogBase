<?php

class reviewAPI
{


    private $connection = null;

    public static function instance()
    {
        static $instance = null;
        if ($instance == null) {
            $instance = new reviewAPI();
        }
        return $instance;
    }

    private function __construct()
    {
        $this->connection = new mysqli("wheatley.cs.up.ac.za", "u04643187", "?");
        if ($this->connection->connect_error) {
            die("connection failed: (invalid credentials) " . $this->connection->connect_error);
        } else {
            $this->connection->select_db("u04643187_grogTemp");
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }


    public function wineTypeHandler()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        switch ($data["type"]) {
            case "getWineReviews":
                return $this->getWineReviews($data);

            case "getWineryReviews":
                return $this->getWineryReviews($data);

            default;
        }

    }

    private function getWineryReviews($data) //determines the amount of join that will need to be setup
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
            return $this->errorThrower("missing return");
        }


        // handles the sort setup of the query and throws and error if incorrect json is created

        $searchFeild = [];



        //build init query
        $query = "Select " . $feilds . " FROM reviews_winery, users, wineries WHERE reviews_winery.user_id = users.user_id AND wineries.winery_id = reviews_winery.winery_id";


        //adding search clause to query

        if (!isset($data['search']) && isset($data['fuzzy'])) {
            return $this->errorThrower("Cannot have a fuzzy parameter without a search parameter");
        }

        if (isset($data['search'])) {

            foreach ($data['search'] as $key => $value) {

                $keyS = mysqli_real_escape_string($this->connection, $key);


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
            return $this->errorThrower("Cannot have a order parameter without a sort parameter");
        }

        if (isset($data['sort'])) {
            $rogue = $data['sort'];
            $sort = "";
            for ($i = 0; $i < count($rogue) - 1; $i++) {
                $temp = mysqli_real_escape_string($this->connection, $rogue[$i]);
                $sort = $sort . $temp . ',';
            }

            $temp = mysqli_real_escape_string($this->connection, $rogue[count($rogue) - 1]);
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
        echo $query;
        $prepared = mysqli_prepare($this->connection, $query);
        if (!$prepared) {
            return $this->errorThrower("Error in query");

        }
        if ($params != "") {
            $prepared->bind_param($params, ...$searchFeild);
        }

        $prepared->execute();
        $res = $prepared->get_result();
        $formattedRes = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $this->messgaeFormatter($formattedRes);

    }



    private function getWineReviews($data) //determines the amount of join that will need to be setup
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
            return $this->errorThrower("missing return");
        }


        // handles the sort setup of the query and throws and error if incorrect json is created

        $searchFeild = [];



        //build init query
        $query = "Select " . $feilds . " FROM reviews_wine, users, wines WHERE reviews_wine.user_id = users.user_id AND wines.wine_id = reviews_wine.wine_id ";


        //adding search clause to query

        if (!isset($data['search']) && isset($data['fuzzy'])) {
            return $this->errorThrower("Cannot have a fuzzy parameter without a search parameter");
        }

        if (isset($data['search'])) {

            foreach ($data['search'] as $key => $value) {

                $keyS = mysqli_real_escape_string($this->connection, $key);


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
            return $this->errorThrower("Cannot have a order parameter without a sort parameter");
        }

        if (isset($data['sort'])) {
            $rogue = $data['sort'];
            $sort = "";
            for ($i = 0; $i < count($rogue) - 1; $i++) {
                $temp = mysqli_real_escape_string($this->connection, $rogue[$i]);
                $sort = $sort . $temp . ',';
            }

            $temp = mysqli_real_escape_string($this->connection, $rogue[count($rogue) - 1]);
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
        var_dump($searchFeild);

        echo $query;
        $prepared = mysqli_prepare($this->connection, $query);
        if (!$prepared) {
            return $this->errorThrower("Error in query");

        }

        if ($params != "") {
            $prepared->bind_param($params, ...$searchFeild);
        }

        $prepared->execute();
        $res = $prepared->get_result();
        $formattedRes = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $this->messgaeFormatter($formattedRes);

    }


    private function setupSelectString($returnString) // handles the setup of the select part of the query statment though a passed in array of string values
    {
        $feilds = "";

        return $feilds;
    }

    private function messgaeFormatter($jsonResponse)
    { //formats the response for a return message on a successful request
        $response = array(
            'status' => "success",
            'data' => $jsonResponse
        );

        return json_encode($response);
    }


    private function errorThrower($message) //formats the response for a return message on a unsuccessful request
    {
        $data = array(
            'status' => 'failed',
            'data' => "error: " . $message
        );

        return json_encode($data);
    }

}


$queryResponse = reviewAPI::instance();
echo "posted";
echo ($queryResponse->wineTypeHandler());



?>