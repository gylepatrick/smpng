<?php include('header.php') ?>
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

$total = "SELECT SUM(total_cost) AS total FROM purchase_request WHERE pr_no = $pr_no and availability = 2";
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
    // echo $total;
    function number_to_words($number)
    {
        // A lookup table to convert numbers to words
        $words = array(
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety'
        );

        // If the number is 0, return "Zero"
        if ($number == 0) {
            return $words[0];
        }

        // If the number is less than 20, use the lookup table to convert it to words
        if ($number < 20) {
            return $words[$number];
        }

        // If the number is less than 100, use the lookup table to convert the tens digit to words and recursively call the function for the ones digit
        if ($number < 100) {
            return $words[10 * floor($number / 10)] . ' ' . number_to_words($number % 10);
        }

        // If the number is less than 1000, convert the hundreds digit to words and recursively call the function for the remaining digits
        if ($number < 1000) {
            return $words[floor($number / 100)] . ' Hundred ' . number_to_words($number % 100);
        }

        // If the number is less than 1000000, convert the thousands digit to words and recursively call the function for the remaining digits
        if ($number < 1000000) {
            if ($number % 1000 == 0) {
                return number_to_words($number / 1000) . ' Thousand';
            } else {
                return number_to_words(floor($number / 1000)) . ' Thousand ' . number_to_words($number % 1000);
            }
        }

        // If the number is greater than or equal to 1000000, convert the millions digit to words and recursively call the function for the remaining digits
        return number_to_words(floor($number / 1000000)) . ' Million ' . number_to_words($number % 1000000);
    }
        $total_words = number_to_words($total);

    ?>

    <style>
        body {
            /* padding: 5% 18% 10% 18%; */
        }

        .header {
            text-align: center;
        }

        .header2 {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .star {
            text-align: center;
        }

        .tab {
            display: inline-block;
            margin-left: 50px;
        }

        th {
            text-align: center;
            text-decoration: underline;
        }

        .table {
            text-align: center;
        }

        #approved {
            padding-left: 22%;
            padding-top: 5%;
            text-decoration: none;
        }

        th sub {
            text-align: center;
            text-decoration: none;
        }
    </style>
    <!-- NAVBAR -->

    <div class="card col-md-12 mx-auto mt-3 mb-3">
        <div class="card-header m-0 text-white bg-success mt-3">
            <b>BAC DOCUMENT</b>
            <button class="btn btn-sm text-white float-right" type="button" id="print-card"><i class="fa fa-print"></i>
                Print</button>
        </div>

        <div class="card-body border border-1">

            <div id="cts-card">
                <header class="header">
                    <h7>DEPARTMENT OF EDUCATION</h7>
                    <br>
                    <h7 id="school" class="fw-bold">SUMPONG CENTRAL SCHOOL</h7>
                    <br>
                    <h8>Sumpong, Malaybalay City</h8>
                </header>
                <hr>
                <header id="header2" class="text-center">
                    <h7 class="fw-bold">BAC RESOLUTION NO. <b style="color: red; text-decoration: underline;">
                            <?php echo date("Y-"); ?>
                            <?php echo $pr_no ?>
                        </b></h7>
                    <br>
                    <h7 class="fw-bold">RESOLUTION RECOMMENDING __________ AS ALTERNATIVE METHOD
                        <br> OF PROCUREMENT OF _____________ OF SUMPONG CENTRAL
                        SCHOOL
                        <br>WITH <b style="color: red; text-decoration: underline;">PR NO.
                            <?php echo date("Y-"); ?>
                            <?php echo $pr_no ?>
                        </b>
                    </h7>
                </header>
                <br>
                <p><span class="fw-bold" id="bold"> WHEREAS, </span>the Bids and Awards Committe
                    (BAC) of
                    Sumpong
                    Central School
                    has agreed to issue recommendation to the
                    School Head I regarding the mode of procurement of ____________;
                    <br><br>
                    <span class="fw-bold" id="bold"> WHEREAS, </span>upon examination of said
                    purchase request
                    and the
                    supporting documents required for the procurement, the BAC
                    Members
                    find that the purchase was in accordance with the provision of
                    <span class="fw-bold" id="bold"> Revised IRR Rule XVI Section 52.1b of RA -
                        No.
                        9184 </span>
                    because of the following reasons:
                </p>

                <div id="count" class="ps-5">
                    <p> 1. _________________________ is/are not
                        available
                        in the DBM
                        Procurement
                        Service, as evidenced by attached Agency Procurement Request
                        ________;
                        <br><br>
                        2. _________________________ is/are urgently needed by the
                        end-users
                        for immediate dispatch of piblic service;
                        <br><br>
                        3. the total estimated cost of the said procurement does not
                        exeed
                        One Million Pesos (P 1,0000,000.00) as provided under Annex
                        "H"
                        of
                        the Revised IRR as it is only
                        <b style="text-decoration: underline; color: blue;">
                            <?php echo $total_words ?> Pesos Only (P
                            <?php echo $total ?>)
                        </b>
                    </p>
                </div>

                <p><span class="fw-bold" id="bold"> NOW THEREFORE, </span> upon motion of
                    _______________ and duly
                    signed by _____________;
                    <br><br>
                    <span class="fw-bold id=" bold>BE IT RESOLVED, AS IT IS HEREBY RESOLVED</span>
                    that the BAC
                    recommends to the School Head that _______ be applied as the
                    mode of
                    procurement for the above- mentioned procurement;
                    <br><br>
                    <span class="fw-bold" id="bold">RESOLVED</span> further that copies of this
                    resolution be
                    furnished to the Office of the School Head I of Sumpong Central
                    School and the State Auditor IV for DepED Malaybalay City for
                    further perusal and appropriate action.
                    <br><br>
                    Approved unanimously this ______ day of ______________.
                </p>

                <div class="text-center" id="star">
                    <p>*** <span class="ps-5" id="tab">***</span><span class="ps-5" id="tab">***</span></p>
                </div>
                <p> I hereby certify to the correctness of the above-qouted
                    resolution.
                </p>
                <br><br>

                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>KRISTINA KAYE PALMA <br><sub class="fw-normal">BAC Chairman</sub></th>
                            <th>FLORA A. BUSCAINO <br><sub class="fw-normal">Vice Chairman</sub></th>
                        </tr>

                        <tr>
                            <th>DECERY L. DAYO<br><sub class="fw-normal">BAC
                                    Member</sub></th>
                            <th>JOANNA MICHELLE TOLIBAO<br><sub class="fw-normal">BAC Member</sub></th>
                        </tr>

                        <tr>
                            <th>DAISEERY P. HINLO<br><sub class="fw-normal">BAC
                                    Member</sub></th>
                            <th>CHARITY DELA CRUZ<br><sub class="fw-normal">BAC
                                    Member</sub></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="approved">Approved by:</td>
                        </tr>
                        <tr>
                            <td id="principal" colspan="2" class="fw-bold">MARY FE C. GUMAYAO<br><sub
                                    class="fw-normal">School Principal
                                    I</sub><br><sub class="fw-normal">Head of
                                    Procuring
                                    Entity</sub></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script>
        $('#print-card').click(function () {
            var ccts = $('#cts-card').clone();

            ccts.find('header').css('text-align', 'center');
            ccts.find('#star').css('text-align', 'center');
            ccts.find('#tab').css('margin-left', '50px');
            ccts.find('#school').css('font-weight', 'bold');
            ccts.find('#bold').css('font-weight', 'bold');
            ccts.find('#header2').css('font-weight', 'bold');
            ccts.find('#principal').css('font-weight', 'bold');
            ccts.find('.fw-normal').css('font-weight', 'normal');
            ccts.find('table').css('width', '100%');
            ccts.find('th').css('text-decoration', 'underline');
            ccts.find('#approved').css('padding', '5% 0 0 22%');
            ccts.find('#count').css('padding-left', '5%');
            ccts.find('tr').css('padding-left', '50%');
            ccts.find('tbody').css('text-align', 'center');
            // bold-blue
            ccts.find('.bold-italic').css('font-style', 'italic');
            ccts.find('.bold-italic').css('color', 'skyblue');

            ccts.find('.bold-blue').css('color', 'skyblue');

            var nw = window.open('', '_blank',);
            nw.document.write(ccts.html())
            nw.document.close()
            nw.print()
            setTimeout(function () {
                window.close()
            }, 750)
        })
    </script>
    <?php

}
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