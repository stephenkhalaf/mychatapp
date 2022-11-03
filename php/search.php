<?php
session_start();
include_once 'config.php';
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
$output = '';
$outgoing_id = $_SESSION['unique_id'];
$sql = mysqli_query($conn, "select * from users where unique_id != {$outgoing_id} and (fname like '%{$searchTerm}%' or lname like '%{$searchTerm}%')");

if (mysqli_num_rows($sql) > 0) {
    include 'data.php';
} else {
    $output .= "No user is found with that search term";
}
echo $output;
