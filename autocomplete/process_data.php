<?php

//process_data.php

$connect = new PDO("mysql:host=localhost;dbname=polygraph", "cartas_db", "G8uMNWVE4XFTF6cX");

if(isset($_POST["query"]))
{	

	$data = array();

	$condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]);

	$query = "
	SELECT UPPER(NOMBRE) AS post_title  FROM empresas 
		WHERE NOMBRE LIKE '%".$condition."%' 
		ORDER BY id_empresa DESC 
		LIMIT 10
	";

	$result = $connect->query($query);

	$replace_string = '<b>'.$condition.'</b>';

	foreach($result as $row)
	{
		$data[] = array(
			'post_title'		=>	str_ireplace($condition, $replace_string, $row["post_title"])
		);
	}

	echo json_encode($data);
}

$post_data = json_decode(file_get_contents('php://input'), true);

if(isset($post_data['search_query']))
{

	$data = array(
		':search_query'		=>	$post_data['search_query']
	);

	$query = "
	SELECT search_id FROM recent_search 
	WHERE search_query = UPPER(:search_query)
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	if($statement->rowCount() == 0)
	{
		$query = "
		INSERT INTO recent_search 
		(search_query) VALUES (UPPER(:search_query))
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);
	}

	$output = array(
		'success'	=>	true
	);

	echo json_encode($output);

}

if(isset($post_data['action']))
{
	if($post_data['action'] == 'fetch')
	{
		$query = "SELECT * FROM recent_search ORDER BY search_id DESC LIMIT 10";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{

			$data[] = array(
				'id'				=>	$row['search_id'],
				'search_query'		=>	$row["search_query"]
			);
		}

		echo json_encode($data);
	}

	if($post_data['action'] == 'delete')
	{
		$query = "DELETE FROM recent_search WHERE search_id = '".$post_data["id"]."'";

		$connect->query($query);

		$output = array(
			'success'	=>	true
		);

		echo json_encode($output);
	}

}
?>