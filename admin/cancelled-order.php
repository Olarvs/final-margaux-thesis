<?php 
include './components/head_css.php'; 
include './components/navbar_sidebar.php'; 
?>

<style>
table .btn {
    padding: 5px 10px !important;
}

.selectCustom {
    width: unset !important;
}
</style>

<!-- INSERT MODAL -->
<div class="modal fade stockSettingsModal" id="stockSettingsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Stock Settings</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="stockSettingsForm" enctype="multipart/form-data">
                    <?php
                    $getStockSett = mysqli_query($conn, "SELECT * FROM tbl_stock_settings");

                    foreach($getStockSett as $row) {
                    ?>
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">stockId</label>
                        <input type="tel" class="form-control" id="stockId" name="stockId"
                            placeholder="Low Stock Quantity" value="<?= $row['id'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Low Stock Qty</label>
                        <input type="tel" class="form-control" id="lowStockQty" name="lowStockQty"
                            placeholder="Low Stock Quantity" value="<?= $row['lowStock'] ?>" required>
                        <span class="error error_lowStockQty"
                            style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
                    </div>
                    <?php
                    }
                    ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="stockSettingsForm" class="btn btn-primary" id="stockSettingsBtn">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD STOCK -->
<div class="modal fade addStockModal" id="addStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Add Stock</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStockForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Product ID</label>
                        <input type="text" class="form-control" id="productId" name="productId"
                            placeholder="Category Id" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName"
                            placeholder="Product name" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Stock</label>
                        <input type="text" class="form-control" id="productStock" name="productStock"
                            placeholder="Product stock" required>
                        <span class="error errorProductStock"
                            style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addStockForm" class="btn btn-primary" id="addStockBtn">Add stock</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT STOCK -->
<div class="modal fade editStockModal" id="editStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Edit Stock</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStockForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Product ID</label>
                        <input type="text" class="form-control" id="editProductId" name="editProductId"
                            placeholder="Category Id" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="editProductName"
                            placeholder="Product name" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Stock</label>
                        <input type="text" class="form-control" id="editProductStock" name="editProductStock"
                            placeholder="Product stock" required>
                        <span class="error errorEditProductStock"
                            style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="editStockForm" class="btn btn-primary" id="editStockBtn">Edit stock</button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade deleteCategoryModal" id="deleteCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Category</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteCategoryForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Category ID</label>
                        <input type="text" class="form-control" id="deleteCategoryId" name="deleteCategoryId"
                            placeholder="Category ID" required>
                    </div>
                    Are you sure, you want this to move in archive?
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="deleteCategoryForm" class="btn btn-primary"
                    id="deleteCategoryBtn">Yes</button>
            </div>
        </div>
    </div>
</div>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="mr-md-3 mr-xl-5 p-0">
                            <h2>Completed Order</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">Completed Order</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body" style="width: 100%;">
                        <h4 class="card-title">Completed Order</h4>
                        <div class="table-responsive">
                            <table class="table table-striped" id="cancelledOrder" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>
                                            Order ID
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Delivery Method
                                        </th>
                                        <th>
                                            Payment Method
                                        </th>
                                        <th>
                                            Cancelled Date & Time
                                        </th>
                                        <th>
                                            Reason
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->

<script>
$(window).on('load', function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

    if (localStorage.getItem('status') == 'updateStockSettings') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Stock settings updated successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            color: '#000',
            background: '#fe827a',
            timer: 5000,
            timerProgressBar: true,
        });
        localStorage.removeItem('status');
    } else if (localStorage.getItem('status') == 'update') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Stock added successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            color: '#000',
            background: '#fe827a',
            timer: 5000,
            timerProgressBar: true,
        });
        localStorage.removeItem('status');
    } else if (localStorage.getItem('status') == 'archived') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Category moved to archived successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            color: '#000',
            background: '#fe827a',
            timer: 5000,
            timerProgressBar: true,
        });
        localStorage.removeItem('status');
    }
})

$(document).ready(function() {
    // Image preview
    $('#editCategoryThumbnail').on('change', function() {
        var file = this.files[0];

        if (file) {
            var reader = new FileReader();

            reader.addEventListener('load', function() {
                $('#file').attr("src", this.result);
            })

            reader.readAsDataURL(file);
        }
    })

    // VALIDATIONS
    var $regexNumber = /^\d+$/;

    $('#lowStockQty').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexNumber)) {
            $('.error_lowStockQty').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! No letter/symbol should be included.'
            );
            $('#lowStockQty').addClass('border-danger');
        } else {
            $('.error_lowStockQty').text('');
            $('#lowStockQty').removeClass('border-danger');
        }
    })

    $('#productStock').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexNumber)) {
            $('.errorProductStock').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! No letter/symbol should be included.'
            );
            $('#productStock').addClass('border-danger');
        } else {
            $('.errorProductStock').text('');
            $('#productStock').removeClass('border-danger');
        }
    })

    $('#editProductStock').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexNumber)) {
            $('.errorEditProductStock').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! No letter/symbol should be included.'
            );
            $('#editProductStock').addClass('border-danger');
        } else {
            $('.errorEditProductStock').text('');
            $('#editProductStock').removeClass('border-danger');
        }
    })

    // DATATABLES
    var datatable = $('#cancelledOrder').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/cancelled-order.php",
            type: "post",
            error: function(xhr, error, code) {
                console.log(xhr, code);
            }
        },
        "order": [
            [5, 'desc']
        ],
        "aaSorting": [
            [5, "desc"]
        ],
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        columnDefs: [{
            type: 'numeric-comma',
            targets: 1
        }]
    });

    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

    $('#filterStatus').on('change', function() {
        datatable.draw();
    });

    $('#filterStatus').on('change', function() {
        datatable.search(this.value).draw();
    });

    setInterval(function() {
        datatable.ajax.reload(null, false);
    }, 10000); // END DATATABLES

    // UPDATE STOCK SETTINGS
    $('#stockSettingsForm').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('updateStockSett', true);

        $.ajax({
            type: "POST",
            url: "./backend/inventory.php",
            data: form,
            dataType: "text",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if (response.includes('success')) {
                    localStorage.setItem('status', 'updateStockSettings');
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Something went wrong!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        color: '#000',
                        background: '#fe827a',
                        timer: 5000,
                        timerProgressBar: true,
                    });
                }
                console.log(response);
            }
        })
    })

    // Get Stock
    $(document).on('click', '#addStock', function(e) {
        e.preventDefault();

        var productId = $(this).data('id');

        $.ajax({
            url: './backend/inventory.php',
            type: 'POST',
            data: {
                'getProductStock': true,
                'productId': productId,
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $(".addStockModal").modal("show");
                $("#productId").val(obj.productId);
                $("#productName").val(obj.productName);
                console.log(response);
            }
        })
    })

     // Get Edit Stock
     $(document).on('click', '#editStock', function(e) {
        e.preventDefault();

        var productId = $(this).data('id');

        $.ajax({
            url: './backend/inventory.php',
            type: 'POST',
            data: {
                'getEditProductStock': true,
                'productId': productId,
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $(".editStockModal").modal("show");
                $("#editProductId").val(obj.productId);
                $("#editProductName").val(obj.productName);
                $("#editProductStock").val(obj.productStock);
                console.log(response);
            }
        })
    })

    // Update Category
    $('#addStockForm').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('addStock', true);

        $.ajax({
            type: "POST",
            url: "./backend/inventory.php",
            data: form,
            dataType: 'text',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#addStockBtn').attr('disabled', true);
                $('#addStockBtn').text('Processing');
            },
            complete: function() {
                $('#addStockBtn').attr('disabled', false);
                $('#addStockBtn').text('Add stock');
            },
            success: function(response) {
                if (response.includes('success')) {
                    localStorage.setItem('status', 'update');
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Something went wrong!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        color: '#000',
                        background: '#fe827a',
                        timer: 5000,
                        timerProgressBar: true,
                    });
                }
                console.log(response);
            }
        })
    })

    $('#editStockForm').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('editStock', true);

        $.ajax({
            type: "POST",
            url: "./backend/inventory.php",
            data: form,
            dataType: 'text',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#editStockBtn').attr('disabled', true);
                $('#editStockBtn').text('Processing');
            },
            complete: function() {
                $('#editStockBtn').attr('disabled', false);
                $('#editStockBtn').text('Edit stock');
            },
            success: function(response) {
                if (response.includes('success')) {
                    localStorage.setItem('status', 'update');
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Something went wrong!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        color: '#000',
                        background: '#fe827a',
                        timer: 5000,
                        timerProgressBar: true,
                    });
                }
                console.log(response);
            }
        })
    })

    // RESET MODAL
    $('.addCategoryModal').on('hidden.bs.modal', function() {
        $('#addCategoryForm')[0].reset();
    });

    $('.updateCategoryModal').on('hidden.bs.modal', function() {
        $('#editCategoryForm')[0].reset();
    });
})
</script>

<?php
include './components/bottom.php';
?>