<?php

class Wineries{

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

    public function getWines($conn,$json)
    {
        $array = json_decode($json);//assuming a json object is passed in, we turn it into an asssociative array.
        $statement = null;
        $select_clause = implode(",",$array['return']);//gets all the values to be selected (returned)
        $statement .= "SELECT ".$select_clause." FROM `table`";//to be changed but the select is put in here. 
        $where_clause = null;//where clause used if search is specified
        $types = null;//this is just to ensure binding goes smoothly for SQL prepared statements i.e: ssss or iiii or sisisi etc.
        $params = array();//an array to store the parameters we are going to bind
        $fuzzy = false;//to fuzzy search the db or not
        if(key_exists('fuzzy',$array))//if fuzzy is specified then change it from the default value
        {
            $fuzzy = $array['fuzzy'];
        }
        if(key_exists('search',$array))//if we are required to search for specific values
        {
            $where_clause = " WHERE ";//assign values to the where clause
            $search = $array['search'];//make life easier and get the search array
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
        if(key_exists('sort',$array))//check if the data returned needs to be ordered by anything specific
        {
            $sorts = null;//to store the stuff to sort by
            $orderStuff = null;//to store the string
            if(!is_array($array['sort'])){//converts sort to array if not an array
                $orderStuff = $array['sort'];
            }
            else{//otherwise just implode that crap
                $sorts = $array['sort'];
                $orderStuff = implode(",",$sorts);
            }

            $oStr = " ORDER BY ".$orderStuff;//sets up the clause
            $statement.=$oStr;//adds the order by clause
        }
        if(key_exists('order',$array))//checks if asc or dsc specified
        {
            $typeO = $array['order'];//stores it
            if(!key_exists('sort',$array))//if no order by specified have a default
            {
                $statement.=" ORDER BY `ID` ".$typeO;//default order is by wineID
            }
            else{
                $statement.=" ".$typeO;//otherwise just add the parameter
            }
        }
        if(key_exists('limit',$array))//if we want to limit results
        {
            $statement.=" LIMIT ".$array['limit'];//limit them
        }
        if($query = $conn->mysqli->prepare($statement))
        {
            $query = $conn->mysqli->prepare($statement);
            if(key_exists('search', $array))
            {
                $query->bind_param($types,...$params);
            }
            $wineData = array();//contains the data that the user sees.
            $results = array();//this is to contain results of query
            $binding = array();//this is used to help create an associative array using results
            foreach($array['return'] as $column)
            {
                $results[$column] = null;//creates the associated key in results
                $binding[] =& $results[$column];//now we add the key value to each result key
            }
            $query->execute();//execute
            call_user_func_array(array($query,'bind_result'), $binding);//this now binds the results to the results array using bindings linkage
            while($query->fetch())//while there is data to fetch
            {
                $row = array();//a "new" row for each resulting row
                foreach($array['return'] as $column)//populating the row
                {
                    $row[$column] = $results[$column];
                }
                array_push($wineData, $row);//pushes into the wine obj
            }
            $query->close();//closes db connection
            return json_encode(array(
                "status" => "success",
                "data" => $wineData
            )); //return wines
        }
        else{
            header("HTTP/1.1 400 Bad Request");
                return json_encode(array(
                    "status" => "failed",
                    "data" => "Error. Bad request(Check return body parameters)"
            ));//returns an error object if you wanna call it that
        }
    }
}

?>