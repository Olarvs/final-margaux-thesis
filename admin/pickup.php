<?php 

include './components/head_css.php'; 
include './components/navbar_sidebar.php';

$_SESSION["margaux_link_admin"] = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<style>
table .btn {
    padding: 5px 10px !important;
}

.selectCustom {
    width: unset !important;
}
</style>

<!-- UPDATE MODAL -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">UPDATE STATUS</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    <div class="form-group d-none">
                        <label for="">Order ID</label>
                        <input type="text" name="updateOrderId" id="updateOrderId" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">STATUS</label>
                        <select class="form-select" id="updateStatus" name="updateStatus" required
                            aria-label="Default select example">
                        </select>
                    </div>
                    <div class="form-group d-none" id="reasonContainer">
                        <label for="">REASON</label>
                        <textarea style="resize: none;" placeholder="Reason" id="reason" name="reason" cols="10"
                            rows="3" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="updateForm" class="btn btn-primary" id="updateBtn">Update</button>
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
                            <h2>Pick Up Orders</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">Pick Up Orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card p-3 pt-0">
                    <ul class="nav nav-tabs" id="myTab" style="border: none;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#cashOnPickUp" data-toggle="tab">Cash
                                on Pick Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#gcash" data-toggle="tab">Gcash</a>
                        </li>
                    </ul>

                    <div class="tab-content pt-3 px-0">
                        <div class="tab-pane fade show active" id="cashOnPickUp" role="tab-panel">
                            <div class="card">
                                <div class="card-body" style="width: 100%;">
                                    <h4 class="card-title">Cash on Pick Up</h4>
                                    <select class="form-select form-control mb-2 align-self-end selectCustom"
                                        id="filterStatus" name="filterStatus" required
                                        aria-label="Default select example">
                                        <option value="">SELECT STATUS</option>
                                        <option value="PENDING">PENDING</option>
                                        <option value="CONFIRMED">CONFIRMED</option>
                                        <option value="READY TO PICK UP">READY TO PICK UP</option>
                                    </select>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="pickUpCop" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <center>
                                                        Order ID
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Name
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Email
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Contact No.
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Pick up Date & Time
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Order Date & Time
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Order Total
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Status
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Action
                                                        </center>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="gcash" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Gcash</h4>
                                    <select class="form-select form-control mb-2 align-self-end selectCustom"
                                        id="filterStatusGcash" name="filterStatusGcash" required
                                        aria-label="Default select example">
                                        <option value="">SELECT STATUS</option>
                                        <option value="PENDING">PENDING</option>
                                        <option value="CONFIRMED">CONFIRMED</option>
                                        <option value="READY TO PICK UP">READY TO PICK UP</option>
                                    </select>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="pickUpGcash" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <center>
                                                        Order ID
                                                        </center>
                                                    </th>
                                                    <th>
                                                         <center>
                                                        Name
                                                        </center>
                                                    </th>
                                                    <th>
                                                         <center>
                                                        Email
                                                        </center>
                                                    </th>
                                                    <th>
                                                         <center>
                                                        Contact No.
                                                        </center>
                                                    </th>
                                                    <th>
                                                         <center>
                                                        Proof of Payment
                                                        </center>
                                                    </th>
                                                    <th>
                                                         <center>
                                                        Pick up Date & Time
                                                        </center>
                                                    </th>
                                                    <th>
                                                         <center>
                                                        Order Date & Time
                                                        </center>
                                                    </th>
                                                    <th>
                                                         <center>
                                                        Order Total
                                                        </center>
                                                    </th>
                                                    <th>
                                                         <center>
                                                        Status
                                                        </center>
                                                    </th>
                                                    <th>
                                                         <center>
                                                        Action
                                                        </center>
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
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>

<!-- main-panel ends -->

<script>
$(window).on('load', function() {
    $('#filterStatus').val('');
    $('#filterStatusGcash').val('');
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
})

$(document).ready(function() {
    // DATATABLES
    $('#pickUpCop').css('text-align', 'center');
    var pickUpCop = $('#pickUpCop').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/pickup-cop.php",
            type: "post",
            data: function(data) {
                var status = $('#filterStatus').val();

                data.searchByStatus = status;
            },
            error: function(xhr, error, code) {
                console.log(xhr, code);
            }
        },
        "order": [
            [5, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
    });
 $('#pickUpGcash').css('text-align', 'center');
    var pickUpGcash = $('#pickUpGcash').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/pickup-gcash.php",
            type: "post",
            data: function(data) {
                var status = $('#filterStatusGcash').val();

                data.searchByStatus = status;
            },
            error: function(xhr, error, code) {
                console.log(xhr, code);
            }
        },
        "order": [
            [6, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
    });

    $('#filterStatus').on('change', function() {
        pickUpCop.draw();
    });

    $('#filterStatusGcash').on('change', function() {
        pickUpGcash.draw();
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

    setInterval(function() {
        pickUpGcash.ajax.reload(null, false);
        pickUpCop.ajax.reload(null, false);
    }, 10000); // END DATATABLES

    // VIEW IMAGE
    $(document).on('click', '#viewProofOfPayment', function(e) {
        e.preventDefault();

        var img_to_load = $(this).data('id');
        imgWindow = window.open(img_to_load);
    });

    // VIEW PRODUCT
    $(document).on('click', '#get_view', function(e) {
        e.preventDefault();

        var orderId = $(this).data('id');

        location.href = 'view-order.php?id=' + orderId;
    })

    // STATUS ON CHANGE
    $('#updateStatus').on('change', function(e) {
        e.preventDefault();

        if ($(this).val() == 'CANCELLED') {
            $('#reasonContainer').removeClass('d-none');
            $('#reason').attr('required', true);
        } else {
            $('#reasonContainer').addClass('d-none');
            $('#reason').attr('required', false);
        }
    })

    // RETAIN TAB
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        sessionStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = sessionStorage.getItem('activeTab');
    if (activeTab) {
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }

    // UPDATE
    $(document).on('click', '#get_update', function(e) {
        e.preventDefault();

        var orderId = $(this).data('id');

        var form = new FormData();
        form.append('get_status', true);
        form.append('orderId', orderId);

        $.ajax({
            type: "POST",
            url: "./backend/orders.php",
            data: form,
            dataType: "text",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                var obj = JSON.parse(response);
                // console.log(response);
                if (obj.orderStatus == 'PENDING') {
                    $('#updateModal').modal("show");
                    $('#updateOrderId').val(obj.orderId);
                    $('#updateStatus')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">SELECT STATUS</option>')
                        .append('<option value="CONFIRMED">CONFIRMED</option>')
                        .append('<option value="CANCELLED">CANCELLED</option>');
                } else if (obj.orderStatus == 'CONFIRMED') {
                    $('#updateModal').modal("show");
                    $('#updateOrderId').val(obj.orderId);
                    $('#updateStatus')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">SELECT STATUS</option>')
                        .append(
                            '<option value="READY TO PICK UP">READY TO PICK UP</option>')
                        .append('<option value="CANCELLED">CANCELLED</option>');
                } else if (obj.orderStatus == 'READY TO PICK UP') {
                    $('#updateModal').modal("show");
                    $('#updateOrderId').val(obj.orderId);
                    $('#updateStatus')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">SELECT STATUS</option>')
                        .append('<option value="COMPLETED">COMPLETED</option>')
                        .append('<option value="CANCELLED">CANCELLED</option>');
                }

            }
        })
    })

    // SUBMIT UPDATE
    $('#updateForm').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('updateOrderPickUpCop', true);

        $.ajax({
            type: "POST",
            url: "./backend/orders.php",
            data: form,
            dataType: "text",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                $('#updateBtn').attr('disabled', true);
                $('#updateBtn').text('Loading...');
            },
            complete: function() {
                $('#updateBtn').attr('disabled', false);
                $('#updateBtn').text('Update');
            },
            success: function(response) {
                if (response.includes('success')) {
                    $('#updateModal').modal("hide");
                    pickUpCop.ajax.reload(null, false);
                    pickUpGcash.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Order updated successfully!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        color: '#000',
                        background: '#fe827a',
                    })
                } else if (response.includes('out of stock')) {
                    pickUpCop.ajax.reload(null, false);
                    pickUpGcash.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: 'Item is out of stock!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        color: '#000',
                        background: '#fe827a',
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops!',
                        text: 'Something went wrong!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        color: '#000',
                        background: '#fe827a',
                    })
                }
                console.log(response);
            }
        })
    })

    // RESET MODAL
    $('#updateModal').on('hidden.bs.modal', function() {
        $('#updateForm')[0].reset();
        $('#reasonContainer').addClass('d-none');
    });
})
</script>

<?php
include './components/bottom.php';
?>