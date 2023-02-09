<?php 
include './components/head_css.php'; 
include './components/navbar_sidebar.php'; 
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="mr-md-3 mr-xl-5">
                            <h2>Dashboard</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body dashboard-tabs p-0">
                        <ul class="nav nav-tabs px-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pickup-tab" data-toggle="tab" href="#pickup" role="tab"
                                    aria-controls="pickup" aria-selected="true">PICK UP</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="delivery-tab" data-toggle="tab" href="#delivery" role="tab"
                                    aria-controls="delivery" aria-selected="false">DELIVERY</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab"
                                    aria-controls="inventory" aria-selected="false">INVENTORY</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-tab" data-toggle="tab" href="#product" role="tab"
                                    aria-controls="product" aria-selected="false">PRODUCT</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab"
                                    aria-controls="sales" aria-selected="false">SALES</a>
                            </li>
                        </ul>
                        <div class="tab-content py-0 px-0">
                            <!-- PICK UP TAB -->
                            <div class="tab-pane fade show active" id="pickup" role="tabpanel"
                                aria-labelledby="pickup-tab">
                                <div class="d-flex flex-wrap justify-content-xl-between">
                                    <div
                                        class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-list-ul icon-lg mr-3 text-primary"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">PENDING</small>
                                            <?php
                                            $getPickUpPending = mysqli_query($conn, "SELECT * FROM tbl_order WHERE deliveryMethod = 'PICK UP' AND orderStatus = 'PENDING'");

                                            $pendingPickUpCount = mysqli_num_rows($getPickUpPending);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $pendingPickUpCount ?></h5>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-list-check mr-3 icon-lg text-danger"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">CONFIRMED</small>
                                            <?php
                                            $getPickUpConfirmed = mysqli_query($conn, "SELECT * FROM tbl_order WHERE deliveryMethod = 'PICK UP' AND orderStatus = 'CONFIRMED'");

                                            $confirmedPickUpCount = mysqli_num_rows($getPickUpConfirmed);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $confirmedPickUpCount; ?></h5>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-boxes-packing mr-3 icon-lg text-success"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">READY TO PICK UP</small>
                                            <?php
                                            $getPickUpRtp = mysqli_query($conn, "SELECT * FROM tbl_order WHERE deliveryMethod = 'PICK UP' AND orderStatus = 'READY TO PICK UP'");

                                            $rtpPickUpCount = mysqli_num_rows($getPickUpRtp);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $rtpPickUpCount ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- DELIVERY TAB -->
                            <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
                                <div class="d-flex flex-wrap justify-content-xl-between">
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-list-ul mr-3 icon-lg text-warning"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">PENDING</small>
                                            <?php
                                            $getDeliveryPending = mysqli_query($conn, "SELECT * FROM tbl_order WHERE deliveryMethod = 'DELIVERY' AND orderStatus = 'PENDING'");

                                            $pendingDeliveryCount = mysqli_num_rows($getDeliveryPending);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $pendingDeliveryCount ?></h5>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-list-check mr-3 icon-lg text-success"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">CONFIRMED</small>
                                            <?php
                                            $getDeliveryConfirmed = mysqli_query($conn, "SELECT * FROM tbl_order WHERE deliveryMethod = 'DELIVERY' AND orderStatus = 'CONFIRMED'");

                                            $confirmedDeliveryCount = mysqli_num_rows($getDeliveryConfirmed);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $confirmedDeliveryCount ?></h5>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-box mr-3 icon-lg text-danger"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">PACKED (READY TO SHIP)</small>
                                            <?php
                                            $getDeliveryPacked = mysqli_query($conn, "SELECT * FROM tbl_order WHERE deliveryMethod = 'DELIVERY' AND orderStatus = 'PACKED (READY TO SHIP)'");

                                            $packedDeliveryCount = mysqli_num_rows($getDeliveryPacked);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $packedDeliveryCount ?></h5>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-truck-ramp-box mr-3 icon-lg text-danger"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">OUT FOR DELIVERY</small>
                                            <?php
                                            $getDeliveryOfd = mysqli_query($conn, "SELECT * FROM tbl_order WHERE deliveryMethod = 'DELIVERY' AND orderStatus = 'OUT FOR DELIVERY'");

                                            $ofdDeliveryCount = mysqli_num_rows($getDeliveryOfd);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $ofdDeliveryCount ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $getStockSettings = mysqli_query($conn, "SELECT * FROM tbl_stock_settings");

                            $fetchStockSettings = mysqli_fetch_array($getStockSettings);

                            $lowQtyValue = $fetchStockSettings['lowStock'];
                            ?>
                            <!-- INVENTORY TAB -->
                            <div class="tab-pane fade" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
                                <div class="d-flex flex-wrap justify-content-xl-between">
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-cubes-stacked mr-3 icon-lg text-success"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">IN STOCK</small>
                                            <?php
                                            $getInStock = mysqli_query($conn, "SELECT tbl_category.*, tbl_product.*
                                            FROM tbl_category
                                            LEFT JOIN tbl_product
                                            ON tbl_category.categoryId = tbl_product.categoryId
                                            WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0 AND tbl_product.productStock >= $lowQtyValue");

                                            $inStockCount = mysqli_num_rows($getInStock);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $inStockCount ?></h5>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-boxes-stacked mr-3 icon-lg text-warning"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">LOW STOCK</small>
                                            <?php
                                            $getLowStock = mysqli_query($conn, "SELECT tbl_category.*, tbl_product.*
                                            FROM tbl_category
                                            LEFT JOIN tbl_product
                                            ON tbl_category.categoryId = tbl_product.categoryId
                                            WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0 AND (tbl_product.productStock <= $lowQtyValue AND tbl_product.productStock != 0)");

                                            $lowStockCount = mysqli_num_rows($getLowStock);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $lowStockCount ?></h5>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-inbox mr-3 icon-lg text-danger"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">OUT OF STOCK</small>
                                            <?php
                                            $getOutStock = mysqli_query($conn, "SELECT tbl_category.*, tbl_product.*
                                            FROM tbl_category
                                            LEFT JOIN tbl_product
                                            ON tbl_category.categoryId = tbl_product.categoryId
                                            WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0 AND tbl_product.productStock = 0");

                                            $outStockCount = mysqli_num_rows($getOutStock);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $outStockCount ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- PRODUCT TAB -->
                            <div class="tab-pane fade" id="product" role="tabpanel" aria-labelledby="product-tab">
                                <div class="d-flex flex-wrap justify-content-xl-between">
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-box-open mr-3 icon-lg text-success"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">CATEGORY</small>
                                            <?php
                                            $getCategory = mysqli_query($conn, "SELECT * FROM tbl_category WHERE isDeleted = 0");

                                            $categoryCount = mysqli_num_rows($getCategory);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $categoryCount ?></h5>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-boxes-stacked mr-3 icon-lg text-warning"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">PRODUCT</small>
                                            <?php
                                            $getProduct = mysqli_query($conn, "SELECT tbl_category.*, tbl_product.*
                                            FROM tbl_category
                                            LEFT JOIN tbl_product
                                            ON tbl_category.categoryId = tbl_product.categoryId
                                            WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0");

                                            $productCount = mysqli_num_rows($getProduct);
                                            ?>
                                            <h5 class="mr-2 mb-0"><?= $productCount ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- SALES TAB -->
                            <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                                <div class="d-flex flex-wrap justify-content-xl-between">
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-money-bills mr-3 icon-lg text-success"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">TODAY SALES</small>
                                            <?php
                                            $date = date('Y-m-d');
                                            $getTodaySales = mysqli_query($conn, "SELECT SUM(orderTotal)
                                            FROM tbl_order
                                            WHERE orderDateTimeCompleted
                                            LIKE '%$date%' AND orderStatus = 'COMPLETED'");

                                            $todaySales = mysqli_fetch_array($getTodaySales);
                                            ?>
                                            <h5 class="mr-2 mb-0">
                                                <?= number_format($todaySales['SUM(orderTotal)'], 2); ?></h5>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="fa-solid fa-sack-dollar mr-3 icon-lg text-warning"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">TOTAL SALES</small>
                                            <?php
                                            $getTotalSales = mysqli_query($conn, "SELECT SUM(orderTotal)
                                            FROM tbl_order
                                            WHERE orderStatus = 'COMPLETED'");

                                            $totalSales = mysqli_fetch_array($getTotalSales);
                                            ?>
                                            <h5 class="mr-2 mb-0">
                                                <?= number_format($totalSales['SUM(orderTotal)'], 2); ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card h-100">
                    <div class="card-body w-100 h-100">
                        <p class="card-title">Sales</p>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card h-100">
                    <div class="card-body w-100 h-100">
                        <p class="card-title">Best Seller</p>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card h-100">
                    <div class="card-body w-100 h-100">
                        <p class="card-title">Delivery Method</p>
                        <canvas id="myChart3"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card h-100">
                    <div class="card-body w-100 h-100">
                        <p class="card-title">Payment Method</p>
                        <canvas id="myChart4"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card h-100">
                    <div class="card-body w-100 h-100">
                        <p class="card-title">Courier</p>
                        <canvas id="myChart5"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Recent Purchases</p>
                        <div class="table-responsive">
                            <table id="recentPurchase" class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Delivery Method</th>
                                        <th>Payment Method</th>
                                        <th>Completed Date & Time</th>
                                        <th>Order Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getRecentOrder = mysqli_query($conn, "SELECT tbl_order.orderId, tbl_order_address.billingFullName, tbl_user.email, tbl_order.deliveryMethod, tbl_order.paymentMethod, tbl_order.orderDateTimeCompleted, tbl_order.orderTotal
                                    FROM tbl_order
                                    LEFT JOIN tbl_user
                                    ON tbl_order.userId = tbl_user.user_id
                                    LEFT JOIN tbl_order_address
                                    ON tbl_order.orderId = tbl_order_address.orderId
                                    WHERE tbl_order.orderStatus = 'COMPLETED' ORDER BY tbl_order.orderDateTimeCompleted DESC LIMIT 10");

                                    foreach($getRecentOrder as $fetch) {
                                    ?>
                                    <tr>
                                        <td><?= $fetch['billingFullName'] ?></td>
                                        <td><?= $fetch['email'] ?></td>
                                        <td><?= $fetch['deliveryMethod'] ?></td>
                                        <td><?= $fetch['paymentMethod'] ?></td>
                                        <td><?= date('F d, Y h:i A', strtotime($fetch['orderDateTimeCompleted'])) ?>
                                        </td>
                                        <td><?= $fetch['orderTotal'] ?></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.7/jquery.timeago.min.js"></script>
<!-- main-panel ends -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var dataTable = $('#recentPurchase').DataTable({
    "searching": false,
    "paging": false,
    "order": [
        [4, 'desc']
    ],
});
<?php
$date = date('Y-m-d', strtotime('+1 day'));
$last_seven_days = date('Y-m-d', strtotime('-8 days'));

$get_income = mysqli_query($conn, "SELECT DATE(orderDateTimeCompleted) as Date, SUM(orderTotal) as Total FROM tbl_order WHERE orderDateTimeCompleted IS NOT NULL AND orderDateTimeCompleted BETWEEN '$last_seven_days' AND '$date' AND orderStatus = 'COMPLETED' GROUP BY Date");

$sales = array();
$label = array();

foreach($get_income as $row) {
    $label[] = date('M d, Y', strtotime($row['Date']));
    $sales[] = $row['Total'];
}

$getProduct = mysqli_query($conn, "SELECT tbl_product.productName, COUNT(tbl_product.productName) as sale
FROM tbl_order
LEFT JOIN tbl_order_items
ON tbl_order.orderId = tbl_order_items.orderId
LEFT JOIN tbl_product
ON tbl_order_items.productId = tbl_product.productId
LEFT JOIN tbl_category
ON tbl_category.categoryId = tbl_product.categoryId
WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0 AND tbl_order.orderStatus = 'COMPLETED'
GROUP BY tbl_product.productName LIMIT 5");

$productLabel = array();
$productSale = array();

foreach($getProduct as $product) {
    $productLabel[] = $product['productName'];
    $productSale[] = $product['sale'];
}

$getDelivery = mysqli_query($conn, "SELECT deliveryMethod, COUNT(deliveryMethod) FROM tbl_order GROUP BY deliveryMethod");

$deliveryLabel = array();
$deliveryTotal = array();

foreach($getDelivery as $delivery) {
    $deliveryLabel[] = $delivery['deliveryMethod'];
    $deliveryTotal[] = $delivery['COUNT(deliveryMethod)'];
}

$getPayment = mysqli_query($conn, "SELECT paymentMethod, COUNT(paymentMethod) FROM tbl_order GROUP BY paymentMethod");

$paymentLabel = array();
$paymentTotal = array();

foreach($getPayment as $payment) {
    $paymentLabel[] = $payment['paymentMethod'];
    $paymentTotal[] = $payment['COUNT(paymentMethod)'];
}

$getCourier = mysqli_query($conn, "SELECT courier, COUNT(courier) FROM tbl_order WHERE orderStatus = 'COMPLETED' AND deliveryMethod = 'DELIVERY' GROUP BY courier");

$courierLabel = array();
$courierTotal = array();

foreach($getCourier as $courier) {
    $courierLabel[] = $courier['courier'];
    $courierTotal[] = $courier['COUNT(courier)'];
}
?>

// Charts.defaults.font.size = 20;
// Charts.defaults.font.family = "'Poppins', sans-serif";
// Chart.defaults.global.defaultFontSize = 8;

const data = {
    labels: <?= json_encode($label) ?>,
    datasets: [{
        label: 'Weekly Sales',
        data: <?= json_encode($sales) ?>,
        backgroundColor: [
            '#fe827a'
        ],
        borderColor: [
            '#fe827a'
        ],
        borderWidth: 1
    }]
};

const config = {
    type: 'line',
    data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
    }
};

const myChart = new Chart(
    document.getElementById('myChart'),
    config
);

const data2 = {
    labels: <?php echo json_encode($productLabel); ?>,
    datasets: [{
        label: '5 Best Seller',
        data: <?php echo json_encode($productSale)?>,
        backgroundColor: [
            '#68cfbc',
            '#fe827a',
            '#E0BBE4',
            '#FEC8D8',
            '#957DAD',
        ],
    }]
};

const config2 = {
    type: 'bar',
    data: data2,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};

// render init block
const myChart2 = new Chart(
    document.getElementById('myChart2'),
    config2
);

const data3 = {
    labels: <?php echo json_encode($deliveryLabel); ?>,
    datasets: [{
        label: 'Delivery Method',
        data: <?php echo json_encode($deliveryTotal)?>,
        backgroundColor: [
            '#68cfbc',
            '#fe827a',
        ],
    }]
};

const config3 = {
    type: 'bar',
    data: data3,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};

// render init block
const myChart3 = new Chart(
    document.getElementById('myChart3'),
    config3
);

const data4 = {
    labels: <?php echo json_encode($paymentLabel); ?>,
    datasets: [{
        label: 'Payment Method',
        data: <?php echo json_encode($paymentTotal)?>,
        backgroundColor: [
            '#68cfbc',
            '#fe827a',
        ],
    }]
};

const config4 = {
    type: 'bar',
    data: data4,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};

// render init block
const myChart4 = new Chart(
    document.getElementById('myChart4'),
    config4
);

const data5 = {
    labels: <?php echo json_encode($courierLabel); ?>,
    datasets: [{
        label: 'Courier',
        data: <?php echo json_encode($courierTotal)?>,
        backgroundColor: [
            '#68cfbc',
            '#fe827a',
        ],
    }]
};

const config5 = {
    type: 'bar',
    data: data5,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};

// render init block
const myChart5 = new Chart(
    document.getElementById('myChart5'),
    config5
);
</script>

<?php
include './components/bottom.php';
?>