<?php 
session_start();
include('db.php');

$id = $_SESSION['id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

$pass_query = "SELECT * FROM users WHERE password = '$new_password' AND id != '$id'";
$pass_res = mysqli_query($conn, $pass_query);

if(mysqli_num_rows($pass_res) > 0) {
    $_SESSION['error_msg_q'] = 'Unable to update your password please provide a correct current password.';
    header('Location: ../profile.php');
} else {
    // Update the user's profile
    $update_query2 = "UPDATE users SET password = '$new_password' WHERE id = '$id'";
    $update_result2 = mysqli_query($conn, $update_query2);

    if($update_result2) {
        $_SESSION['success_msg2'] = 'Password Changed';
        header('Location: ../profile.php');
        exit();
    } else {
        $_SESSION['error_msg2'] = 'Update Error!';
        header('Location: ../profile.php');
        exit();
    }
}

mysqli_free_result($email_result);
mysqli_close($conn);

?>