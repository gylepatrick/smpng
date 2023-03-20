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
            <div class="card col-md-12 mx-auto mt-3">
                <div class="card-header mt-3 bg-success text-white">
                    <b>INVENTORY SLIP</b>
                    <button class="btn btn-sm btn-success float-right" type="button" id="print-card"><i class="fa fa-print"></i>
                        Print</button>
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
                                <div id="cts-card" style="height: 100%;">
                                    <header style="display: flex; align-items: center; gap: 10%;
                justify-content: center;">
                                        <img width="7%" src="logo.webp" alt="" srcset="">
                                        <h5 style="text-align: center;">INVNETORY CUSTODIAN SLIP <br><span style="font-weight: normal;">
                                                Department of Education </span><br>
                                            DIVISION OF MALAYBALAY CITY
                                        </h5>
                                        <img width="7%" src="deped.png" alt="" srcset="">
                                    </header>
                                    <br>
                                    <table style=" width: 100%; border-collapse: collapse;">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="text-align: left;" colspan="6">Entity Name: <br> Fund Cluster: </th>
                                                <th style="text-align: left;">ICS No.</th>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th style="border: 1px solid;">QUANTITY</th>
                                                <th style="border: 1px solid;">UNIT</th>
                                                <th style="border: 1px solid;">Unit Cost</th>
                                                <th style="border: 1px solid;">Total Cost</th>
                                                <th style="border: 1px solid;">DESCRIPTION</th>
                                                <th style="border: 1px solid;">INVENTORY ITEM NO.</th>
                                                <th style="border: 1px solid;">ESTIMATED USEFUL LIFE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($itemsWon as $index) {

                                                $q = $supplierData['quantity'][$index];
                                                $uc = $supplierData['unit_cost'][$index];

                                                $total = $q * $uc;
                                            ?>
                                                <tr style="text-align: center;">
                                                    <td style="border: 1px solid;"><?php echo $supplierData['quantity'][$index] ?></td>
                                                    <td style="border: 1px solid;"><?php echo $supplierData['unit'][$index] ?></td>
                                                    <td style="border: 1px solid; text-align: right;"><?php echo $supplierData['unit_cost'][$index] ?></td>
                                                    <td style="border: 1px solid; text-align: right;"><?php echo $total ?></td>
                                                    <td style="border: 1px solid; text-align: left;"><?php echo $supplierData['item_description'][$index] ?></td>
                                                    <td style="border: 1px solid;"> </td>
                                                    <td style="border: 1px solid;"> </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot style="text-align: center;">
                                            <tr>
                                                <td style="border: 1px solid; text-align: left;" colspan="5">Received from: <b><?php echo $supplierName ?></b> </td>
                                                <td style="border: 1px solid; text-align: left;" colspan="2">Received by:</td>
                                            </tr>
                                            <tr>
                                                <th style="border: 1px solid;" colspan="5">JANINE M.
                                                    NERICOA</th>
                                                <th style="border: 1px solid;" colspan="2">MARY FE C.
                                                    GUMAYAO</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;" colspan="5">Signature
                                                    over Printed Name</td>
                                                <td style="border: 1px solid;" colspan="2">Signature
                                                    over Printed Name</td>
                                            </tr>
                                            <tr>
                                                <th style="border: 1px solid;" colspan="5">Supply
                                                    Officer / Property Custodian</th>
                                                <th style="border: 1px solid;" colspan="2">School
                                                    Principal I</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;" colspan="5">Position /
                                                    Office</td>
                                                <td style="border: 1px solid;" colspan="2">Position /
                                                    Office</td>
                                            </tr>
                                            <tr>
                                                <th style="border: 1px solid;" colspan="5">13-Oct-23</th>
                                                <th style="border: 1px solid;" colspan="2">13-Oct-23</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;" colspan="5">Date</td>
                                                <td style="border: 1px solid;" colspan="2">Date</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <p style="color: red; font-weight: bold; font-style: italic;">COPY 1</p>
                                    <hr style="border-top: 3px dashed black; background-color: white;">
                                    <header style="display: flex; align-items: center; gap: 10%;
                justify-content: center;">
                                        <img width="7%" src="logo.webp" alt="" srcset="">
                                        <h5 style="text-align: center;">INVNETORY CUSTODIAN SLIP <br><span style="font-weight: normal;">
                                                Department of Education </span><br>
                                            DIVISION OF MALAYBALAY CITY
                                        </h5>
                                        <img width="7%" src="deped.png" alt="" srcset="">
                                    </header>
                                    <br>
                                    <table style=" width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th style="text-align: left;" colspan="6">Entity Name: <br> Fund Cluster: </th>
                                                <th style="text-align: left;">ICS No.</th>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th style="border: 1px solid;">QUANTITY</th>
                                                <th style="border: 1px solid;">UNIT</th>
                                                <th style="border: 1px solid;">Unit Cost</th>
                                                <th style="border: 1px solid;">Total Cost</th>
                                                <th style="border: 1px solid;">DESCRIPTION</th>
                                                <th style="border: 1px solid;">INVENTORY ITEM NO.</th>
                                                <th style="border: 1px solid;">ESTIMATED USEFUL LIFE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($itemsWon as $index) {

                                                $q = $supplierData['quantity'][$index];
                                                $uc = $supplierData['unit_cost'][$index];

                                                $total = $q * $uc;
                                            ?>
                                                <tr style="text-align: center;">
                                                    <td style="border: 1px solid;"><?php echo $supplierData['quantity'][$index] ?></td>
                                                    <td style="border: 1px solid;"><?php echo $supplierData['unit'][$index] ?></td>
                                                    <td style="border: 1px solid; text-align: right;"><?php echo $supplierData['unit_cost'][$index] ?></td>
                                                    <td style="border: 1px solid; text-align: right;"><?php echo $total ?></td>
                                                    <td style="border: 1px solid; text-align: left;"><?php echo $supplierData['item_description'][$index] ?></td>
                                                    <td style="border: 1px solid;"> </td>
                                                    <td style="border: 1px solid;"> </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot style="text-align: center;">
                                            <tr>
                                                <td style="border: 1px solid; text-align: left;" colspan="5">Received from: <b><?php echo $supplierName ?></b> </td>
                                                <td style="border: 1px solid; text-align: left;" colspan="2">Received by:</td>
                                            </tr>
                                            <tr>
                                                <th style="border: 1px solid;" colspan="5">JANINE M.
                                                    NERICOA</th>
                                                <th style="border: 1px solid;" colspan="2">MARY FE C.
                                                    GUMAYAO</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;" colspan="5">Signature
                                                    over Printed Name</td>
                                                <td style="border: 1px solid;" colspan="2">Signature
                                                    over Printed Name</td>
                                            </tr>
                                            <tr>
                                                <th style="border: 1px solid;" colspan="5">Supply
                                                    Officer / Property Custodian</th>
                                                <th style="border: 1px solid;" colspan="2">School
                                                    Principal I</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;" colspan="5">Position /
                                                    Office</td>
                                                <td style="border: 1px solid;" colspan="2">Position /
                                                    Office</td>
                                            </tr>
                                            <tr>
                                                <th style="border: 1px solid;" colspan="5"><?php echo date('d-M-Y') ?></th>
                                                <th style="border: 1px solid;" colspan="2"><?php echo date('d-M-Y') ?></th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;" colspan="5">Date</td>
                                                <td style="border: 1px solid;" colspan="2">Date</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <p style="color: red; font-weight: bold; font-style: italic;">COPY 2</p>
                                </div>

                        <?php
                        }
                    } ?>



                        <script>
                            $('#print-card').click(function() {
                                var ccts = $('#p_order').clone();

                                // add CSS to set print size
                                ccts.attr('style', 'width: 200mm; height: 300mm;');

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