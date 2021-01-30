<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_school");

if (isset($_GET['logout'])) {
	session_start();
	session_destroy();
	header("location: login.php");
}
?>