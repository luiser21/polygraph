<?php

$datos= file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=Carrera+112f+72C-21,+Bogota&key=AIzaSyAFauKKZd09ZSEF7ZMvev6DdX2RV6mKgC4");
print_r($datos);

$obj=json_decode($datos,true);

echo "<pre>";	
print_R ($obj['results'][0]['geometry']['location']);
echo "</pre>";
?>
