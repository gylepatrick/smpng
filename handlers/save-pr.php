<?php


include 'db.php';

$stock_no = $_POST['stock_no'];
$unit = $_POST['unit'];
$item_description = $_POST['item_description'];
$quantity = $_POST['quantity'];
$unit_cost = $_POST['unit_cost'];
$total_cost = $_POST['total_cost'];
// $pr_no = "1";
$type = $_POST['type'];
$consumable = $_POST['consumable'];

 // Retrieve the current maximum pr_no value from the database
 $query = "SELECT MAX(pr_no) AS max_pr_no FROM purchase_request";
 $resultPR = mysqli_query($conn, $query);

 if ($resultPR) {
    $row = mysqli_fetch_assoc($resultPR);
    $pr_no = $row['max_pr_no'] + 1; // Increment the max pr_no value by 1
  } else {
    $pr_no = 1; // Set the pr_no value to 1 if there are no existing records in the database
  }

for ($i = 0; $i < count($stock_no); $i++) {
    $query = "INSERT INTO purchase_request (stock_no, unit, item_description, quantity, unit_cost, total_cost, pr_no, type, consumable)
    VALUES ('" . $stock_no[$i] . "', '" . $unit[$i] . "', '" . $item_description[$i] . "', '" . $quantity[$i] . "', '" . $unit_cost[$i] . "', '" . $total_cost[$i] . "', '$pr_no' , '" . $type[$i] . "', '" . $consumable[$i] . "')";
    $result = mysqli_query($conn, $query);
}

if ($result) {
    $_SESSION['success'] = "Success!";
    header('Location: ../index.php');
} else {
    $_SESSION['error'] = "Error saving purchase request!";
}

mysqli_close($conn);

?>
