<?php 
include './components/head_css.php'; 
include './components/navbar_sidebar.php'; 

if(!isset($_GET['id'])) {
    ?>
    <script>
        location.href = '<?= $_SESSION["margaux_link_admin"] ?>';
    </script>
    <?php
} else {
    $orderId = $_GET['id'];
}
?>

<style>
    table, thead, tbody  {
        border: 1px solid #ebebeb !important;
    }

    table td, table th {
        border-bottom: 1px solid #ebebeb !important;
    }

    /* @media print {
        body * {
            display: none;
        }

        .main-panel, .main-panel * {
            display: block;
        }
    } */
</style>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="mr-md-3 mr-xl-5 p-0">
                            <h2>View Order</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">View Order</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button onclick="location.href='print-order.php?id=<?= $orderId; ?>'" class="btn btn-primary mb-4" id="printBtn">PRINT</button>
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
        <div class="row" id="invoiceRow">
            <div class="col-md-12 grid-margin">
                <div id="invoicePage" class="card p-4" style="padding-bottom: 100px !important;">
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <img class="text-left" src="../assets/images/logo.png"
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
                            <img id="proofOfPayment" style="width: 100px; height: 100px; object-fit: cover;" src="./assets/images/gcashPaymentProof/<?= $row['paymentProof'] ?>" alt="">
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
                                                <h6 style="font-weight: 700;">P<?= $rowItems['productTotal']; ?></h6>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="2">
                                                <h6><strong class="pr-4">Total:</strong><span style="font-weight: 900; font-size: 18px">P<?= $row['orderTotal'] ?></span></h6>
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
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->

<script>
$(window).on('load', function() {

})

$(document).ready(function() {
    // VIEW IMAGE
    $('#proofOfPayment').click(function(e) {
        e.preventDefault();

        var img_to_load = $(this).attr('src'),
        imgWindow = window.open(img_to_load);
    });
})
</script>

<?php
include './components/bottom.php';
?>