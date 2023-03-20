<?php include('header.php') ?>

<!-- Begin Page Content -->
<div class="container-fluid">
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

            <button class="btn btn-sm btn-success mb-3 text-white float-right" type="button" id="card-print"><i class="fa fa-print"></i>
                Print</button>


            <div class="card col-md-12 mt-3 mx-auto" id="iaar">
                <div class="card-header mt-3 bg-success text-white">
                    <b>INSPECTION AND ACCEPTANCE REPORT</b>
                </div>
                <di id="p_order">
                    <?php
                    // Retrieve the unique supplier names for the specified pr_no
                    $query = "SELECT DISTINCT supplier_name FROM bidders WHERE pr_no = $pr_no";
                    $result = mysqli_query($conn, $query);

                    // Build an array of data for each supplier
                    $suppliers = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $supplierName = $row['supplier_name'];
                        $suppliers[$supplierName] = array();
                        $suppliers[$supplierName]['stock_no'] = array();
                        $suppliers[$supplierName]['unit_cost'] = array();
                        $suppliers[$supplierName]['quantity'] = array();
                        $suppliers[$supplierName]['unit'] = array();
                        $suppliers[$supplierName]['item_description'] = array();
                        $suppliers[$supplierName]['price'] = array();
                    }

                    // Retrieve the data for the specified pr_no
                    $query = "SELECT * FROM bidders WHERE pr_no = $pr_no";
                    $result = mysqli_query($conn, $query);

                    // Build the data for each supplier
                    while ($row = mysqli_fetch_assoc($result)) {
                        $supplierName = $row['supplier_name'];
                        array_push($suppliers[$supplierName]['stock_no'], $row['stock_no']);
                        array_push($suppliers[$supplierName]['quantity'], $row['quantity']);
                        array_push($suppliers[$supplierName]['unit_cost'], $row['unit_cost']);
                        array_push($suppliers[$supplierName]['unit'], $row['unit']);
                        array_push($suppliers[$supplierName]['item_description'], $row['item_description']);
                        array_push($suppliers[$supplierName]['price'], $row['price']);
                    }

                    // Find the lowest bidder for each row
                    $lowestBidder = array();
                    foreach ($suppliers as $supplierName => $supplierData) {
                        for ($i = 0; $i < count($supplierData['quantity']); $i++) {
                            $price = $supplierData['price'][$i];
                            if (!isset($lowestBidder[$i]) || $price < $lowestBidder[$i]['price']) {
                                $lowestBidder[$i] = array(
                                    'supplier' => $supplierName,
                                    'price' => $price
                                );
                            }
                        }
                    }

                    // Loop through each bidder and create a table for each one
                    foreach ($suppliers as $supplierName => $supplierData) {
                        $itemsWon = array(); // array to hold the indexes of the items won by this supplier
                        for ($i = 0; $i < count($supplierData['quantity']); $i++) {
                            if ($supplierName == $lowestBidder[$i]['supplier']) {
                                array_push($itemsWon, $i);
                            }
                        }
                        if (count($itemsWon) > 0) {
                    ?>
                            <div class="card-body border" id="cts-card">
                                <div id="" style="height: 100%;">
                                    <table class="col-12 table table-bordered" style="width: 100%; border: 1px solid; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th style="border: 1px solid;" colspan="5">
                                                    <header style="display: flex; align-items: center; gap: 10%; justify-content: center;">
                                                        <img width="7%" src="logo.webp" alt="" srcset="">
                                                        <h5 style="text-align: center; font-size: 15px;"> PURCHASE REQUEST <br>
                                                            Department of Education <br> DIVISION OF MALAYBALAY CITY
                                                        </h5>
                                                        <img width="7%" src="deped.png" alt="" srcset="">
                                                    </header>
                                                    <table style="width: 100%;" class="table table-borderless">
                                                        <thead>
                                                            <tr style="text-align: left;">
                                                                <th colspan="3" style="margin-top: 0; font-size: 12px;">Entity Name:</th>
                                                                <th colspan="2" style="margin-top: 0; font-size: 12px;">Fund Cluster:</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="5" style="border: 1px solid;">
                                                    <div class="" style="display: flex; align-items: center; flex-direction: col; gap: 60%">
                                                        <p style="margin-top: 0; font-size: 12px;">Supplier: <span style="text-decoration: underline;"><?php echo $supplierName ?></span> </p>
                                                        <p style="margin-top: 0; font-size: 12px;">IAR No.:</p>
                                                    </div>

                                                    <div class="" style="display: flex; align-items: center; flex-direction: col; gap: 60%; margin-top: 0px;">
                                                        <p style="margin-top: 0; font-size: 12px;">P.O/A.P.R. No./Date: </p>
                                                        <p style="margin-top: 0; font-size: 12px;">Date.:</p>
                                                    </div>

                                                    <div class="" style="display: flex; align-items: center; flex-direction: col; gap: 56%; col-gap: 0;">
                                                        <p style="margin-top: 0; font-size: 12px;">Requisitioning Office/Dept: </p>
                                                        <p style="margin-top: 0; font-size: 12px;">Invoice No.:</p>
                                                    </div>

                                                    <div class="" style="display: flex; align-items: center; flex-direction: col; gap: 56%">
                                                        <p style="margin-top: 0; font-size: 12px;">Responsibility Center Code: </p>
                                                        <p style="margin-top: 0; font-size: 12px;">Date:</p>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="0" style="border: 1px solid; font-size: 12px;">Stock/Property No.</th>
                                                <th style="border: 1px solid; font-size: 12px;">Description</th>
                                                <th style="border: 1px solid; font-size: 12px;">Unit</th>
                                                <th style="border: 1px solid; font-size: 12px;">Quantity</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($itemsWon as $index) {

                                            $q = $supplierData['quantity'][$index];
                                            $uc = $supplierData['unit_cost'][$index];

                                            $total = $q * $uc;
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid; text-align: center; font-size: 12px;"><?php echo $supplierData['stock_no'][$index]; ?></td>
                                                <td style="border: 1px solid; text-align: center; font-size: 12px;"><?php echo $supplierData['item_description'][$index]; ?></td>
                                                <td style="border: 1px solid; text-align: center; font-size: 12px;"><?php echo $supplierData['unit'][$index]; ?></td>
                                                <td style="border: 1px solid; text-align: center; font-size: 12px;"><?php echo $supplierData['quantity'][$index]; ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th colspan="2" style="border: 1px solid; text-align: center;">TOTAL</th>
                                            <th colspan="4" style="border: 1px solid;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th colspan="2" style="border: 1px solid; text-align: center;">INSPECTION</th>
                                                <th colspan="2" style="border: 1px solid; text-align: center;">ACCEPTANCE</th>
                                            </tr>
                                            <tr>
                                                <th colspan="2" style="border: 1px solid;">
                                                    <div style="display: flex; justify-content: center; flex-direction: column; font-size: 12px; text-align: center;">
                                                        <p>Date Inspected: </p>
                                                        <p style="font-size: 11px; text-align: center;">[ ] Inspected, verified and <br> found in order as <br> to quantity and specifications</p>

                                                        <div class="" style="text-align: center; font-size: 14px;">
                                                            CYNTHIA G. OPLENARIA <br> <sub style="text-align: center;">Master Teacher II</sub>
                                                        </div>
                                                        <div class="" style="text-align: center; margin-top: 20px; font-size: 14px;">
                                                            JANE MARIE GUDITO <br> <sub style="text-align: center;">Inspection Officer</sub>
                                                        </div>

                                                        <div class="" style="text-align: center; margin-top: 20px; font-size: 14px;">
                                                            MA. LUISA L. GALAMITON <br> <sub style="text-align: center;">Inspection Officer</sub>
                                                        </div>

                                                        <div class="" style="text-align: center; margin-top: 20px; font-size: 14px;">
                                                            GWENDOLYN G. QUIRONG <br> <sub style="text-align: center;">Senior Book Keeper</sub>
                                                        </div>

                                                        <div class="" style="text-align: center; margin-top: 20px; font-size: 14px;">
                                                            ERNESTO DANDAN <br> <sub style="text-align: center;">SPTA President</sub>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th colspan="3" style="border: 1px solid;">
                                                    <div style="display: flex; justify-content: center; flex-direction: column; font-size: 12px; text-align: center;">
                                                        <p>Date Recieved: </p>
                                                        <p style="font-size: 14px; text-align: center;">[ ] Complete</p>
                                                        <p style="font-size: 14px; text-align: center;">[ ] Partial(pls. specify quantity)</p>

                                                        <div class="" style="text-align: center; margin-top: 20px; font-size: 14px; ">
                                                            <span style="text-decoration: underline;">JANINE M. NERICOA</span> <br> <sub style="text-align: center; text-decoration: none;">Property Officer</sub>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                    <?php
                        }
                    } ?>
                </di>

            </div>
        </div>
    </div>
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
<!-- End of Page Wrapper -->

<script>
    $('#card-print').click(function() {
        var ccts = $('#p_order').clone();


        var nw = window.open('', '_blank', );
        nw.document.write(ccts.html())
        nw.document.close()
        nw.print()
        setTimeout(function() {
            window.close()
        }, 750)
    })
</script>

<?php include('footer.php') ?>