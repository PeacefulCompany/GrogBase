<?php

class Wine{

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


    public function getAllWines($conn,$json){
        $jsonObj = json_decode($json,true);
        $wines = array();
        $stmt = "SELECT * FROM `wines`";
        $params = array();
        $fuzzy = $jsonObj['fuzzy'];
        $typeString = null;
        $wString = " WHERE";
        $specs = null;
            if(key_exists('search', $jsonObj))
            {
                $search = $jsonObj['search'];

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
                $stmt.=$wString.$specs;
            }
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
            if($data = $conn->prepare($stmt))
            {
                if(key_exists('search', $jsonObj))
                {
                    $data->bind_param($typeString,...$params);
                }
                $data->execute();
                $id = null;
                $name = null;
                $desc = null;
                $type = null;
                $year = null;
                $price = null;
                $winery = null;
                $data->bind_result($id,$name,$desc,$type,$year,$price,$winery);         
                while($data->fetch())
                {
                    $wines[] = [
                        'wine_id' => $id,
                        'name' => $name, 
                        'description' => $desc,
                        'type' => $type,
                        'year' => $year,
                        'price' => $price,
                        'winery' => $winery,
                    ];
                }
                $data->close();
                return json_encode(array(
                    "status" => "success",
                    "data" => $wines
                ));
            }
            else{
                header("HTTP/1.1 400 Bad Request");
                return json_encode(array(
                    "status" => "failed",
                    "data" => "Error. Bad request(check return body spelling)"
            ));
        }
    }

    public function direct($conn,$json)
    {
        $jsonObj = json_decode($json,true);
        if($jsonObj['return']==["*"])
        {
            return $this->getAllWines($conn,$json);
        }
        else{
            return $this->getWines($conn,$json);
        }
    }

    public function getWines($conn,$json)
    {
        $jsonObj = json_decode($json,true);//assuming a json object is passed in, we turn it into an asssociative array.
        $statement = null;
        $stuffs = array();
        $returns = array();
        $returns = $jsonObj['return'];
        foreach($returns as $val)
        {
            array_push($stuffs, $val);
        }
        $select_clause = implode(",",$stuffs);//gets all the values to be selected (returned)
        $statement .= "SELECT ".$select_clause." FROM `wines`";//to be changed but the select is put in here. 
        $where_clause = null;//where clause used if search is specified
        $types = null;//this is just to ensure binding goes smoothly for SQL prepared statements i.e: ssss or iiii or sisisi etc.
        $params = array();//an array to store the parameters we are going to bind
        $fuzzy = false;//to fuzzy search the db or not
        if(key_exists('fuzzy',$jsonObj))//if fuzzy is specified then change it from the default value
        {
            $fuzzy = $jsonObj['fuzzy'];
        }
        if(key_exists('search',$jsonObj))//if we are required to search for specific values
        {
            $where_clause = " WHERE ";//assign values to the where clause
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
        if($query = $conn->prepare($statement))
        {
            $query = $conn->prepare($statement);
            if(key_exists('search', $jsonObj))
            {
                $query->bind_param($types,...$params);
            }
            $wineData = array();//contains the data that the user sees.
            $results = array();//this is to contain results of query
            $binding = array();//this is used to help create an associative array using results
            foreach($jsonObj['return'] as $column)
            {
                $results[$column] = null;//creates the associated key in results
                $binding[] =& $results[$column];//now we add the key value to each result key
            }
            $query->execute();//execute
            call_user_func_array(array($query,'bind_result'), $binding);//this now binds the results to the results array using bindings linkage
            while($query->fetch())//while there is data to fetch
            {
                $row = array();//a "new" row for each resulting row
                foreach($jsonObj['return'] as $column)//populating the row
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