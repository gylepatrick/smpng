<?php 
session_start();
include 'db.php';

$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$type = $_POST['type'];

// checks if username is already taken
$chck_username = "SELECT * FROM users WHERE username = '$username'";
$query = mysqli_query($conn, $chck_username);

if(mysqli_num_rows($query) > 0) {
    $_SESSION['error_reg1'] = 'Oh No! Seems like this username is already taken!';
    header('Location: ../register.php');

} else {
    // check the password and confirm password
    if($password == $confirm_password) {
        // check if admin account exists
        if ($type == 1 && admin_exists()) {
            $_SESSION['error_reg_admin'] = 'Oh No! An admin user already exists.';
            header('Location: ../register.php');
            exit(); // stops the code execution
        }

        if ($password < 8) {
            $_SESSION['error_lenght'] = 'Password must be atleast 8 characters long!';
            header('Location: ../register.php');
            exit();
        }

        $save = "INSERT INTO users(fullname, username, password, type) VALUES('".$fullname."', '".$username."', '".$password."', '".$type."')";
        $res = mysqli_query($conn, $save);

        if($res) {
            $_SESSION['success_reg'] = 'Alright! You have created your account, you can now proceed to login.';
            header('Location: ../register.php');
        }


    } else {
        $_SESSION['error_reg2'] = 'Oh No! Password did not match!';
        header('Location: ../register.php');
    }
}

mysqli_free_result($result);
mysqli_close($conn);

function admin_exists() {
    // check if an admin user already exists in the database
    include 'db.php'; // include your database connection details
    $query = "SELECT * FROM users WHERE type = 1";
    $result = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($result);
    mysqli_free_result($result);
    mysqli_close($conn);
    return $num_rows > 0;
}
