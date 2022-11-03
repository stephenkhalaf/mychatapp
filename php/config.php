<?php
$conn = mysqli_connect('localhost', 'khalaf', 'royaldiva', 'chat');

if (!$conn) {
    echo 'Database not connected ' . mysqli_connect_error();
}
