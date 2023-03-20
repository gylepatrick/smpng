<?php include('header.php') ?>

<?php
session_start();
include('handlers/db.php');
$id = $_SESSION['id'];


$query = "SELECT * FROM setting";
$res = mysqli_query($conn, $query);

if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $level = $row['level'];
    $school = $row['school'];
    $school_head = $row['school_head'];
    $book_keeper = $row['book_keeper'];
    $bac_chairman = $row['bac_cairman'];
    $bac_secretary = $row['bac_secretary'];

}

mysqli_free_result($result);
mysqli_close($conn);
?>

<div class="card col-10 mx-auto">

    <div class="card-header mt-2 bg-success">
        <b class="text-white">UPDATE SETTINGS</b>
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
                <label for="">School Level</label>
                <input type="text" name="new_fullname" class="form-control" value="<?php echo $level ?>">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <label for="">School Name</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo $school ?>">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <label for="">School Head</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo $school_head ?>">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <label for="">School BAC Chairman</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo $bac_chairman ?>">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <label for="">School BAC Secretary</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo $bac_secretary ?>">
            </div>

            <div class="mb-3 col-10 mx-auto">
                <input type="submit" value="Update Profile" class="btn btn-success">
            </div>
    </div>
    </form>
</div>
<?php include('footer.php') ?>