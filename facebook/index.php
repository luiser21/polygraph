<?php

$id_FB 		= $_REQUEST['id'];
$email_FB 	= $_REQUEST['email'];

$servername = "localhost";
$username 	= "root";
$password 	= "";
$dbname 	= "dna_music";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql ="SELECT id,id_facebook FROM dna_usuarios WHERE id_facebook = '".$id_FB."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	echo json_encode((object)array("res"=>$row["id_facebook"]));
} else {
 	$sql = "INSERT INTO dna_usuarios (id_facebook, email) VALUES ('".$id_FB."', '".$email_FB."')";
	
	if ($conn->query($sql) === TRUE) {
		echo json_encode((object)array("res"=>$id_FB));
	} else {
		echo json_encode((object)array("res"=>-1));
	}	
}

$conn->close();
?>


