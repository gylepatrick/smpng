<?php
 include('db.php');
if(isset($_POST['submit'])){
    $pr_no = $_POST['pr_no'];
    
    // prepare the SQL statement to delete the record
    $sql = "DELETE FROM purchase_request WHERE pr_no = $pr_no";
    
    // execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_del'] = "Record Deleted";
        header('Location: ../home.php');
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    // close the database connection
    $conn->close();
}
?>
