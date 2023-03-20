<?php include('header.php') ?>

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
                <div class="card-header text-white bg-success mt-2">
                    <b>Bidders</b>
                </div>
                <div class="card-body col-12 mx-auto border border-2 border-dark mb-2">
                    <?php
                    if (!empty($error)) {
                        echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                    }
                    ?>
                    <form class="col-12 mx-auto" method="post" action="handlers/add-bidder.php">
                        <input type="hidden" name="pr_no" value="<?php echo $pr_no; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input class="form-control" name="supplier_name" placeholder="Supplier Name" />
                        <table class="col-12 mx-auto">
                            <tr>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Unit Cost</th>
                                <th>Particulars</th>
                                <th>Proposed Price</th>

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
                                    $type = $row['type'];
                                    $availability = $row['availability'];
                            ?>

                                    <tr>
                                        <input type='hidden' class="form-control" name='id[]' value='<?php echo $id ?>'>
                                        <input type='hidden' class="form-control" name='stock_no[]' value='<?php echo $stock_no ?>'>

                                        </td>
                                        <td><input class="med-w form-control" type='text' name='quantity[]' value='<?php echo $quantity ?>'>
                                        </td>
                                        <td><input class="med-w form-control" type='text' name='unit[]' value='<?php echo $unit ?>'></td>
                                        <td><input type='text' class="form-control" name='unit_cost[]' value='<?php echo $unit_cost ?>'></td>
                                        <td><input type='text' class="form-control" name='item_description[]' value='<?php echo $item_description ?>'></td>
                                        <td><input type='text' class="form-control" name='price[]'></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                        <button class="btn btn-success" type="submit">Save</button>
                    </form>

                </div>
            </div>


            <!-- aosc start -->


            <div class="asc-card">
                <div class="card col-12 mx-auto mt-3">
                    <div class="card-header bg-dark text-white mt-2">
                        <b>ABSTRACT OF SEALED CANVAS</b>
                        <button class="btn btn-sm text-white float-right" type="button" id="print-card"><i class="fa fa-print"></i>
                            Print</button>
                    </div>
                    <div class="card-body p-0 col-12 mx-auto mb-2 border mb-3">
                        <div id="asc-card" class="col-12">
                            <div id="heading" style="display: flex; gap: 30%; align-items: center; justify-content: center; height: 100px;">
                                <img src="logo.webp" width="50px" alt="" srcset="">
                                <div style="display: flex; flex-direction: column; gap: 0; align-items: center; justify-content: center;">
                                    <p style="margin: 0; text-align: center;">Department of Education</p>
                                    <p style="margin: 0; font-size: 12px;">Region X - Northern Mindanao</p>
                                    <p style="margin: 0;">Division of Malayblay</p>
                                </div>
                                <img src="deped.png" width="50px" alt="" srcset="">
                            </div>

                            <div id="heading" style="display: flex; gap: 50%; align-items: center; justify-content: center; height: auto;">
                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin: 0; text-align: left;">Office/End: </p>
                                    <p style="margin: 0;">Date/Place:</p>
                                    <p style="margin: 0;">Package:</p>
                                </div>


                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin-bottom: 0; text-align: left;">PR No. : <span style="text-decoration: underline;">
                                            <?php echo date('Y') ?>-
                                            <?php echo $pr_no ?>
                                        </span></p>
                                </div>
                            </div>
                            <table class="table table-responsive mx-auto" style="margin-top: 20px; border-collapse: collapse;">
                                <?php
                                // Retrieve the unique supplier names for the specified pr_no
                                $query = "SELECT DISTINCT supplier_name FROM bidders WHERE pr_no = $pr_no";
                                $result = mysqli_query($conn, $query);

                                // Build an array of data for each supplier
                                $suppliers = array();
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $supplierName = $row['supplier_name'];
                                    $suppliers[$supplierName] = array();
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
                                    array_push($suppliers[$supplierName]['quantity'], $row['quantity']);
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
                                ?>
                                <thead style="border: 1px solid;">
                                    <th style="border: 1px solid; padding: 5px;">Quantity</th>
                                    <th style="border: 1px solid; padding: 5px;">Unit</th>
                                    <th style="border: 1px solid; padding: 5px;">Particulars</th>
                                    <?php
                                    foreach ($suppliers as $supplierName => $supplierData) {
                                    ?>
                                        <th style="border: 1px solid; padding: 5px;">
                                            <?php echo $supplierName ?>
                                        </th>
                                    <?php
                                    }
                                    ?>
                                    <th style="border: 1px solid; padding: 5px;">Lowest Complying Supplier</th>
                                </thead>

                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($suppliers[$supplierName]['quantity']); $i++) {
                                    ?>
                                        <tr>
                                            <td style="border: 1px solid; padding: 5px;">
                                                <?php echo $suppliers[$supplierName]['quantity'][$i] ?>
                                            </td>
                                            <td style="border: 1px solid; padding: 5px;">
                                                <?php echo $suppliers[$supplierName]['unit'][$i] ?>
                                            </td>
                                            <td style="border: 1px solid; padding: 5px;">
                                                <?php echo $suppliers[$supplierName]['item_description'][$i] ?>
                                            </td>
                                            <?php
                                            foreach ($suppliers as $supplierName => $supplierData) {
                                                $price = $supplierData['price'][$i];
                                                $isLowest = ($supplierName == $lowestBidder[$i]['supplier']) ? 'text-success' : '';
                                                echo '<td class="' . $isLowest . '" style="border: 1px solid; padding: 5px;">' . $price . '</td>';
                                            }
                                            ?>
                                            <td style="border: 1px solid; padding: 5px;">
                                                <strong>
                                                    <?php echo $lowestBidder[$i]['supplier'] ?>
                                                </strong>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div>
                                <p style="font-weight: bold; font-size: 12px; margin: 0;">AWARDED TO:</p>
                            </div>

                            <div id="heading" style="display: flex; gap: 10%; align-items: center; justify-content: center; height: auto;">
                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin: 0; text-align: left;">__________________</p>
                                    <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Member</p>
                                </div>


                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin: 0; text-align: left;">__________________</p>
                                    <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Member</p>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin: 0; text-align: left;">__________________</p>
                                    <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Member</p>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin: 0; text-align: left;">__________________</p>
                                    <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Chairman</p>
                                </div>

                            </div>


                            <div id="heading" style="display: flex; gap: 10%; align-items: center; justify-content: center; height: auto;">
                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin: 0; text-align: left;">__________________</p>
                                    <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">Supply Officer/
                                        <br>Office Custodian
                                    </p>
                                </div>


                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin: 0; text-align: left;">__________________</p>
                                    <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Member</p>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin: 0; text-align: left;">__________________</p>
                                    <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">Vice Chairman</p>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                                    <p style="margin: 0; text-align: left;">__________________</p>
                                    <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">Head of Procurment
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- end for aosc -->

            <button class="btn btn-sm text-dark float-right" type="button" id="card-print"><i class="fa fa-print"></i>
                Print</button>
            <div class="card col-md-12 mx-auto mt-3">
                <div class="card-header mt-3 bg-dark text-white">
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
                            <div class="card-body border" id="purchase" style="margin-bottom: 50%;">
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

                <div class="card col-md-12 mt-3 mx-auto" id="iaar">
                    <div class="card-header mt-3 bg-dark text-white">
                        <b>INSPECTION AND ACCEPTANCE REPORT</b>
                        <button class="btn btn-sm text-white float-right" type="button" id="card-print"><i class="fa fa-print"></i>
                            Print</button>
                    </div>
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
                                <div id="">
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

                    <script>
                        $('#card-print').click(function() {
                            var ccts = $('#cts-card').clone();


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
    $('#print-card').click(function () {
        var ccts = $('#asc-card').clone();
        var nw = window.open('', '_blank');
        nw.document.write('</head><body>');
        nw.document.write(ccts.html());
        nw.document.write('</body></html>');
        nw.document.close();
        nw.print();
        setTimeout(function () {
            window.close();
        }, 750);
    });
</script>

<?php include('footer.php') ?>