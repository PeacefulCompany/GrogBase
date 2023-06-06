<?php

require_once 'lib/Database.php';
require_once "lib/Controller.php";
function getWineries($controller)
{
	$input_json = $controller->get_post_json();
	$controller->assert_params(['return']);

    $limit = 20;

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

	getReturnRecords($controller,$return_pars, $sort, $order, $search, $limit, $fuzzy);
}
	//This function's purpose is to return all records with specified fields from the return array
	//This output is then sorted if required and ordered accordingly.
	//Returns a json object
function getReturnRecords($controller,$return_pars, $sort, $order, $search, $limit, $fuzzy)
{	
	$placeholders = implode(", ", $return_pars);
	$query = "SELECT " . $placeholders . " FROM wineries";
	$types = "";

	if (isset($search)) {
		$search_pars = array();
		$query .= ' WHERE ';
		foreach ($search as $key => $value) {
			if ($fuzzy === true) {
				$query .= $key . ' LIKE ? AND ';
				$value = '%' . $value . '%';
			} else {
				$query .= $key . ' LIKE ? AND ';
			}
			$types .= 's';
			array_push($search_pars, $value); //Add parameters for when stmnt is preapred
		}
		$query = substr($query, 0, strlen($query) - 4); //Remove the final extra AND clause
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
		"manager_id",
		"active"
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
	if (isset($limit)) { // IF the limit param is specified
		if (is_numeric($limit)) {
			$query .= ' LIMIT ' . $limit; //Add limit clause to the query
		}
	}
	//Any code below this comment expectes the query to be have finished building
	$db = new Database();
	$result = $db->query($query,$types,$search_pars);

	$controller->success($result);
}
function addWineries($controller){
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
	$input_json = $controller->get_post_json();
	$controller->assert_params(['wineries']);

	$wineries = array();// a variable to store all the wineries to be added
	$wineries = $input_json['wineries'];
	$params = array('name','description','established','location','region','country','website','manager_id');
	foreach ($wineries as $oneWinery) {
		if (count($oneWinery) !== 8) {
			throw new Exception('Too many or too few params',400);
		}
		foreach ($params as $oneParam) {
			if (!array_key_exists($oneParam, $oneWinery)) {
				throw new Exception('Missing data for ' . $oneParam,400);
			}
		}
	}
	addWineriesSQLCall($controller,$wineries);
}
function addWineriesSQLCall($controller,$wineries){
	//TODO if winery in database but inactive make active
	$query = "INSERT INTO wineries (name, description, established, location, region, country, website, manager_id) VALUES";
	$allParams = array();
	$params = array('name','description','established','location','region','country','website','manager_id');
	$types = "";
	foreach ($wineries as $oneWinery) {
		$query .= '(?, ?, ?, ?, ?, ?, ?, ?), ';
		foreach ($params as $oneParam) {
			array_push($allParams, $oneWinery[$oneParam]);
			if ($oneParam == 'manager_id' || $oneParam == 'established') {
				$types .= 'i';
			} else {
				$types .= 's';
			}
		}
	}
	$query = substr($query, 0, strlen($query) - 2);
	$query .= ' ';//changed semi-colon to space
	$db = new Database();
	$db->query($query,$types,$allParams);
	$controller->success("Winery Added Successfully");
}

function updateWinery($controller)
{
	$input_json = $controller->get_post_json();
	$controller->assert_params(['update']);
	
	$query = "UPDATE wineries SET ";
	$to_update = $input_json['update'];

	$columns = array();
	$values = array();
	$types = "";
	foreach($to_update as $key => $val)
	{	
		if ($key != 'winery_id') {
			if($key != "manager_id" && $key != "established" && $key != "winery_id")
			{
				$values[] = $val;
				$columns[] = $key.'=? ';//NON NUMERIC
				$types .= "s";
			}
			else
			{
				$values[] = $val;
				$columns[] = $key.'=? ';//NUMERIC
				$types .= "i";
			}
		}
	}
	$query .= implode(",",$columns);
	$query .= "WHERE winery_id = " . $input_json['update']['winery_id'];
	$db = new Database();
	$db->query($query,$types,$values);
	$controller->success("Winery Updated Successfully");
}
function deleteWinery($controller)
{
	//TODO assert params
	$input_json = $controller->get_post_json();
	$query = 'UPDATE wineries SET active = 0 WHERE winery_id = ?';
	$params = [$input_json['winery_id']];
	$db = new Database();
	$db->query($query, 'i', $params);
	$controller->success("Winery Set to Inactive");
}

function getCountries($controller)//returns a list of distinct countries in which there are wineries
{
	$input_json = $controller->get_post_json();
	$limit = $input_json['limit'];
	$db = new Database();
	$result = $db->get_column_distinct('wineries','country',$limit);
	$controller->success($result);
}

// $input = file_get_contents('php://input');

// $servername = "wheatley.cs.up.ac.za";
// $username = "u22512323";
// $password = "UFYT4LNTU7XNWZGY2NW7OR7FBYSBNNVW";

// $conn = new mysqli($servername, $username, $password);
// if ($conn->connect_error) {
// 	echo 'whoops';
// }
// $conn->query("USE u22512323_GrogBase;");

// deleteWinery($conn, $input);
?>
