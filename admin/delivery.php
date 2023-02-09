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

<!-- VIEW ADDRESS -->
<div class="modal fade" id="viewAddressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">ADDRESS</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="block"></h6>
                <h6 id="barangay"></h6>
                <h6 id="city"></h6>
                <h6 id="province"></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- UPDATE MODAL -->
<div class="modal fade" id="updateModalDelivery" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="text" name="updateOrderIdDelivery" id="updateOrderIdDelivery" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">STATUS</label>
                        <select class="form-select" id="updateStatusDelivery" name="updateStatusDelivery" required
                            aria-label="Default select example">
                        </select>
                    </div>
                    <div class="form-group d-none" id="feeContainerDelivery">
                        <label for="">Shipping Fee</label>
                        <input type="tel" name="feeDelivery" id="feeDelivery" class="form-control">
                    </div>
                    <div class="form-group d-none" id="reasonContainerDelivery">
                        <label for="">REASON</label>
                        <textarea style="resize: none;" placeholder="Reason" id="reasonDelivery" name="reasonDelivery"
                            cols="10" rows="3" class="form-control"></textarea>
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

<!-- UPDATE MODAL LBC -->
<div class="modal fade" id="updateModalDeliveryLBC" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">UPDATE STATUS</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateFormLBC">
                    <div class="form-group d-none">
                        <label for="">Order ID</label>
                        <input type="text" name="updateOrderIdDeliveryLBC" id="updateOrderIdDeliveryLBC" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">STATUS</label>
                        <select class="form-select" id="updateStatusDeliveryLBC" name="updateStatusDeliveryLBC" required
                            aria-label="Default select example">
                        </select>
                    </div>
                    <div class="form-group d-none" id="feeContainerDeliveryLBC">
                        <label for="">Shipping Fee</label>
                        <input type="tel" name="feeDeliveryLBC" id="feeDeliveryLBC" class="form-control">
                    </div>
                    <div class="form-group d-none" id="trackingContainerDeliveryLBC">
                        <label for="">Tracking Number</label>
                        <input type="tel" name="trackingDeliveryLBC" id="trackingDeliveryLBC" class="form-control">
                    </div>
                    <div class="form-group d-none" id="reasonContainerDeliveryLBC">
                        <label for="">REASON</label>
                        <textarea style="resize: none;" placeholder="Reason" id="reasonDeliveryLBC" name="reasonDeliveryLBC"
                            cols="10" rows="3" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="updateFormLBC" class="btn btn-primary" id="updateBtnLBC">Update</button>
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
                            <h2>Delivery Orders</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">Delivery Orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card p-3 pt-0">
                    <ul class="nav nav-tabs" id="myTabDelivery" style="border: none;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#lalamove"
                                data-toggle="tab">Lalamove</a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a class="nav-link" href="#lbcExpress" data-toggle="tab">LBC Express</a>-->
                        <!--</li>-->
                    </ul>

                    <div class="tab-content pt-3 px-0">
                        <div class="tab-pane fade show active" id="lalamove" role="tab-panel">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Lalamove</h4>
                                    <select class="form-select form-control mb-2 align-self-end selectCustom"
                                        id="filterStatusLalamoveGcash" name="filterStatusLalamoveGcash" required
                                        aria-label="Default select example">
                                        <option value="">SELECT STATUS</option>
                                        <option value="PENDING">PENDING</option>
                                        <option value="CONFIRMED">CONFIRMED</option>
                                        <option value="PACKED (READY TO SHIP)">PACKED (READY TO SHIP)</option>
                                        <option value="OUT FOR DELIVERY">OUT FOR DELIVERY</option>
                                    </select>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="lalamoveGcash">
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
                                                        Address
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
                                                        Order Status
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
                        <div class="tab-pane fade" id="lbcExpress" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">LBC Express</h4>
                                    <ul class="nav nav-tabs" id="myTabDelivery2" style="border: none;">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="#pickUpLbcBranch"
                                                data-toggle="tab">Pick Up in LBC Branch</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#door-to-door" data-toggle="tab">Door-to-Door</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content pt-3 px-0">
                                        <div class="tab-pane fade show active" id="pickUpLbcBranch" role="tab-panel">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title">Pick Up in LBC Branch</h4>
                                                    <select
                                                        class="form-select form-control mb-2 align-self-end selectCustom"
                                                        id="filterStatusLbcPickUp" name="filterStatusLbcPickUp" required
                                                        aria-label="Default select example">
                                                        <option value="">SELECT STATUS</option>
                                                        <option value="PENDING">PENDING</option>
                                                        <option value="CONFIRMED">CONFIRMED</option>
                                                        <option value="PACKED (READY TO SHIP)">PACKED (READY TO SHIP)
                                                        </option>
                                                        <option value="OUT FOR DELIVERY">OUT FOR DELIVERY</option>
                                                    </select>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped" id="lbcPickUp">
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
                                                                        Contact No.
                                                                    </th>
                                                                    <th>
                                                                        Proof of Payment
                                                                    </th>
                                                                    <th>
                                                                        Address
                                                                    </th>
                                                                    <th>
                                                                        Nearest LBC Branch
                                                                    </th>
                                                                    <th>
                                                                        Order Date & Time
                                                                    </th>
                                                                    <th>
                                                                        Order Total
                                                                    </th>
                                                                    <th>
                                                                        Order Status
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

                                        <div class="tab-pane fade" id="door-to-door" role="tab-panel">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title">Door-to-Door</h4>
                                                    <select
                                                        class="form-select form-control mb-2 align-self-end selectCustom"
                                                        id="filterStatusLbcDoor2Door" name="filterStatusLbcDoor2Door"
                                                        required aria-label="Default select example">
                                                        <option value="">SELECT STATUS</option>
                                                        <option value="PENDING">PENDING</option>
                                                        <option value="CONFIRMED">CONFIRMED</option>
                                                        <option value="PACKED (READY TO SHIP)">PACKED (READY TO SHIP)
                                                        </option>
                                                        <option value="OUT FOR DELIVERY">OUT FOR DELIVERY</option>
                                                    </select>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped" id="lbcDoor2Door">
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
                                                                        Address
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
                                                                        Order Status
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
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->

<script>
$(window).on('load', function() {
    $('#filterStatusLalamoveGcash').val('');
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

    var activeTabDelivery = sessionStorage.getItem('activeTabDelivery');
    if (activeTabDelivery) {
        $('#myTabDelivery a[href="' + activeTabDelivery + '"]').tab('show');
    }

    var activeTabDelivery2 = sessionStorage.getItem('activeTabDelivery2');
    if (activeTabDelivery2) {
        $('#myTabDelivery2 a[href="' + activeTabDelivery2 + '"]').tab('show');
    }
})
$(document).ready(function() {
    // DATATABLES
    $('#lalamoveGcash').css('text-align', 'center');
    var lalamoveGcash = $('#lalamoveGcash').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/delivery-lalamove.php",
            type: "post",
            data: function(data) {
                var status = $('#filterStatusLalamoveGcash').val();

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
 $('#lbcPickUp').css('text-align', 'center');
    var lbcPickUp = $('#lbcPickUp').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/delivery-lbc-pickup.php",
            type: "post",
            data: function(data) {
                var status = $('#filterStatusLbcPickUp').val();

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
 $('#lbcDoor2Door').css('text-align', 'center');
    var lbcDoor2Door = $('#lbcDoor2Door').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/delivery-lbc-door.php",
            type: "post",
            data: function(data) {
                var status = $('#filterStatusLbcDoor2Door').val();

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

    $('#filterStatusLalamoveGcash').on('change', function() {
        lalamoveGcash.draw();
    });

    $('#filterStatusLbcPickUp').on('change', function() {
        lbcPickUp.draw();
    });

    $('#filterStatusLbcDoor2Door').on('change', function() {
        lbcDoor2Door.draw();
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

    setInterval(function() {
        lalamoveGcash.ajax.reload(null, false);
    }, 60000); // END DATATABLES

    // VIEW ADDRESS
    $(document).on('click', '#viewAddress', function(e) {
        e.preventDefault();

        var orderId = $(this).data('id');

        var form = new FormData();
        form.append('getAddress', true);
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
                $('#viewAddressModal').modal("show");
                $('#block').text(obj.block);
                $('#barangay').text(obj.barangay);
                $('#city').text(obj.city);
                $('#province').text(obj.province);
                console.log(response);
            }
        })
    })

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
    $('#updateStatusDelivery').on('change', function(e) {
        e.preventDefault();

        if ($(this).val() == 'CANCELLED') {
            $('#reasonContainerDelivery').removeClass('d-none');
            $('#feeContainerDelivery').addClass('d-none');
            $('#reasonDelivery').attr('required', true);
            $('#feeDelivery').attr('required', false);
        } else if ($(this).val() == 'OUT FOR DELIVERY') {
            $('#reasonContainerDelivery').addClass('d-none');
            $('#feeContainerDelivery').removeClass('d-none');
            $('#reasonDelivery').attr('required', false);
            $('#feeDelivery').attr('required', true);
        } else {
            $('#reasonContainerDelivery').addClass('d-none');
            $('#feeContainerDelivery').addClass('d-none');
            $('#reasonDelivery').attr('required', false);
            $('#feeDelivery').attr('required', false);
        }
    })

    // ON CHANGE LBC
    $('#updateStatusDeliveryLBC').on('change', function(e) {
        e.preventDefault();

        if ($(this).val() == 'CANCELLED') {
            $('#reasonContainerDeliveryLBC').removeClass('d-none');
            $('#feeContainerDeliveryLBC').addClass('d-none');
            $('#trackingContainerDeliveryLBC').addClass('d-none');
            $('#reasonDeliveryLBC').attr('required', true);
            $('#feeDeliveryLBC').attr('required', false);
            $('#trackingDeliveryLBC').attr('required', false);
        } else if ($(this).val() == 'OUT FOR DELIVERY') {
            $('#reasonContainerDeliveryLBC').addClass('d-none');
            $('#feeContainerDeliveryLBC').removeClass('d-none');
            $('#trackingContainerDeliveryLBC').removeClass('d-none');
            $('#reasonDeliveryLBC').attr('required', false);
            $('#feeDeliveryLBC').attr('required', true);
            $('#trackingDeliveryLBC').attr('required', true);
        } else {
            $('#reasonContainerDeliveryLBC').addClass('d-none');
            $('#feeContainerDeliveryLBC').addClass('d-none');
            $('#trackingContainerDeliveryLBC').addClass('d-none');
            $('#reasonDeliveryLBC').attr('required', false);
            $('#feeDeliveryLBC').attr('required', false);
            $('#trackingDeliveryLBC').attr('required', false);
        }
    })

    // RETAIN TAB
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTabDelivery', $(e.target).attr('href'));
    });
    var activeTabDelivery = localStorage.getItem('activeTabDelivery');
    if (activeTabDelivery) {
        $('#myTabDelivery a[href="' + activeTabDelivery + '"]').tab('show');
    }

    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTabDelivery2', $(e.target).attr('href'));
    });
    var activeTabDelivery2 = localStorage.getItem('activeTabDelivery2');
    if (activeTabDelivery2) {
        $('#myTabDelivery2 a[href="' + activeTabDelivery2 + '"]').tab('show');
    }

    // UPDATE LALAMOVE
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
                    $('#updateModalDelivery').modal("show");
                    $('#updateOrderIdDelivery').val(obj.orderId);
                    $('#updateStatusDelivery')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">SELECT STATUS</option>')
                        .append('<option value="CONFIRMED">CONFIRMED</option>')
                        .append('<option value="CANCELLED">CANCELLED</option>');
                } else if (obj.orderStatus == 'CONFIRMED') {
                    $('#updateModalDelivery').modal("show");
                    $('#updateOrderIdDelivery').val(obj.orderId);
                    $('#updateStatusDelivery')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">SELECT STATUS</option>')
                        .append(
                            '<option value="PACKED (READY TO SHIP)">PACKED (READY TO SHIP)</option>'
                            )
                        .append('<option value="CANCELLED">CANCELLED</option>');
                } else if (obj.orderStatus == 'PACKED (READY TO SHIP)') {
                    $('#updateModalDelivery').modal("show");
                    $('#updateOrderIdDelivery').val(obj.orderId);
                    $('#updateStatusDelivery')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">SELECT STATUS</option>')
                        .append(
                            '<option value="OUT FOR DELIVERY">OUT FOR DELIVERY</option>')
                        .append('<option value="CANCELLED">CANCELLED</option>');
                } else if (obj.orderStatus == 'OUT FOR DELIVERY') {
                    $('#updateModalDelivery').modal("show");
                    $('#updateOrderIdDelivery').val(obj.orderId);
                    $('#updateStatusDelivery')
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

    // UPDATE LBC
    $(document).on('click', '#get_updateLBC', function(e) {
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
                    $('#updateModalDeliveryLBC').modal("show");
                    $('#updateOrderIdDeliveryLBC').val(obj.orderId);
                    $('#updateStatusDeliveryLBC')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">SELECT STATUS</option>')
                        .append('<option value="CONFIRMED">CONFIRMED</option>')
                        .append('<option value="CANCELLED">CANCELLED</option>');
                } else if (obj.orderStatus == 'CONFIRMED') {
                    $('#updateModalDeliveryLBC').modal("show");
                    $('#updateOrderIdDeliveryLBC').val(obj.orderId);
                    $('#updateStatusDeliveryLBC')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">SELECT STATUS</option>')
                        .append(
                            '<option value="PACKED (READY TO SHIP)">PACKED (READY TO SHIP)</option>'
                            )
                        .append('<option value="CANCELLED">CANCELLED</option>');
                } else if (obj.orderStatus == 'PACKED (READY TO SHIP)') {
                    $('#updateModalDeliveryLBC').modal("show");
                    $('#updateOrderIdDeliveryLBC').val(obj.orderId);
                    $('#updateStatusDeliveryLBC')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">SELECT STATUS</option>')
                        .append(
                            '<option value="OUT FOR DELIVERY">OUT FOR DELIVERY</option>')
                        .append('<option value="CANCELLED">CANCELLED</option>');
                } else if (obj.orderStatus == 'OUT FOR DELIVERY') {
                    $('#updateModalDeliveryLBC').modal("show");
                    $('#updateOrderIdDeliveryLBC').val(obj.orderId);
                    $('#updateStatusDeliveryLBC')
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
        form.append('updateOrderDelivery', true);

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
                    $('#updateModalDelivery').modal("hide");
                    lalamoveGcash.ajax.reload(null, false);
                    lbcPickUp.ajax.reload(null, false);
                    lbcDoor2Door.ajax.reload(null, false);
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

    // SUBMIT UPDATE LBC
    $('#updateFormLBC').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('updateOrderDeliveryLBC', true);

        $.ajax({
            type: "POST",
            url: "./backend/orders.php",
            data: form,
            dataType: "text",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                $('#updateBtnLBC').attr('disabled', true);
                $('#updateBtnLBC').text('Loading...');
            },
            complete: function() {
                $('#updateBtnLBC').attr('disabled', false);
                $('#updateBtnLBC').text('Update');
            },
            success: function(response) {
                if (response.includes('success')) {
                    $('#updateModalDeliveryLBC').modal("hide");
                    lalamoveGcash.ajax.reload(null, false);
                    lbcPickUp.ajax.reload(null, false);
                    lbcDoor2Door.ajax.reload(null, false);
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
    $('#updateModalDelivery').on('hidden.bs.modal', function() {
        $('#updateForm')[0].reset();
        $('#reasonContainerDelivery').addClass('d-none');
    });
})
</script>

<?php
include './components/bottom.php';
?>