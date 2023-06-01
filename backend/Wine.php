<?php




    /*
    The getAllWhines function is a separate function
    that works similarly to the getWines function.
    It is just used as an end point to fetch all
    information regarding the wine.
    */

    function getAllWines($conn,$json){
        $jsonObj = json_decode($json,true);//get as assc array
        $wines = array();//create an array to store data to be returned
        $stmt = "SELECT * FROM `wines`";//start of the statement
        $params = array();//this is an array used to store the bound params
        $fuzzy = $jsonObj['fuzzy'];//stores the value of fuzzy search
        $typeString = null;//stores the string of types for statement binding
        $wString = " WHERE";//where clause
        $specs = null;//specs are just certain search requirements
            if(key_exists('search', $jsonObj))//checks if we want to filter the data
            {
                $search = $json['search'];

                foreach($search as $key => $value)//constructs the search statement(well actually the where statement)
                {
                    if(array_key_last($search)!=$key)//to deal with the syntax of the where clause
                    {
                        $specs .=" ".$key." LIKE ? AND";
                    }
                    else{
                        $specs .=" ".$key." LIKE ?";
                    }
                    if($key=='ID' || $key=='Year' || $key=='Price' || $key=='WineryID')//if numeric value, then add i
                    {
                        $typeString.='i';
                    }
                    else{//if non numeric then add s
                        $typeString.='s';
                    }
                    if(!$fuzzy)//if fuzzy or not
                    {
                        array_push($params, $value);//exact value
                    }
                    else{
                        array_push($params, "%".$value."%");//substring of value
                    }                
                }
                $stmt.=$wString.$specs;//adds to the query statement
            }
            if(key_exists('sort',$jsonObj))//if data is to be sorted
            {
                $sorts = null;
                $orderStuff = null;//what to order by
                if(!is_array($jsonObj['sort'])){
                    $orderStuff = $jsonObj['sort'];//array of stuff to sort by
                }
                else{
                    $sorts = $jsonObj['sort'];
                    $orderStuff = implode(",",$sorts);//implode with commas to have the correct syntax
                }

                $oStr = " ORDER BY ".$orderStuff;//constructs the order by clause
                $stmt.=$oStr;//appends to the statement
            }
            if(key_exists('order',$jsonObj))//if we want to order by it
            {
                $typeO = $jsonObj['order'];//how we are going to sort ASC/DESC
                if(!key_exists('sort',$jsonObj))
                {
                    $stmt.=" ORDER BY `id` ".$typeO;//default order
                }
                else{
                    $stmt.=" ".$typeO;//append the statement
                }
            }

            if(key_exists('limit',$jsonObj))//if you want to limit the results returned
            {
                $stmt.=" LIMIT ".$jsonObj['limit'];//append
            }
            if($data = $conn->prepare($stmt))//check syntax and readiness
            {
                if(key_exists('search', $jsonObj))//if we are to search/filter/have specific where
                {
                    $data->bind_param($typeString,...$params);//binds parameters
                }
                $data->execute();//execute query
                $id = null;
                $name = null;
                $desc = null;
                $type = null;
                $year = null;
                $price = null;
                $winery = null;
                $data->bind_result($id,$name,$desc,$type,$year,$price,$winery);//bind result         
                while($data->fetch())//gets data
                {
                    $wines[] = [//sets up the array
                        'wine_id' => $id,
                        'name' => $name, 
                        'description' => $desc,
                        'type' => $type,
                        'year' => $year,
                        'price' => $price,
                        'winery' => $winery,
                    ];
                }
                $data->close();//close
                return json_encode(array(//return
                    "status" => "success",
                    "data" => $wines
                ));
            }
            else{//if there is an error
                header("HTTP/1.1 400 Bad Request");//handle it well
                return json_encode(array(
                    "status" => "failed",
                    "data" => "Error. Bad request(check return body spelling)"
            ));
        }
    }

    /*
    The Direct function is used
    as a routing function. Just
    checks the type of request made,
    then routes to separate functions.
    */

    function direct($conn,$json)
    {
        $jsonObj = json_decode($json,true);
        if($jsonObj['return']==["*"])
        {
            return getAllWines($conn,$json);
        }
        else{
            return getWines($conn,$json);
        }
    }
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

    function getWines($conn,$json)
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


?>