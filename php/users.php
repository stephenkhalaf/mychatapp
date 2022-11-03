<?php
session_start();
include_once "config.php";
$output = '';
$outgoing_id = $_SESSION['unique_id'];

$sql = mysqli_query($conn, "select * from users where unique_id != {$outgoing_id}");
if (mysqli_num_rows($sql) == 1) {
    $output .= "No users found";
} else if (mysqli_num_rows($sql) > 0) {
    include 'data.php';
}

echo $output;
