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
<?php include 'partials/navbar.php' ?>

<div class="asc-card">
    <div class="card col-12 mx-auto mt-3">
        <div class="card-header bg-success text-white mt-2">
            <b>ABSTRACT OF SEALED CANVAS</b>
            <button class="btn btn-sm text-white float-right" type="button" id="print-card"><i class="fa fa-print"></i>
                Print</button>
        </div>
        <div class="card-body p-0 col-12 mx-auto mb-2 border mb-3">
            <div id="asc-card" class="col-12">
                <div id="heading"
                    style="display: flex; gap: 30%; align-items: center; justify-content: center; height: 100px;">
                    <img src="logo.webp" width="50px" alt="" srcset="">
                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: center; justify-content: center;">
                        <p style="margin: 0; text-align: center;">Department of Education</p>
                        <p style="margin: 0; font-size: 12px;">Region X - Northern Mindanao</p>
                        <p style="margin: 0;">Division of Malayblay</p>
                    </div>
                    <img src="deped.png" width="50px" alt="" srcset="">
                </div>

                <div id="heading"
                    style="display: flex; gap: 50%; align-items: center; justify-content: center; height: auto;">
                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin: 0; text-align: left;">Office/End: </p>
                        <p style="margin: 0;">Date/Place:</p>
                        <p style="margin: 0;">Package:</p>
                    </div>


                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin-bottom: 0; text-align: left;">PR No. : <span
                                style="text-decoration: underline;">
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

                <div id="heading"
                    style="display: flex; gap: 10%; align-items: center; justify-content: center; height: auto;">
                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin: 0; text-align: left;">__________________</p>
                        <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Member</p>
                    </div>


                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin: 0; text-align: left;">__________________</p>
                        <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Member</p>
                    </div>

                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin: 0; text-align: left;">__________________</p>
                        <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Member</p>
                    </div>

                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin: 0; text-align: left;">__________________</p>
                        <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Chairman</p>
                    </div>

                </div>


                <div id="heading"
                    style="display: flex; gap: 10%; align-items: center; justify-content: center; height: auto;">
                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin: 0; text-align: left;">__________________</p>
                        <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">Supply Officer/
                            <br>Office Custodian
                        </p>
                    </div>


                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin: 0; text-align: left;">__________________</p>
                        <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">BAC Member</p>
                    </div>

                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin: 0; text-align: left;">__________________</p>
                        <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">Vice Chairman</p>
                    </div>

                    <div
                        style="display: flex; flex-direction: column; gap: 0; align-items: left; justify-content: left;">
                        <p style="margin: 0; text-align: left;">__________________</p>
                        <p style="margin: 0; text-align: center; font-size: 12px; font-weight: bold;">Head of Procurment
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>



<script>
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