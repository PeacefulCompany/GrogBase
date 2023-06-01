<?php

function getWineries($conn,$json)
{
	$input_json = json_decode($json);
	if(!isset($input_json['return']) || empty($input_json['return']))	//check if the return paramter is valid
	{
		header("HTTP/1.1 400 Bad Request");
		echo json_encode(array('status' => 'error','data' => 'Error: Wineries Empty Return Parameter'));
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

	getReturnRecords($conn,$return_pars, $sort, $order, $search, $limit, $fuzzy);
}
	
	
	//This function's purpose is to return all records with specified fields from the return array
	//This output is then sorted if required and ordered accordingly.
	//Returns a json object
function getReturnRecords($conn,$return_pars, $sort, $order, $search, $limit, $fuzzy)
{	
	$placeholders = implode(", ", array_fill(0, count($return_pars), "?"));//set placeholers string eg: ?,?,?,?
	$query = "SELECT " . $placeholders . " FROM wineries";
	$types = str_repeat("s", count($return_pars));
	
	if (isset($search)) {
		$search_pars = array();
		$query .= ' WHERE ';
		foreach ($search as $key => $value) {
			if ($fuzzy === true) {
				$query .= '? LIKE %?% AND ';
			} else {
				$query .= '? LIKE ? AND ';
			}
			$types .= 'ss';
			array_push($search_pars, $key, $value); //Add parameters for when stmnt is preapred
		}
		$query = substr($query, 0, strlen($query) - 4); //Remove the final extra AND clause
	}

	if (isset($limit)) { // IF the limit param is specified
		if (is_numeric($limit)) {
			$query .= 'LIMIT ' . $limit; //Add limit clause to the query
		}
	}
	$sort_fields = array(
		"winery_id",
		"name",
		"description",
		"established",
		"location",
		"region",
		"country",
		"website",
		"manager_id"
	);
	
	if(isset($sort) && in_array($sort, $sort_fields))	//If sort is not null or doesn't exist it will load the sort conditions
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
	$stmt = $conn->prepare($query); //prepare the statements
	$stmt->bind_param($types, ...$return_pars, ...$search_pars);
	$stmt->execute();

	$result = $stmt->get_result();

	if(!$result)
	{
		header("HTTP/1.1 400 Bad Request");
		echo json_encode(array('status' => 'error','data' => 'Error: Wineries SQL Error'));
		exit();
	}

	$data = array();
	while($row = $result->fetch_assoc())
	{
		$data[] = $row;
	}
	$out = array('status' => 'success','data' => $data);
	header("HTTP/1.1 200 OK");
	echo json_encode($out);
}
function addWineries($conn, $json){
	/*As an example, We expect
	{
		"type":"addWineries",
		"apikey":"a9198b68355f78830054c31a39916b7f",
		"wineries":[
			{
				"name": "",
				"description": "",
				"established": "",
				"location": "",
				"region": "",
				"country": "",
				"website": "",
				"manger_id": ""
			},
			{
				"name": "",
				"description": "",
				"established": "",
				"location": "",
				"region": "",
				"country": "",
				"website": "",
				"manger_id": ""
			}
			]
		}
		*/
	$input_json = json_decode($json);
	$wineries = array();// a variable to store all the wineries to be added
	$wineries = $input_json['wineries'];
	$params = array('name','description','established','location','region','country','website','manger_id');
	foreach ($wineries as $oneWinery) {
		if (count($oneWinery) !== 8) {
			header("HTTP/1.1 400 Bad Request");
			echo json_encode(array('status' => 'error','data' => 'Too many or too few params'));
			exit();
		}
		foreach ($params as $oneParam) {
			if (!array_key_exists($oneParam, $oneWinery)) {
				header("HTTP/1.1 400 Bad Request");
				echo json_encode(array('status' => 'error','data' => ('Missing data for ' . $oneParam)));
				exit();
			}
		}
	}
	addWineriesSQLCall($conn, $wineries);
}
function addWineriesSQLCall($conn, $wineries){
	$query = "INSERT INTO wineries (name, description, established, location, region, country, website, manger_id) VALUES";
	$allParams = array();
	$params = array('name','description','established','location','region','country','website','manger_id');
	$types = "";
	foreach ($wineries as $oneWinery) {
		$query .= '(?, ?, ?, ?, ?, ?, ?, ?), ';
		foreach ($params as $oneParam) {
			array_push($allParams, $oneWinery[$oneParam]);
			if ($oneParam == 'manager_id') {
				$types .= 'i';
			} else {
				$types .= 's';
			}
		}
	}
	$query = substr($query, 0, strlen($query) - 2);
	$query .= ' ';//changed semi-colon to space
	$stmt = $conn->prepare($query); //prepare the statements
	$stmt->bind_param($types, ...$allParams);
	try {
		$stmt->execute();
	} catch (\Throwable $th) {
		header("HTTP/1.1 400 Bad Request");
		echo json_encode(array('status' => 'error','data' => ('SQL error with statement' . $stmt->debugDumpParams())));

	}
	header("HTTP/1.1 200 OK");
	die();
}

?>