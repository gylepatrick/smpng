<?php include('header.php') ?>
<style>
    label {
        font-size: 11px;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <?php
            include 'handlers/db.php';
            include 'datatables_exports/exports_cdn.php';

            $pr_no = $_GET['pr_no'];

            $total = "SELECT SUM(total_cost) AS total FROM purchase_request WHERE pr_no = $pr_no";
            $result1 = mysqli_query($conn, $total);



            if ($result1) {
                $row = mysqli_fetch_assoc($result1);
                $total = $row['total'];
            } else {
                echo "Error: " . mysqli_error($conn);
            }


            $query = "SELECT * FROM purchase_request WHERE pr_no = $pr_no";
            $result = mysqli_query($conn, $query);


            if ($result) {
            ?>

                <style>
                    a {
                        font-size: 20px;
                        font-weight: 500;
                        color: green;
                    }
                </style>

                <!-- NAVBAR -->
                <?php include 'partials/navbar.php' ?>

                <?php
                if (isset($_SESSION['success'])) {
                ?>
                    <div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
                        <strong></strong> <?php echo $_SESSION['success']; ?>
                        <button type="button" class="btn-close btn-success float-end" data-bs-dismiss="alert" aria-label="Close">x</button>
                    </div>
                <?php
                    unset($_SESSION['success']);
                } else if (isset($_SESSION['error'])) {
                ?>

                    <div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
                        <strong></strong> <?php echo $_SESSION['error']; ?>
                        <button type="button" class="btn-close btn-danger float-end" data-bs-dismiss="alert" aria-label="Close">x</button>
                    </div>

                <?php
                    unset($_SESSION['error']);
                }
                ?>
                 <a href="bidders.php?pr_no=<?php echo $pr_no; ?>" class="btn btn-success btn-sm mx-2 float-right mb-3">Go To Bidders ➙</a>

                <div class="card col-12 mx-auto mt-3">
                    <div class="card-header mt-3 bg-success text-white">
                        <b>PURCHASE REQUEST NO. <?php echo  $pr_no; ?></b>
                        <a href="update_purchase_request.php?pr_no=<?php echo $pr_no; ?>" class="btn btn-success text-white float-right">Update Availability</a>
                    </div>
                    <div class="card-body border mb-2">
                        <table class="table" id="prt">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid gray;">Stock/Property No.</th>
                                    <th style="border: 1px solid gray;">Unit</th>
                                    <th style="border: 1px solid gray;">Item Description</th>
                                    <th style="border: 1px solid gray;">Quantity</th>
                                    <th style="border: 1px solid gray;">Unit Cost</th>
                                    <th style="border: 1px solid gray;">Total Cost</th>
                                    <th style="border: 1px solid gray;">Type</th>
                                    <th style="border: 1px solid gray;">Available in PSDBM</th>
                                    <th style="border: 1px solid gray;">---</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td style="border: 1px solid gray;">
                                            <?php echo $row['stock_no']; ?>
                                        </td>
                                        <td style="border: 1px solid gray;">
                                            <?php echo $row['unit']; ?>
                                        </td>
                                        <td style="border: 1px solid gray;">
                                            <?php echo $row['item_description']; ?>
                                        </td>
                                        <td style="border: 1px solid gray;">
                                            <?php echo $row['quantity']; ?>
                                        </td>
                                        <td style="border: 1px solid gray;">
                                            ₱ <?php echo $row['unit_cost']; ?>
                                        </td>
                                        <td style="border: 1px solid gray;">
                                            ₱ <?php echo $row['total_cost']; ?>
                                        </td>
                                        <td style="border: 1px solid gray;">
                                            <?php
                                            if ($row['type'] == 1) {
                                                echo "Office Supplies";
                                            } else {
                                                echo "Non-Office Supplies";
                                            }
                                            ?>
                                        </td>
                                        <td style="border: 1px solid gray;">
                                            <?php if ($row['availability'] == 1) {
                                                echo "Available";
                                            } else {
                                                echo "Not Available";
                                            } ?>
                                        </td>

                                        <td style="border: 1px solid gray;">
                                            <?php if ($row['consumable'] == 1) {
                                                echo "Consumable";
                                            } else {
                                                echo "Non-Consumable";
                                            } ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <th colspan="8" class="text-center" style="border: 1px solid gray;">Total</th>
                                <th style="border: 1px solid gray;">
                                    ₱ <?php echo $total ?>
                                </th>
                            </tfoot>
                        </table>
                    </div>
                </div>


                <div class="card col-md-12 mx-auto mt-3 border border-white">
                    <div class="row card-body col-md-12 p-2 mx-auto mb-3    " style="gap: 10px">
                        <a href="view_pr_document.php?pr_no=<?php echo $pr_no; ?>">Purchase Request</a> |
                        <a href="view_apr_document.php?pr_no=<?php echo $pr_no; ?>">Agency Procurement Request</a> |
                        <a href="view_bac_document.php?pr_no=<?php echo $pr_no; ?>">BAC Resolution</a> |
                        <a href="view_rpq_document.php?pr_no=<?php echo $pr_no; ?>">RPQ</a> |
                        <a href="view_aosc_document.php?pr_no=<?php echo $pr_no; ?>">Abstract of Sealed Canvas</a> |
                        <a href="purchase_order.php?pr_no=<?php echo $pr_no; ?>">Purchase Order</a> |
                        <a href="iaar.php?pr_no=<?php echo $pr_no; ?>">Inspection and Acceptance Report</a> |
                        <a href="inventory_slip.php?pr_no=<?php echo $pr_no; ?>">Inventory Costodian Slip</a>
                    </div>
                </div>

            <?php
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
            ?>
            <script type="text/javascript">
                // $('#prt').DataTable({
                //     dom: 'lBfrtip',
                //     responsive: true,
                //     orderCellsTop: true,
                //     head: 'Hello',
                //     buttons: [
                //         'csv', 'print'
                //     ],
                // });
            </script>
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
            <span>Copyright &copy; Your Website 2021</span>
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