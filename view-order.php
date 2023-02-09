<?php 
session_start();
require_once './database/config.php';

if(!isset($_GET['id'])) {
    ?>
    <script>
        location.href = 'current-order.php';
    </script>
    <?php
} else {
    $orderId = $_GET['id'];
    $userId = $_SESSION['margaux_user_id'];
    $getOrderUser = mysqli_query($conn, "SELECT * FROM tbl_order WHERE orderId = $orderId AND userId = $userId");

    if(mysqli_num_rows($getOrderUser) <= 0) {
        ?>
        <script>
            location.href = 'current-order.php';
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Margaux Cacti & Succulents Corner</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./admin/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./admin/assets/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="./admin/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="./admin/assets/css/style.css">
    <link rel="stylesheet" href="./admin/assets/css/custom.css">
    <!-- endinject -->
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- endfontawesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="shortcut icon" href="./admin/assets/images/logo.png" />
    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <!-- datatables -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.1/sorting/numeric-comma.js"></script>
</head>

<style>
    table, thead, tbody  {
        border: 1px solid #ebebeb !important;
    }

    table td, table th {
        border-bottom: 1px solid #ebebeb !important;
    }

    @media print {
        #printBtn {
            display: none;
        }

        #invoiceRow {
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>
<!-- main-panel ends -->



<?php
        $getCustomerInfo = mysqli_query($conn, "SELECT tbl_order.*, tbl_order_address.*, tbl_user.*, refbrgy.*, refcitymun.*, refprovince.*
        FROM tbl_order
        LEFT JOIN tbl_order_address
        ON tbl_order.orderId = tbl_order_address.orderId
        LEFT JOIN tbl_user
        ON tbl_order.userId = tbl_user.user_id
        LEFT JOIN refbrgy
        ON tbl_order_address.billingBarangay = refbrgy.brgyCode
        LEFT JOIN refcitymun
        ON tbl_order_address.billingCity = refcitymun.citymunCode
        LEFT JOIN refprovince
        ON tbl_order_address.billingProvince = refprovince.provCode WHERE tbl_order.orderId = $orderId");

        foreach($getCustomerInfo as $row) {
        ?>
        <div class="row m-md-5 m-1" id="invoiceRow">
            <a href="javascript:window.print()" class="btn btn-primary hidden-print ml-2 mb-2" id="printBtn">PRINT</a>
            <div class="col-md-12 grid-margin">
                <div id="invoicePage" class="card p-4" style="padding-bottom: 100px !important;">
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <img class="text-left" src="./assets/images/logo.png"
                                style="width: 100px; height: 100px; object-fit: cover;" alt="">
                        </div>
                        <div class="col-sm-6 text-right">
                            <h5 style="font-weight: 700;">Margaux Cacti & Succulents Corner</h5>
                            <h6 style="line-height: 18px; font-size: 14px;">Brgy Sto Nino Purok 1<br>Near Purok 1 Sto
                                Nino Basketball Court,<br>Cabanatuan City,<br>Philippines</h6>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="card p-3" style="background: #f5f5f5; border-radius: 5px;">
                                <h6><strong>Order ID:</strong> <span>#<?= $row['orderId'] ?></span></h6>
                                <h6><strong>Order Date & Time:</strong> <span><?= date('F d, Y h:i A', strtotime($row['orderDateTime'])) ?></span></h6>
                                <h6><strong>Delivery Mode: </strong><span><?= $row['deliveryMethod'] ?></span></h6>
                                <?php
                                if($row['deliveryMethod'] == 'DELIVERY') {
                                ?>
                                <h6><strong>Preferred Courier: </strong><span><?= $row['courier'] ?></span></h6>
                                <?php
                                }
                                ?>
                                <?php
                                if($row['courier'] == 'LBC EXPRESS') {
                                ?>
                                <h6><strong>LBC EXPRESS MODE: </strong><span><?= $row['lbcMode'] ?></span></h6>
                                <?php
                                }
                                ?>
                                <h6><strong>Payment Mode: </strong><span><?= $row['paymentMethod'] ?></span></h6>
                                <!-- DELIVERY MODE PICKUP -->
                                <!-- COP -->
                                <?php
                                if($row['deliveryMethod'] == 'PICK UP') {
                                ?>
                                <h6><strong>Pick Up Date & Time:</strong> <span><?= date('F d, Y h:i A', strtotime($row['pickupDateTime'])) ?></span></h6>
                                <?php
                                }
                                ?>
                                <h6><strong>Status:</strong> <span class="badge text-bg-primary"
                                        style="background: #f0ad4e; font-weight: 600; border-radius: 3px;"><?= $row['orderStatus'] ?></span>
                                </h6>
                                <?php
                                if($row['orderStatus'] == 'CANCELLED') {
                                ?>  
                                <h6><strong>Reason:</strong> <span><?= $row['reason'] ?></span>
                                </h6>
                                <?php
                                }
                                ?>
                                <?php
                                if($row['orderStatus'] == 'COMPLETED') {
                                ?>  
                                <h6><strong>Date & Time Completed:</strong> <span class="badge text-bg-primary"
                                        style="background: #fe827a; font-weight: 600; border-radius: 3px;"><?= date('F d, Y h:i A', strtotime($row['orderDateTimeCompleted'])) ?></span>
                                </h6>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h6><strong>Customer Info</strong></h6>
                            <h6><?= $row['billingFullName'] ?></h6>
                            <h6><?= $row['email'] ?></h6>
                            <h6>+63<?= $row['billingContactNum'] ?></h6>
                            <h6><?= $row['billingBlock'] ?></h6>
                            <h6><?= $row['brgyDesc'] ?></h6>
                            <h6><?= $row['citymunDesc'] ?></h6>
                            <h6><?= $row['provDesc'] ?></h6>
                        </div>

                        <?php
                        if($row['lbcMode'] == 'PICK UP') {
                        ?>
                        <div class="col-12 mt-4">
                            <h6><strong>Nearest LBC Branch</strong></h6>
                            <h6><?= $row['nearestLBC'] ?></h6>
                        </div>
                        <?php
                        }
                        ?>

                        <?php
                        if($row['paymentMethod'] == 'GCASH') {
                        ?>
                        <div class="col-12 mt-4">
                            <h6><strong>Payment Proof</strong></h6>
                            <img id="proofOfPayment" style="width: 100px; height: 100px; object-fit: cover;" src="./admin/assets/images/gcashPaymentProof/<?= $row['paymentProof'] ?>" alt="">
                            <h6><strong>Reference No: </strong><?= $row['referenceNum'] ?></h6>
                            <h6><strong>Gcash No: </strong>+63<?= $row['gcashNumber'] ?></h6>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="col-12 mt-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Items</th>
                                            <th class="text-right">Price Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $getItems = mysqli_query($conn, "SELECT tbl_order_items.*, tbl_category.*, tbl_product.*
                                        FROM tbl_order_items
                                        LEFT JOIN tbl_product
                                        ON tbl_order_items.productId = tbl_product.productId
                                        LEFT JOIN tbl_category
                                        ON tbl_category.categoryId = tbl_product.categoryId WHERE tbl_order_items.orderId = $orderId");

                                        foreach($getItems as $rowItems) {
                                        ?>
                                        <tr>
                                            <td>
                                            <h6 style="font-weight: 500;"><?= $rowItems['productName']; ?></h6>
                                            <h6 style="font-weight: 400; font-size: 13px"><?= $rowItems['categoryName']; ?></h6>
                                            <h6 style="font-weight: 500; font-size: 13px">x<?= $rowItems['productQty']; ?></h6>
                                            </td>
                                            <td class="text-right">
                                                <h6 style="font-weight: 700;">₱ <?= $rowItems['productTotal']; ?></h6>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="2">
                                                <h6><strong class="pr-4">Total:</strong>₱ <span style="font-weight: 900; font-size: 18px"><?= $row['orderTotal'] ?></span></h6>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>

<script>
$(window).on('load', function() {

})

$(document).ready(function() {
    // PRINT INVOICE
    const printBtn = document.getElementById('printBtn');

    printBtn.addEventListener('click', function() {
        print();
    })
    // VIEW IMAGE
    $('#proofOfPayment').click(function(e) {
        e.preventDefault();

        var img_to_load = $(this).attr('src'),
        imgWindow = window.open(img_to_load);
    });
})
</script>

<?php
include './admin/components/bottom.php';
?>