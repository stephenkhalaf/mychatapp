<?php
session_start();
include_once "config.php";

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);


if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($conn, "select email from users where email = '{$email}' ");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email - This user already exist";
        } else {
            if (isset($_FILES['image']['name'])) {
                $img_name = $_FILES['image']['name'];
                $temp_name = $_FILES['image']['tmp_name'];
                $img_type = $_FILES['image']['type'];

                $extensions = ['png', 'jpg', 'jpeg'];
                $img_explode = explode('.', $img_name);
                $img_ext = strtolower(end($img_explode));
                $folder = 'uploads/';
                if (in_array($img_ext, $extensions) === true) {
                    if (!file_exists($folder)) {
                        mkdir('uploads', 0777, true);
                    }
                    $time = time();
                    $new_img_name =  $time . $img_name;
                    if (move_uploaded_file($temp_name, $folder . $new_img_name)) {
                        $status = 'Active now';
                        $random_id = rand(time(), 10000000);

                        $sql2 = mysqli_query($conn, "insert into users (unique_id,fname,lname,email,password,img,status)
                                                     values ({$random_id},'{$fname}', '{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}')");


                        if ($sql2) {
                            $sql3 = mysqli_query($conn, "select * from users where email = '{$email}'");
                            if (mysqli_num_rows($sql3) > 0) {
                                $row = mysqli_fetch_assoc($sql3);
                                $_SESSION['unique_id'] = $row['unique_id'];
                                echo "success";
                            }
                        } else {
                            echo "Something went wrong!";
                        }
                    }
                } else {
                    echo "Please, select an image file of type jpg,png,jpeg";
                }
            }
        }
    } else {
        echo "$email - This is not a valid email";
    }
} else {
    echo "All fields are reuired";
}
