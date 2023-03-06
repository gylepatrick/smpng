<?php
include 'db.php';


$pr_no = $_POST['pr_no'];
// Get the values from the form
$id = $_POST['id'];
$stock_no = $_POST['stock_no'];
$unit = $_POST['unit'];
$item_description = $_POST['item_description'];
$quantity = $_POST['quantity'];
$unit_cost = $_POST['unit_cost'];
$total_cost = $_POST['total_cost'];
$type = $_POST['type'];
$availability = $_POST['availability'];

// Update the data for each row
for ($i = 0; $i < count($id); $i++) {
  $sql = "UPDATE purchase_request SET
          stock_no = '$stock_no[$i]',
          unit = '$unit[$i]',
          item_description = '$item_description[$i]',
          quantity = '$quantity[$i]',
          unit_cost = '$unit_cost[$i]',
          total_cost = '$total_cost[$i]',
          type = '$type[$i]',
          availability = '$availability[$i]'
          WHERE id = $id[$i]";

  if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
}
exit;
?>
