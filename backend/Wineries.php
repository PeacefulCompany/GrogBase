<?php
//include 'Config.php';

	$GLOBALS['conn'] = $connection;	// stores the MYSQLi connection in Config.php for easy access

	header('Content-Type: application/json');
	header('Cache-Control: no-cache, no-store, must-revalidate');
	header('Pragma: no-cache');
	header('Expires: 0');

	$input_json = json_decode(file_get_contents("php://input"),true);	// retrieve json from API call

	if(!isset($input_json['return']) || empty($input_json['return']))	//check if the return paramter is valid
	{
		header("HTTP/1.1 400 Bad Request");
		echo json_encode(array('status' => 'error','data' => 'Error: Empty Return Parameter'));
		exit();
	}

	if(isset($input_json['search'])){ //Check if the search param is specified
		$search = $input_json['search']; //stores the array of inputted search fields
	}

	if (isset($input_json['fuzzy'])) {
		$fuzzy = $input_json['fuzzy'];
	} else {
		$fuzzy = true;
	}

	if (isset($input_json['limit'])) { //Check if limit param is specified
		$limit = $input_json['limit']; //store limit param
	}

	if(isset($input_json['sort']))	//check if sort was specified
	{
		$sort = $input_json['sort']; 
	}
	else
	{
		$sort = null;	//getReturnRecords handles a null sort parameter
	}

	if(isset($input_json['order']))	//check if order was specified
	{
		if($input_json['order'] == "DESC" || $input_json['order'] == "ASC")//validate order parameter
		{
			$order = $input_json['order'];
		}
	}
	else
	{
		$order = "DESC";	//default order value
	}
	
	$return_pars = $input_json['return'];
	
	//This function's purpose is to return all records with specified fields from the return array
	//This output is then sorted if required and ordered accordingly.
	//Returns a json object
	function getReturnRecords($return_pars, $sort, $order, $search, $limit, $fuzzy)
	{	
		$placeholders = implode(", ", array_fill(0, count($return_pars), "?"));//set placeholers string eg: ?,?,?,?
		$query = "SELECT " . $placeholders . " FROM wineries";
		$types = str_repeat("s", count($return_pars));
		
		//The below if is actually pretty useless but not sure
		// if($return_pars[0] == "*")	
		// {
		// 	$return  = "*";
		// }
		
		if (isset($search)) {
			$query .= ' WHERE ';
			foreach ($search as $key => $value) {
				if ($fuzzy === true) {
					$query .=  $key . ' LIKE %' . $value . '% AND '; // Add each search param to the query
				} else {
					$query .=  $key . ' LIKE ' . $value . ' AND '; // Add each search param to the query
				}
			}
			$query = substr($query, 0, strlen($query) - 4); //Remove the final extra AND clause
		}

		if (isset($limit)) { // IF the limit param is specified
			$query .= 'LIMIT ' . $limit; //Add limit clause to the query
		}

		if(isset($sort))	//If sort is not null it will load the sort conditions
		{
			$sort_params = $sort;
		}
		else
		{
			$sort_params = "name";//  default sort value
			
		}

		if(isset($sort))
		{
			$query = $query." ORDER BY ".$sort_params." ".$order;
		}

		//Any code below this comment expectes the query to be have finished building
		$stmt = $GLOBALS['conn']->prepare($query); //prepare the statements
		$stmt->bind_param($types, ...$return_pars);
		$stmt->execute();

		$result = $stmt->get_result();

		$data = array();
		while($row = $result->fetch_assoc())
		{
			$data[] = $row;
		}
		$out = array('status' => 'success','data' => $data);
		echo json_encode($out);
	}
?>