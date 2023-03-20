<?php 
session_start();
include('db.php');

$id = $_SESSION['id'];
$new_fullname = $_POST['new_fullname'];
$new_username = $_POST['new_username'];
$new_email = $_POST['new_email'];

$email_query = "SELECT * FROM users WHERE email = '$new_email' AND id != '$id'";
$email_result = mysqli_query($conn, $email_query);

if(mysqli_num_rows($email_result) > 0) {
    $_SESSION['error_msg1'] = 'This email is already taken by another user.';
    header('Location: ../profile.php');
} else {
    // Update the user's profile
    $update_query = "UPDATE users SET fullname = '$new_fullname', username = '$new_username', email = '$new_email' WHERE id = '$id'";
    $update_result = mysqli_query($conn, $update_query);

    if($update_result) {
        $_SESSION['success_msg1'] = 'Updated Successfully!';
        header('Location: ../profile.php');
        exit();
    } else {
        $_SESSION['error_msg1'] = 'Update Error!';
        header('Location: ../profile.php');
        exit();
    }
}

mysqli_free_result($email_result);
mysqli_close($conn);

?>