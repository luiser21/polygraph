<?
session_start();
include './clases/packege.php';
include './clases/diploma.class.php';
$ob = new diploma();
$ob->verDiploma();
?>
