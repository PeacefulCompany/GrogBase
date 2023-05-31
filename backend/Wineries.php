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
			$order = $input_json['sort'];
		}
	}
	else
	{
		$order = "DESC";	//default order value
	}

	$return_pars = $input_json['return'];

	//This function's purpose is to return all records with specified fields from the return array
	//This output is then sorted if required and ordered accordingly.
	//Returns a php array of records
	function getReturnRecords($return_pars, $sort, $order)
	{	
		$placeholders = implode(", ", array_fill(0, count($return_pars), "?"));//set placeholers string eg: ?,?,?,?
		$query = "SELECT " . $placeholders . " FROM wineries";

		if($return_pars == "*")	//if wildcard is specified set that is the SQL parameter
		{
			$params = "*";
		}
		else
		{
			$params = implode(",",$return_pars);
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
		$stmt = $GLOBALS['conn']->prepare($query);
		$types = str_repeat("s", count($return_pars));
		$stmt->bind_param($types, ...$return_pars);

		$result = $GLOBALS['conn']->query($query);
	}
?>