<?php
session_start();

if (isset($_SESSION['unique_id'])) {
    include_once 'config.php';

    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (!empty($message)) {
        $sql = mysqli_query($conn, "insert into messages (incoming_msg_id, outgoing_msg_id, msg) values ({$incoming_id}, {$outgoing_id}, '{$message}')");
        if ($sql) {
            echo 'succesfull';
        } else {
            echo 'an error occurred';
        }
    }
} else {
    header('Location: ../login.php');
}
