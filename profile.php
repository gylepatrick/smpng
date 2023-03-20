<?php include('header.php') ?>

<?php
session_start();
include('handlers/db.php');
$id = $_SESSION['id'];


$query = "SELECT * FROM users WHERE id = '$id'";
$res = mysqli_query($conn, $query);

if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $fullname = $row['fullname'];
    $username = $row['username'];
    $email = $row['email'];
    $password = $row['password'];
}

mysqli_free_result($result);
mysqli_close($conn);
?>

<div class="card col-10 mx-auto">

    <div class="card-header mt-2 bg-success">
        <b class="text-white">UPDATE PROFILE</b>
    </div>
    <div class="card-body border mb-2">
    <?php
    session_start();


    if (isset($_SESSION['success_msg1'])) {
        echo '<div class="success-message text-success col-10 mx-auto alert alert-success">' . $_SESSION['success_msg1'] . '</div>';
        unset($_SESSION['success_msg1']);
    }
    ?>
        <form action="handlers/update_profile.php" method="post">
            <div class="mb-3 col-10 mx-auto">
                <label for="">User Fullname</label>
                <input type="text" name="new_fullname" class="form-control" value="<?php echo $fullname ?>">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <label for="">User Username</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo $username ?>">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <label for="">User Email</label>
                <input type="text" name="new_email" class="form-control" value="<?php echo $email ?>" placeholder="<?php
                                                                                                                    if ($email != null) {
                                                                                                                        echo $email;
                                                                                                                    } else {
                                                                                                                        echo "No current Email";
                                                                                                                    }
                                                                                                                    ?>">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <input type="submit" value="Update Profile" class="btn btn-success">
            </div>
    </div>
    </form>
</div>


<div class="card col-10 mx-auto mt-3">
    <div class="card-header mt-2 bg-success">
        <b class="text-white">CHANGE PASSWORD</b>
    </div>
    <div class="card-body border mb-2">
    <?php
    session_start();


    if (isset($_SESSION['success_msg2'])) {
        echo '<div class="success-message text-success col-10 mx-auto alert alert-success">' . $_SESSION['success_msg2'] . '</div>';
        unset($_SESSION['success_msg2']);
    }
    if (isset($_SESSION['error_msg_q'])) {
        echo '<div class="success-message text-success col-10 mx-auto alert alert-success">' . $_SESSION['error_msg_q'] . '</div>';
        unset($_SESSION['error_msg_q']);
    }
    ?>                                                                                                  
        <form action="handlers/change_password.php" method="post">
            <div class="mb-3 col-10 mx-auto">
                <label for="">Current Password</label>
                <input type="password" name="current_password" class="form-control" value="<?php echo $password ?>">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <label for="">New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="New Password">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <label for="">Confirm New Password</label>
                <input type="password" name="confirm_new_password" class="form-control" placeholder="Confirm New Password">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <input type="submit" value="Change Password" class="btn btn-success">
            </div>
    </div>
    </form>
</div>

<?php include('footer.php') ?>