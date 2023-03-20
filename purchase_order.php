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

            <button class="btn btn-sm mb-2 btn-success text-white float-right" type="button" id="card-print"><i class="fa fa-print"></i>
                Print</button>
            <div class="card col-md-12 mx-auto mt-3">
                <div class="card-header mt-3 bg-success text-white">
                    <b>PURCHASE ORDER</b>

                </div>
                <div id="p_order">
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
                            <div class="card-body border" id="purchase">
                                <div id="" style="height: 100%;">
                                    <header style="display: flex; align-items: center; gap: 10%;
   justify-content: center;">
                                        <img width="7%" src="logo.webp" alt="" srcset="">
                                        <h5 style="text-align: center;"> PURCHASE ORDER <br><span style="text-decoration: underline;">
                                                SUMPONG CENTRAL SCHOOL </span><br><span style="font-weight: normal;"> Sumpong, Malaybalay City
                                            </span>
                                        </h5>
                                        <img width="7%" src="deped.png" alt="" srcset="">
                                    </header>
                                    <br>
                                    <table style="border: 1px solid; width: 100%; border-collapse:
   collapse;">
                                        <thead>
                                            <tr style="text-align: left;">
                                                <th colspan="3" style="border: 1px solid;">Supplier: <span style="text-decoration: underline;"><?php echo $supplierName ?></span>
                                                    <br>
                                                    Address: <br> TIN:
                                                </th>
                                                <th colspan="3" style="border: 1px solid;">Purchase
                                                    Order
                                                    No: <br> Date: <br> Mode of Procurement:</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;" colspan="6">Gentlemen:
                                                    <br>
                                                    <span style="padding-left: 5%;"> Please furnish this
                                                        Office the
                                                        following articles subject to the terms and
                                                        connditions herein: </span>
                                                </td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <th colspan="3" style="border: 1px solid;">Place of
                                                    Delivery: <br> Date of Delivery:</th>
                                                <th colspan="3" style="border: 1px solid;">Delivery
                                                    Term:
                                                    <br> Payment term:
                                                </th>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th style="border: 1px solid; width: 10%;">Stock /
                                                    Property
                                                    No.</th>
                                                <th style="border: 1px solid;">Unit</th>
                                                <th style="border: 1px solid;">Description</th>
                                                <th style="border: 1px solid;">Quantity</th>
                                                <th style="border: 1px solid;">Unit Cost</th>
                                                <th style="border: 1px solid;">Amount</th>
                                            </tr>
                                            <?php
                                            foreach ($itemsWon as $index) {

                                                $q = $supplierData['quantity'][$index];
                                                $uc = $supplierData['unit_cost'][$index];

                                                $total = $q * $uc;
                                            ?>
                                                <tr>
                                                    <th style="border: 1px solid; text-align: center;"><?php echo $supplierData['stock_no'][$index] ?></th>
                                                    <td style="border: 1px solid; text-align: center;"><?php echo $supplierData['unit'][$index] ?></td>
                                                    <td style="border: 1px solid;"><?php echo $supplierData['item_description'][$index] ?></td>
                                                    <th style="border: 1px solid; text-align: center;"><?php echo $supplierData['quantity'][$index] ?></th>
                                                    <th style="border: 1px solid; text-align: right;"><?php echo $supplierData['unit_cost'][$index] ?></th>
                                                    <th style="border: 1px solid; text-align: right;"><?php echo $total ?></th>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th colspan="2" style="border: 1px solid; text-align: center;">TOTAL</th>
                                                <th colspan="4" style="border: 1px solid;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="padding-left: 5%;" colspan="6">In case of
                                                    failure
                                                    to make the full delivery withihn the
                                                    time specified above, a penalty of one-tenth (1/10)
                                                    of
                                                    one percent for every day of delay shall be imposed
                                                    on
                                                    the undlivered item/s.</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left: 10%;" colspan="3"><br>
                                                    Conforme:</td>
                                                <td style="padding-left: 10%;" colspan="3"><br> Very
                                                    truly
                                                    yours,</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;" colspan="3"><br>
                                                    _________________________________ <br><sub>
                                                        Signature over
                                                        Printed Name of Supplier </sub><br>____________________________
                                                    <br><sub>
                                                        Date </sub>
                                                </td>
                                                <td style="text-align: center;" colspan="3"> <span style="text-decoration: underline; font-weight:
                   bold;"><br> MARY FE C. GUMAYAO </span><br> <sub>Signature
                                                        over Printed Name
                                                        of Authorized Official </sub><br><span style="text-decoration: underline; font-weight:
                   bold;"> School Principal I </span><br>
                                                    <sub>Designation</sub>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="border: 1px solid;">Fund Cluster:
                                                    <br> Funds Available: <br><br><span style="text-decoration:
                   underline; font-weight: bold; float: left;
                   width:
                   100%; text-align: center;"> GWENDOLYN G. QUIRONG
                                                        <br><sub style="font-weight: normal;">
                                                            Administrative Assistant III</sub> </span>
                                                </td>
                                                <td colspan="3" style="border: 1px solid;">ORS/BURS No.:
                                                    <br> Date of the ORS/BURS: <br> Amount:
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <p style="font-style: italic; font-size: 11px;">Revised Purchase
                                        Order (PO) - Appendix 61 of the Government
                                        Accounting Manual (GAM) Volume 2 effective January 1, 2016</p>
                                </div>
                            </div>
                    <?php
                        }
                    } ?>



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


    // for aosc
    $('#print-card').click(function() {
        var ccts = $('#asc-card').clone();
        var nw = window.open('', '_blank');
        nw.document.write('</head><body>');
        nw.document.write(ccts.html());
        nw.document.write('</body></html>');
        nw.document.close();
        nw.print();
        setTimeout(function() {
            window.close();
        }, 750);
    });
</script>

<?php include('footer.php') ?>