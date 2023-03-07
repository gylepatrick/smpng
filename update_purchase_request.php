<?php include('header.php') ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Purchase Request</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <?php
            include 'handlers/db.php';
            $pr_no = $_GET['pr_no'];
            $id = ''; // initialize the $id variable
            ?>

            <style>
                .small-w {
                    width: 50px;
                    text-align: center;
                }

                .med-w {
                    width: 70px;
                }

                input {
                    color: #000;
                }
            </style>
            <div class="card col-12 mx-auto mt-3">
                <?php
                session_start();
                if (isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                }
                ?>
                <div class="card-header mt-3 bg-dark text-white">
                    <b>UPDATE</b>
                </div>
                <div class="card-body mb-3 border col-12 mx-auto">
                    <form class="col-12 mx-auto" method="post" action="handlers/update_pr.php">
                        <input type="hidden" name="pr_no" value="<?php echo $pr_no; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <table class="col-12 mx-auto">
                            <tr>
                                <th>Stock No.</th>
                                <th>Unit</th>
                                <th>Item Description</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                                <th>Type</th>
                                <th>Availability</th>
                            </tr>
                            <?php
                            // Retrieve the data for the specified pr_no
                            $query = "SELECT * FROM purchase_request WHERE pr_no = $pr_no";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $stock_no = $row['stock_no'];
                                    $unit = $row['unit'];
                                    $item_description = $row['item_description'];
                                    $quantity = $row['quantity'];
                                    $unit_cost = $row['unit_cost'];
                                    $total_cost = $row['total_cost'];
                                    $availability = $row['availability'];
                            ?>

                                    <tr>
                                        <input type='hidden' class="form-control" name='id[]' value='<?php echo $id ?>'>
                                        <td><input class="small-w form-control" type='text' name='stock_no[]' value='<?php echo $stock_no ?>'></td>
                                        <td><input class="med-w form-control" type='text' name='unit[]' value='<?php echo $unit ?>'></td>
                                        <td><input type='text' class="form-control" name='item_description[]' value='<?php echo $item_description ?>'></td>
                                        <td><input class="med-w form-control" type='text' name='quantity[]' value='<?php echo $quantity ?>'></td>
                                        <td><input class="med-w form-control" type='text' name='unit_cost[]' value='<?php echo $unit_cost ?>'></td>
                                        <td><input class="med-w form-control" type='text' name='total_cost[]' value='<?php echo $total_cost ?>'></td>
                                        <td>
                                            <select class='form-select form-control' name='type[]'>
                                            <?php
                                                if ($row['type'] == 1) {
                                                ?>
                                                    <option class="selected" value="1">Old-Office Supplies</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option class="selected" value="2">Old-Non-office Supplies</option>
                                                <?php
                                                }
                                                ?>
                                                <option value="1">Office Supplies</option>
                                                <option value="2">Non-Office Supplies</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class='form-select form-control' name='availability[]'>
                                                <?php
                                                if ($row['availability'] == 1) {
                                                ?>
                                                    <option class="selected" value="1">Available</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option class="selected" value="1">Old-Not Available</option>
                                                <?php
                                                }
                                                ?>
                                                <option value="1">Available</option>
                                                <option value="2">Not Available</option>
                                            </select>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                        <button class="btn btn-success" type="submit">Update</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Project FART 2023</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<script>
    $(document).ready(function() {
        var formRow = $('.form-row:first');

        $('#add-row').click(function() {
            var newRow = $('<div class="form-row mt-3">' + formRow.html() + '</div>');
            newRow.find('.remove-row').click(function() {
                $(this).parent().remove();
            });
            $('#form-rows').append(newRow);
        });
    });
</script>

<?php include('footer.php') ?>