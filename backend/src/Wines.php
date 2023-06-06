<?php

// require_once "Skeleton/config.php";
require_once "lib/Database.php";
require_once "lib/Controller.php";

    /*--------------------------------------
    The get wines function returns a JSON obj
    that contains any attributes specified when
    making the request. To achieve this it will
    make use of dynamic query building. If any
    issues occur while fetching the data, the
    appropriate JSON object response will be 
    sent. To make life easier, please ensure
    that whatever is to be returned is in
    array format as such [x,y,z]. It alse
    needs to be noted that a database
    connection will need to be passed in.
    */

    function getAllWines($controller){
        $jsonObj = $controller->get_post_json();
        $wines = array();
        $stmt = "SELECT wines.*, COALESCE(AVG(reviews_wine.points), NULL) AS Avg_rating FROM `wines` LEFT JOIN reviews_wine ON wines.wine_id = reviews_wine.wine_id " ;
        $params = array();
        if(key_exists("fuzzy",$jsonObj))
        {
            $fuzzy = $jsonObj['fuzzy'];
        }
        $typeString = null;
        $wString = " WHERE wines.active=true";
        $specs = null;
            if(key_exists('search', $jsonObj))
            {
                $search = $jsonObj['search'];
                $wString .= " AND";
                foreach($search as $key => $value)
                {
                    if(array_key_last($search)!=$key)
                    {
                        $specs .=" ".$key." LIKE ? AND";
                    }
                    else{
                        $specs .=" ".$key." LIKE ?";
                    }
                    if($key=='ID' || $key=='Year' || $key=='Price' || $key=='WineryID')
                    {
                        $typeString.='i';
                    }
                    else{
                        $typeString.='s';
                    }
                    if(!$fuzzy)
                    {
                        array_push($params, $value);
                    }
                    else{
                        array_push($params, "%".$value."%");
                    }                
                }
            }
            $stmt.=$wString.$specs;
            if(!key_exists('sort',$jsonObj) && key_exists('order',$jsonObj))
            {
                throw new Exception("Cannot sort when there is nothing to order by. Check request body.", 400);
            }
            $stmt.= " GROUP BY wines.wine_id";
            if(key_exists('sort',$jsonObj))
            {
                $sorts = null;
                $orderStuff = null;
                if(!is_array($jsonObj['sort'])){
                    $orderStuff = $jsonObj['sort'];
                }
                else{
                    $sorts = $jsonObj['sort'];
                    $orderStuff = implode(",",$sorts);
                }

                $oStr = " ORDER BY ".$orderStuff;
                $stmt.=$oStr;
            }
            if(key_exists('order',$jsonObj))
            {
                $typeO = $jsonObj['order'];
                if(!key_exists('sort',$jsonObj))
                {
                    $stmt.=" ORDER BY `make` ".$typeO;
                }
                else{
                    $stmt.=" ".$typeO;
                }
            }

            if(key_exists('limit',$jsonObj))
            {
                $stmt.=" LIMIT ".$jsonObj['limit'];
            }
            $db = new Database;
            $res = $db->query($stmt,$typeString,$params);
            return $controller->success($res);
    }

    function direct($controller)
    {
        $jsonObj = $controller->get_post_json();
        if($jsonObj['return']==["*"])
        {
            return getAllWines($controller);
        }
        else{
            return getWines($controller);
        }
    }

    function getWines($controller)
    {
        $jsonObj = $controller->get_post_json();//assuming a json object is passed in, we turn it into an asssociative array.
        $statement = null;
        $stuffs = array();
        $returns = array();
        $returns = $jsonObj['return'];
        foreach($returns as $val)
        {
            if($val!="rating_avg")
            {
                array_push($stuffs, $val);
            }
        }
        if(in_array("rating_avg",$jsonObj['return']))
        {
            for($i = 0; $i < count($stuffs); $i++)
            {
                $stuffs[$i] = "wines.".$stuffs[$i];
            }
            $select_clause = implode(",",$stuffs);//gets all the values to be selected (returned)
            $statement .= "SELECT ".$select_clause.",COALESCE(avg_ratings.avg_rating, NULL) AS Avg_rating FROM wines LEFT JOIN (SELECT reviews_wine.wine_id, AVG(reviews_wine.points) AS avg_rating FROM reviews_wine GROUP BY reviews_wine.wine_id) AS avg_ratings ON wines.wine_id = avg_ratings.wine_id";//to be changed but the select is put in here.
        }
        else
        {
            $select_clause = implode(",",$stuffs);//gets all the values to be selected (returned)
            $statement .= "SELECT ".$select_clause." FROM `wines`";//to be changed but the select is put in here.
        }
        $where_clause = " WHERE wines.active=true ";//where clause used if search is specified
        $types = null;//this is just to ensure binding goes smoothly for SQL prepared statements i.e: ssss or iiii or sisisi etc.
        $params = array();//an array to store the parameters we are going to bind
        $fuzzy = false;//to fuzzy search the db or not
        if(key_exists('fuzzy',$jsonObj))//if fuzzy is specified then change it from the default value
        {
            $fuzzy = $jsonObj['fuzzy'];
        }
        if(key_exists('search',$jsonObj))//if we are required to search for specific values
        {
            $where_clause.= "AND ";//assign values to the where clause
            $search = $jsonObj['search'];//make life easier and get the search array
            foreach($search as $key => $value)//loop through it
            {
                if(array_key_last($search)!=$key)
                {
                    $where_clause.=$key." LIKE ? AND ";//append the where clause with the appropriate params
                }
                else{
                    $where_clause.=$key." LIKE ?";//this is if it is the last specified search property
                }
                if($key=='ID' || $key=='Year' || $key=='Price' || $key=='WineryID')//ensures that if the parameter is a number, we want to bind appropriately in the params array
                {
                    $types.='i';//appropriate binding
                }
                else{
                    $types.='s';//more appropriate binding
                }
                if(!$fuzzy)
                {
                    array_push($params,$value);//push it to the array as is if not fuzzy search
                }
                else{
                    array_push($params,'%'.$value.'%');//make fuzzy possible by looking where the specified is a substring of a value
                }
            }
        }
        $statement.=$where_clause;//add the where clause to the statement and all the conditions
        if(!key_exists('sort',$jsonObj) && key_exists('order',$jsonObj))
        {
            throw new Exception("Cannot specify order if there is nothing to sort by.",400);
        }
        if(key_exists('sort',$jsonObj))//check if the data returned needs to be ordered by anything specific
        {
            $sorts = null;//to store the stuff to sort by
            $orderStuff = null;//to store the string
            if(!is_array($jsonObj['sort'])){//converts sort to array if not an array
                $orderStuff = $jsonObj['sort'];
            }
            else{//otherwise just implode that crap
                $sorts = $jsonObj['sort'];
                $orderStuff = implode(",",$sorts);
            }

            $oStr = " ORDER BY ".$orderStuff;//sets up the clause
            $statement.=$oStr;//adds the order by clause
        }
        if(key_exists('order',$jsonObj))//checks if asc or dsc specified
        {
            $typeO = $jsonObj['order'];//stores it
            if(!key_exists('sort',$jsonObj))//if no order by specified have a default
            {
                $statement.=" ORDER BY `ID` ".$typeO;//default order is by wineID
            }
            else{
                $statement.=" ".$typeO;//otherwise just add the parameter
            }
        }
        if(key_exists('limit',$jsonObj))//if we want to limit results
        {
            $statement.=" LIMIT ".$jsonObj['limit'];//limit them
        }
        $db = new Database;
        $res = $db->query($statement,$types,$params);
        $controller->success($res);
    }

    function updateWine($controller)
    {
        $controller->assert_params(["id"]);
        $controller->assert_params(["details"]);
        $req = $controller->get_post_json();
        $details = $req['details'];
        $id = $req["id"];
        $statement = "UPDATE wines SET ";
        $updates = null;
        $params = array();
        $types = null;
        foreach($details as $key=>$value)
        {
            if(!($key==array_key_last($details)))
            {
                $updates.=$key."=?".",";
            }
            else{
                $updates.=$key."=? ";
            }
            array_push($params,$value);
            $types.='s';
        }
        $where = "WHERE wine_id=?";
        array_push($params,$id);
        $types.='s';
        $statement.=$updates.$where;
        $db = new Database;
        $db->query($statement,$types,$params);
        $controller->success("Update successful");
    }

    function deleteWine($controller)
    {
        $req = $controller->get_post_json();
        $controller->assert_params(['id']);
        $id = $req['id'];
        if($id==null || $id=="")
        {
            throw new Exception("The id of a wine to delete cannot be empty",400);
        }
        $params = array();
        array_push($params,$id);
        $query = "UPDATE wines SET active=false WHERE `wine_id` = ?";
        $db = new Database;
        $db->query($query, 'i', $params);
        $controller->success("Deletion successful");

    }

    function insertWine($controller)
    {
        $req = $controller->get_post_json();
        $controller->assert_params(["details"]);
        $details = $req['details'];
        assert_insert(["name","description","type","year","price","winery"],$details);
        asset_nulls($details);
        $query = "INSERT INTO wines(name,description,type,year,price,winery) VALUES (?,?,?,?,?,?)";
        $params = array();
        foreach($details as $value)
        {
            array_push($params,$value);
        }
        $db = new Database;
        $db->query($query,'sssiii',$params);
        $controller->success("Successfully inserted a new wine into the database!");
    }

    function asset_nulls($details)
    {
        foreach($details as $value)
        {
            if($value==null || $value=="")
            {
                throw new Exception("Missing attribute values in `details` from request body",400);
            }
        }
    }

    function assert_insert($required,$details) {
        $params = array_keys($details);
        $missing = array_values(array_diff($required, $params));
        if(empty($missing)) return;
        
        throw new Exception("missing POST parameters: " . json_encode($missing), 400);
    }

?>
