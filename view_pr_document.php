<?php include('header.php') ?>
<style>
    @media print {
    .form-row {
        height: 100%;
        page-break-after: always;
    }
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
                    .container {
                        width: 100%;
                    }

                    .image-1 {
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        justify-content: center;
                    }
                </style>


                <div class="card col-12 mx-auto">
                    <div class="card-header mt-3 bg-success text-white">
                        <b>PR Document</b>
                        <button class="btn btn-sm btn-success float-right" type="button" id="print-card"><i class="fa fa-print"></i>
                            Print</button>
                    </div>
                    <div class="card-body border">
                        <div id="cts-card">
                            <header style="display: flex; align-items: center; gap: 10%; justify-content: center;">
                                <img width="7%" src="logo.webp" alt="" srcset="">
                                <h5 style="text-align: center;"> PURCHASE REQUEST <br>
                                    Department of Education <br> DIVISION OF MALAYBALAY CITY
                                </h5>
                                <img width="7%" src="deped.png" alt="" srcset="">
                            </header>
                            <table style="width: 100%;">
                                <thead>
                                    <tr style="text-align: left;">
                                        <th colspan="3">Entity Name:</th>
                                        <th colspan="3">Fund Cluster:</th>
                                    </tr>
                                </thead>
                            </table>
                            <table style="width: 100%; border: 1px solid; border-collapse:
                 collapse;">
                                <thead style="border: 1px solid;">
                                    <tr style="text-align: left; border: 1px solid;">
                                        <th style="border: 1px solid;" colspan="3">Office: <br>
                                            Section:</th>
                                        <th style="border: 1px solid;">PR No.: <?php echo date('Y') ?>-<?php echo $pr_no ?> <br> RCC:</th>
                                        <th style="border: 1px solid;" colspan="2">Date:</th>
                                    </tr>
                                    <tr style="text-align: center; border: 1px solid;">
                                        <th style="border: 1px solid; padding-bottom: 20px; padding-top: 20px;">Stock/Property No.</th>
                                        <th style="border: 1px solid; padding-bottom: 20px; padding-top: 20px;">Unit</th>
                                        <th style="border: 1px solid; padding-bottom: 20px; padding-top: 20px;">Item Description</th>
                                        <th style="border: 1px solid; padding-bottom: 20px; padding-top: 20px;">Quantity</th>
                                        <th style="border: 1px solid; padding-bottom: 20px; padding-top: 20px;">Unit Cost</th>
                                        <th style="border: 1px solid; padding-bottom: 20px; padding-top: 20px;">Total Cost</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    <tr>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                    <tr>
                                        <td style="border: 1px solid black; padding-bottom: 10px; padding-top: 10px;">
                                            <?php echo $row['stock_no']; ?>
                                        </td>
                                        <td style="border: 1px solid black; padding-bottom: 10px; padding-top: 10px;">
                                            <?php echo $row['unit']; ?>
                                        </td>
                                        <td style="border: 1px solid black; padding-bottom: 10px; padding-top: 10px;">
                                            <?php echo $row['item_description']; ?>
                                        </td>
                                        <td style="border: 1px solid black; padding-bottom: 10px; padding-top: 10px;">
                                            <?php echo $row['quantity']; ?>
                                        </td>
                                        <td style="border: 1px solid black; padding-bottom: 10px; padding-top: 10px;">
                                            ₱ <?php echo $row['unit_cost']; ?>
                                        </td>
                                        <td style="border: 1px solid black; padding-bottom: 10px; padding-top: 10px;">
                                            ₱ <?php echo $row['total_cost']; ?>
                                        </td>
                                    </tr>
                                <?php
                                        }
                                ?>
                                </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="border: 1px solid;">
                                            <br>
                                            <br>
                                            Signature:
                                            <br>
                                            Printed Name:
                                            <br>
                                            Position:
                                        </td>
                                        <td style="border: 1px solid;" colspan="2">Requested by:
                                            <br><br>
                                            <span style="float: left; width: 100%; text-align:
                                 center; text-decoration: underline; font-weight:
                                 bold;"> <br> JANINE M. NERICOA <br> <sub>Property
                                                    officer</sub></span>
                                        </td>
                                        <td style="border: 1px solid;" colspan="3">Approved by:
                                            <br><br>
                                            <span style="float: left; width: 100%; text-align:
                                 center; text-decoration: underline; font-weight:
                                 bold;"><br> MARY FE C. GUMAYAO <br> <sub>School
                                                    Principal
                                                    I</sub></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <p style="font-size: 10px; font-style: italic;">Revised Puchase
                                Request
                                (PR) - Appendix 60 of the Government Accounting Manual (GAM)
                                Volume
                                2 effective January 1, 2016</p>
                        </div>
                        <script>
                            $('#print-card').click(function() {
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

            <?php
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
            ?>

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