<?php include('header.php') ?>
<style>
    label {
        font-size: 11px;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Purchase Request</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
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

                        <div class="card col-12 mx-auto mt-3">
                            <?php
                            session_start();
                            if (isset($_SESSION['success'])) {
                                echo "Success";
                            }
                            ?>
                            <div class="card-header mt-3 bg-dark text-white">
                                <b>PURCHASE REPORT NO. <?php echo  $pr_no; ?></b>
                            </div>
                            <div class="card-body border border-dark mb-2">
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
                                    <a href="update_purchase_request.php?pr_no=<?php echo $pr_no; ?>" class="btn btn-outline-dark text-dark">Update Availability</a>
                                    <a href="bidders.php?pr_no=<?php echo $pr_no; ?>" class="btn btn-dark mx-2 float-right mb-3">Add Bidders</a>
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
                                <a href="rpq.php?pr_no=<?php echo $pr_no; ?>">RPQ</a> |
                                <a href="aosc.php?pr_no=<?php echo $pr_no; ?>">Abstract of Sealed Canvas</a> |
                                <a href="bac.php?pr_no=<?php echo $pr_no; ?>">Purchase Order</a> |
                                <a href="inspection.php?pr_no=<?php echo $pr_no; ?>">Inspection and Acceptance Report</a> |
                                <a href="purchase-order.php?pr_no=<?php echo $pr_no; ?>">Inventory Costodian Slip</a>
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