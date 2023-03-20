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

            $total = "SELECT SUM(total_cost) AS total FROM purchase_request WHERE pr_no = $pr_no";
            $result1 = mysqli_query($conn, $total);


            if ($result1) {
                $row = mysqli_fetch_assoc($result1);
                $total = $row['total'];
            } else {
                echo "Error: " . mysqli_error($conn);
            }



            $query = "SELECT * FROM purchase_request WHERE pr_no = $pr_no AND availability = 2";
            $result = mysqli_query($conn, $query);


            if ($result) {
            ?>

                <?php include 'partials/navbar.php' ?>
                <div class="card mt-2 mb-3 col-12 mx-auto">
                    <div class="card-header mt-2 bg-success text-white">
                        <b>REQUES FOR PRICE QUATATION</b>
                        <button class="btn btn-sm btn-success float-right" type="button" id="print-card"><i class="fa fa-print"></i>
                            Print</button>
                    </div>
                <div class="card-body col-12 mx-auto border border-2 border-dark">
                    <div id="cts-card">
                        <header>
                            <h6 class="text-end float-right"> PHILGEPS REGISTRATION NUMBER:__________</h6>
                            <br>
                            <br>
                            <h5 id="firsthead"> Department of Education
                                <br> Region X - Northern Mindanao
                                <br> DIVISION OF MALAYBALAY CITY
                                <br> SUMPONG CENTRAL SCHOOL
                            </h5>
                        </header>

                        <p class="text-end float-right">___________________________<br><sub class="pe-5">Date</sub></p>
                        <p>___________________________
                            <br> ___________________________
                            <br> ___________________________
                        </p>

                        <h5 class="text-center"><span id="secondhead"> PR:
                                <?php echo date('Y') ?>
                                <?php echo '-' . $pr_no ?> Dated: _____ <br>
                                Requisitioner: JANINE M. NERICOA
                            </span><br> <span class="fw-bold">
                                REQUEST FOR PRICE QOUTATION</span></h5>

                        <p> <span> CONDITIONS: </span> <br>
                            A. Please qoute your price/s for the article(s) as specified int
                            the
                            list below for the Schools of Division of Malaybalay City which
                            are
                            available in your store/establishment/company. If available,
                            please
                            furnish catalogue, descriptive brochures or literature about the
                            articles. If you are the manufacturer or exclusive
                            dealer/distributor of these articles in Region X, please state
                            your
                            qoutation.
                            <br>
                            B. In case the items so specifically described is not available
                            in
                            your store/establishment/company, please feel free to offer such
                            product/item which you have in stock which is equivalent of what
                            is
                            desired.
                            <br>
                            C. State how long your qoutation will stand and the shortest
                            time of
                            delivery from receipt of purchase order. Failure or refusal to
                            make
                            the delivery on the part of the supplier from which the DepED
                            Division of Malaybalay City may suffer. Succesful bidder will
                            bind
                            him to pay any loss equivalent to 1% of the total amount qouted
                            in
                            the canvass.
                            <br>
                            D. Provide Certificates of Philgeps Registration and Mayor's
                            Permit/Business Permit as a proof of eligibility.
                            <br>
                            E. All qoutations shall be considered as fixed price and not
                            subject
                            to price scalation during the contract implementation.
                        </p>

                        <p class="ps-5" style="color: red; font-style: italic;">DEPOSIT YOUR PRICE QOUTATION, PROPERLY SEALED IN AN
                            ENVELOPE</p>
                        <p id="canvass" class="text-end">KRISTINA KAYE PALMA <br><sub class="pe-5">BAC Chairman</sub></p>

                        <table id="table-bordered" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th id="table1" scope="col">UNIT</th>
                                    <th id="table1" scope="col">QUANTITY</th>
                                    <th id="table1" scope="col">AGENCY SPECIFICATIONS</th>
                                    <th id="table1" scope="col">BIDDERS SPECIFICATIONS</th>
                                    <td id="table1" scope="col">Approved Budget of the Contract (ABC)</td>
                                    <th id="table1" scope="col">UNIT COST</th>
                                    <th id="table1" scope="col">TOTAL AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $q = $row['quantity'];
                                    $uc = $row['unit_cost'];

                                    $total = $q * $uc;
                                ?>
                                    <tr>
                                        <td id="table1">
                                            <?php echo $row['unit'] ?>
                                        </td>
                                        <td id="table1">
                                            <?php echo $row['quantity'] ?>
                                        </td>
                                        <td id="table1">
                                            <?php echo $row['item_description'] ?>
                                        </td>
                                        <td id="table1"></td>
                                        <td id="table1">
                                            <?php echo $row['unit_cost'] ?>
                                        </td>
                                        <td id="table1">
                                            <?php echo $row['unit_cost'] ?>
                                        </td>
                                        <td id="table1">
                                            <?php echo  $total ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th id="table1">Porpuse:</th>
                                    <th id="table1" class="text-start" colspan="6">For School Based Training and Capacity
                                        Building.</th>
                                </tr>
                            </tbody>
                        </table>

                        <p> <span class="fw-bold"> I HEREBY CERTIFY </span>that the supllies qouted on the face of the
                            qoutation are available in my store and that the price qouted
                            are
                            good until ___________________________________________________</p>
                        <p id="right" class="fw-bold">__________________________________________
                            <br><span id="proprietor"> Proprietor/Authorized Representative </span>
                        </p>
                        <br>

                        <hr class="style3">

                        <p><span class="fw-bold"> I HEREBY CERTIFY </span> under our official oath that the price qouted
                            are
                            not shown or revealed to any of the participating dealer or
                            merchant.</p>

                        <table id="table-borderless" class="table table-borderless">
                            <thead>
                                <tr>
                                    <td id="table2">JOANNA MICHELLE TOLIBAO</td>
                                    <td id="table2">FLORA A. BUSCAINO</td>
                                    <td id="table2">DAISYREE P. HINLO</td>
                                    <td id="table2">DECERY L. DAYO</td>
                                    <td id="table2">CHARITY DELA CRUZ</td>
                                </tr>
                            </thead>
                        </table>

                        <p id="canvass" class="text-end">JULIUS BAYUCOT <br><sub class="pe-4">Canvasser</sub></p>
                    </div>

                    <div class="col-md-12 mb-2 justify-content-end">


                        <script>
                            $('#print-card').click(function() {
                                var ccts = $('#cts-card').clone();

                                ccts.find('.text-end').css('text-align', 'right');
                                ccts.find('.text-end').css('margin-bottom', '0px');
                                ccts.find('#firsthead').css('text-align', 'center');
                                ccts.find('#secondhead').css('font-weight', 'normal');
                                ccts.find('.text-center').css('text-align', 'center');
                                ccts.find('.fw-bold').css('font-weight', 'bold');
                                ccts.find('#table-bordered').css('border-collapse', 'collapse');
                                ccts.find('#table1').css('border', '1px solid');
                                ccts.find('#table1').css('border', '1px solid');
                                ccts.find('#table-borderless').css('border-spacing', '12px');
                                ccts.find('.fst-italic').css('font-style', 'italic');
                                ccts.find('.fst-italic').css('color', 'red');
                                ccts.find('.ps-5').css('padding-left', '5%');
                                ccts.find('.fst-italic').css('font-size', '12px');
                                ccts.find('#proprietor').css('font-style', 'italic');
                                ccts.find('#proprietor').css('font-size', '12px');
                                ccts.find('#proprietor').css('padding-right', '20px');
                                ccts.find('#table2').css('font-size', '12px');
                                ccts.find('#right').css('text-align', 'right');
                                ccts.find('p').css('font-size', '12px');
                                ccts.find('#canvass').css('font-weight', 'bold');
                                ccts.find('#canvass').css('text-decoration', 'underline');
                                ccts.find('sub').css('padding-right', '25px');
                                ccts.find('.text-start').css('text-align', 'left');
                                ccts.find('.pe-5').css('text-decoration', 'none');

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

            <?php } ?>


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