<?php include('header.php') ?>
<style>
    label {
        font-size: 10px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-7">

            <?php
            if (isset($_SESSION['success'])) {
            ?>
                <div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
                    <strong></strong> <?php echo $_SESSION['success']; ?>
                    <button type="button" class="btn-close btn-success float-end" data-bs-dismiss="alert" aria-label="Close">x</button>
                </div>
            <?php
                unset($_SESSION['success']);
            } else if (isset($_SESSION['erro'])) {
            ?>

                <div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
                    <strong></strong> <?php echo $_SESSION['error']; ?>
                    <button type="button" class="btn-close btn-danger float-end" data-bs-dismiss="alert" aria-label="Close">x</button>
                </div>

            <?php
                unset($_SESSION['error']);
            }
            ?>

            <div class="card shadow mb-4">
                <div class="card-header bg-success py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Purchase Request Form</h6>
                </div>
                <div class="card-body">
                    <form action="handlers/save-pr.php" method="POST" id="my-form">
                        <div style="display: flex; align-items: center; justify-content: center; flex-direction: column;" class="form-row col-12 text-dark border border-white border-radius align-items-center justify-center">
                            <div class="row">
                                <div class="form-row col-11 mx-auto">
                                    <div class="col-md-1 mb-3">
                                        <label for="validationServer01">Stock No.</label>
                                        <input type="text" class="form-control" name="stock_no[]" required>
                                    </div>

                                    <div class="col-md-1 mb-3">
                                        <label for="validationServer01">Unit</label>
                                        <input type="text" class="form-control" name="unit[]" required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="validationServer01">Item Description</label>
                                        <input type="text" class="form-control" name="item_description[]" required>
                                    </div>

                                    <div class="col-md-1 mb-3">
                                        <label for="validationServer01">Quantity</label>
                                        <input type="text" class="form-control" name="quantity[]" required>
                                    </div>

                                    <div class="col-md-1 mb-3">
                                        <label for="validationServer01">Unit Cost</label>
                                        <input type="text" class="form-control" name="unit_cost[]" required>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="validationServer01">Total Cost</label>
                                        <input type="text" class="form-control" name="total_cost[]" required>
                                    </div>

                                    <div class="col-md-1 mb-3">
                                        <label for="validationServer01">Type</label>
                                        <select class="form-select form-control" name="type[]">
                                            <option value="1">Office Supplies</option>
                                            <option value="2">Non-Office Supplies</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1 mb-3">
                                        <label for="validationServer01" class="text-center">---</label>
                                        <select class="form-select form-control" name="consumable[]">
                                            <option value="1">Consumable</option>
                                            <option value="2">Non-Consumable</option>
                                        </select>
                                    </div>
                                </div>
                                <a type="button" class="remove-row ml-3 text-bold text-danger" style="font-weight: bold; font-size: 20px;" title="Remove Form">x</a>
                            </div>
                        </div>


                        <div id="form-rows" class="form-row col-12 text-dark border border-white border-radius align-items-center justify-center" style="display: flex; align-items: center; justify-content: center; flex-direction: column;"></div>
                        <div class="col col-3 mx-auto">
                            <button type="submit" class=" mt-2 btn btn-sm col-12 mx-auto btn-success rounded " title="Save Entries">SAVE</button>
                        </div>
                    </form>
                    <button type="button" class="text-success btn text-sm col-3 mb-3 mx-auto float-right" title="Add new form row" style="font-size: 15px;" id="add-row"><i class="fa fa-plus"></i>New Row</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Footer -->
<footer class="sticky-footer bg-success text-white">
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