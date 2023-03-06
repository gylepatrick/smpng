<?php
include 'db.php';

// Get the values from the form
$pr_no = $_POST['pr_no'];
$id = $_POST['id'];
$unit = $_POST['unit'];
$stock_no = $_POST['stock_no'];
$unit_cost = $_POST['unit_cost'];
$quantity = $_POST['quantity'];
$item_description = $_POST['item_description'];
$price = $_POST['price'];
$supplier_name = $_POST['supplier_name'];

// Update the data for each row
for ($i = 0; $i < count($id); $i++) {
    $sql = "INSERT INTO bidders(supplier_name, stock_no, pr_no, quantity, unit, unit_cost, item_description, price) VALUES('" . $supplier_name . "', '" . $stock_no[$i] . "', '" . $pr_no . "',  '" . $quantity[$i] . "', '" . $unit[$i] . "', '" . $unit_cost[$i] . "', '" . $item_description[$i] . "', '" . $price[$i] . "')";

    if (mysqli_query($conn, $sql)) {
        echo "Record saved successfully";
    } else {
        echo mysqli_error($conn);
    }
}
exit;
?>
