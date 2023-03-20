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

            $total = "SELECT SUM(total_cost) AS total FROM purchase_request WHERE pr_no = $pr_no and type = 1";
            $result1 = mysqli_query($conn, $total);


            if ($result1) {
                $row = mysqli_fetch_assoc($result1);
                $total = $row['total'];
            } else {
                echo "Error: " . mysqli_error($conn);
            }


            $query = "SELECT * FROM purchase_request WHERE pr_no = $pr_no and type = 1";
            $result = mysqli_query($conn, $query);


            if ($result) {
            ?>

                <style>
                    .container {
                        width: 100%;
                    }
                </style>


                <div class="container">
                    <div class="card col-12 mx-auto">
                        <div class="card-header mt-2 bg-success text-white">
                            <b>AGENCY PROCUREMENT REQUEST</b>
                            <button class="btn btn-sm btn-success float-right" type="button" id="print-card"><i class="fa fa-print"></i>
                                Print</button>
                        </div>
                        <div class="card-body border">
                            <div id="cts-card">
                                <table style="border: 3px solid" class="table table-bordered
                border-dark">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table style="border: 1px solid;" class="table
                                table-bordered border-dark">
                                                    <thead>
                                                        <tr class="text-start">
                                                            <td style="width: 30%;">NAME & ADDRESS
                                                                OF REQUESTING
                                                                AGENCY</td>
                                                            <td style="width: 40%;">SUMPONG CENTRAL
                                                                SCHOOL Sumpong,
                                                                Malaybalay
                                                                City</td>
                                                            <td style="width: 30%;" colspan="4">AGENCY
                                                                ACCT. CODE
                                                                AGENCY
                                                                CONTROL
                                                                No.</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: center;" colspan="2">AGENCY PROCUREMENT
                                                                REQUEST</td>
                                                            <td colspan="4">PS APR No. <?php echo date('Y') ?>-<?php echo $pr_no ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-start" colspan="2">TO:
                                                                PROCUREMENT
                                                                SERVICE
                                                                Department of Budget and Managment ,
                                                                RO
                                                                - X <br>
                                                                Valencia
                                                                City
                                                            </td>
                                                            <td class="text-decoration-underline" colspan="4" style="text-decoration: underline;"><?php echo date('M d, Y') ?> <br> <sub>Date
                                                                    Prepaired</sub></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: center;" colspan="6">
                                                                ACTION REQUESTED ON THE ITEM(S)
                                                                LISTED
                                                                BELOW
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 30px;" class="text-start" colspan="6">[ ]
                                                                Please
                                                                furnish us
                                                                with Price Estimate (for office
                                                                equipment/furniture & supplementary
                                                                items)
                                                                <br>
                                                                [ ] Plese purchase for our agency
                                                                the
                                                                equipment/furniture/supplmentary
                                                                items
                                                                per your
                                                                Price
                                                                Estimate (PS RAD No. __________
                                                                attached) Dated
                                                                _________, 20____
                                                                <br>
                                                                [ ] Please issue common-use
                                                                supplies/materials
                                                                per
                                                                PS
                                                                Price List as of ____________,
                                                                20____
                                                                <br>
                                                                [ ] Please issue Certificate of
                                                                Price
                                                                Reasonableness
                                                                <br>
                                                                [ ] Please furnish us with your
                                                                latest/updated
                                                                price
                                                                List
                                                                <br>
                                                                [ ] others (Specify)
                                                                _____________________________________________________________________
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center" colspan="6">IMPORTANT!!
                                                                PLEASE SEE
                                                                INSTRUCTIONS/CONDITIONS AT THE BACK
                                                                OF
                                                                THE
                                                                ORIGINAL
                                                                COPY</td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <td>ITEM No.</td>
                                                            <td>ITEM and
                                                                DESCRIPTION/SPECIFICATION/STOCK
                                                                No.</td>
                                                            <td>QUANTITY</td>
                                                            <td>UNIT</td>
                                                            <td>UNIT PRICE</td>
                                                            <td>AMOUNT</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($row = mysqli_fetch_assoc($result)) :
                                                        ?>
                                                            <tr>
                                                                <td colspan="1"><?php echo $row['stock_no'] ?></td>
                                                                <td><?php echo $row['item_description'] ?></td>
                                                                <td><?php echo $row['quantity'] ?></td>
                                                                <td><?php echo $row['unit'] ?></td>
                                                                <td><?php echo $row['unit_cost'] ?></td>
                                                                <td><?php echo $row['total_cost'] ?></td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                        <tr>
                                                            <th colspan="6">TOTAL AMOUNT - - - - - <span class="float-right"><?php echo $total ?></span></th>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: center;" colspan="6">NOTE: ALL SIGNATURES
                                                                MUST BE
                                                                OVER
                                                                PRINTED
                                                                NAME</td>
                                                        </tr>
                                                        <tr style="text-align: center;">
                                                            <td>
                                                                STOCKS REQUESTED ARE
                                                                CERTIFIED <br>
                                                                TO
                                                                BE
                                                                WITHIN
                                                                APPROVED
                                                                PROGRAM: <br><br><span class="fw-bold">
                                                                    JANINE
                                                                    M.
                                                                    NERICOA </span><br> AGENCY
                                                                PROPERTY/SUPPLY OFFICER
                                                            </td>
                                                            <td colspan="1">FUNDS CERTIFIED
                                                                AVAILABLE:
                                                                <br><br><br><span class="fw-bold"> GWENDOLYN G.
                                                                    QUIROG
                                                                </span><br>Administrative Assistant
                                                                III
                                                            </td>
                                                            <td colspan="4">APPROVED: <br><br><span class="fw-bold">
                                                                    MARY FE C. GUMAYAO </span><br>
                                                                School
                                                                Principal I <br>AGENCY
                                                                HEAD/AUTHORIZED
                                                                SIGNATURE
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text- start" colspan="6">
                                                                [ ] FUNDS DEPOSIT WITH PS [ ] ______
                                                                CHECK No.
                                                                __________
                                                                IN THE AMOUNT OF:
                                                                __________________________________________(P_______________)
                                                                ENCLOSED.
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
                ?>


                <script>
                    $('#print-card').click(function() {
                        var ccts = $('#cts-card').clone();

                        ccts.find('table').css('border-collapse', 'collapse');
                        ccts.find('td').css('border', '1px solid');
                        ccts.find('.fw-bold').css('font-weight', 'bold');
                        ccts.find('.text-center').css('text-align', 'center');
                        ccts.find('tr').css('font-size', '12px');
                        ccts.find('th').css('font-size', '12px');

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