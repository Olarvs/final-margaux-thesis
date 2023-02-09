<?php
include './components/head_css.php';
include './components/navbar.php';

if(!isset($_GET['categoryId'])) {
?>
<script>
location.href = 'index.php';
</script>
<?php
} else {
    $categoryId = $_GET['categoryId'];

    $getCategoryName = mysqli_query($conn, "SELECT * FROM tbl_category WHERE categoryId = $categoryId AND isDeleted = 0");

    $row = mysqli_fetch_array($getCategoryName);

    $categoryName = $row['categoryName'];
}
?>

<style>
input[type='number'] {
    -moz-appearance: textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
</style>


<!-- Start Hero Section -->
<div class="hero p-2">
    <div class="container  pt-4">
        <div class="row justify-content-between">
            <div class="col-lg-12">
                <div class="text-start">
                    <h1 style="letter-spacing: .1rem;">Shop <?= $categoryName ?></h1>
                    <h6 class="text-white" style="letter-spacing: .1rem;">Browse through our selection and find the perfect <span class="text-lowercase"><?= $categoryName ?></span> for your space.</h6>
                    <!--<h1><?= $categoryName ?></h1>-->

                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Hero Section -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 productName" id="staticBackdropLabel">Cacti</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addToCartForm">
                    <input type="hidden" name="userId" id="userId" class="form-control mb-3" value="<?= $userId ?>">
                    <input type="hidden" name="productId" id="productId" class="form-control mb-3">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img class="productThumbnail" src="./assets/images/cactus14.jpg"
                                style="object-fit: cover; width: 250px; height: 250px" alt="">
                        </div>
                        <div class="col-md-12">
                            <p style="font-size: 14px;" class="productDesc"> Lorem ipsum dolor sit amet consectetur
                                adipisicing elit. Illo,
                                corrupti odit nihil qui
                                exercitationem cumque facere itaque placeat ipsam commodi!</p>
                        </div>
                        <div class="col-md-12 mt-3">
                            <p style="font-size: 16px;">Price: <span style="font-size: 21px;"
                                    class="fw-bold productPrice">1600.00</span>
                            </p>
                        </div>
                        <div class="col-md-12 d-flex flex-row align-items-center justify-content-start">
                            <div class="col-6 col-md-4">
                                <p class="fw-bold">Quantity</p>
                                <div class="d-flex flex-row gap-2 align-items-center qty-container">
                                    <button style="padding: 7px 15px;" type="button"
                                        class="btn btn-primary prev qtyBtn">-</button>
                                    <input style="height: 40px;" class="form-control number-spinner" type="number"
                                        name="qty" id="qty" value="1" min="1" readonly>
                                    <button style="padding: 7px 15px;" type="button"
                                        class="btn btn-primary next qtyBtn">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addToCartForm" class="btn btn-primary">Add to Cart</button>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row d-flex flex-row justify-content-center">
            <?php
            $getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE categoryId = $categoryId AND isDeleted = 0");

            if(mysqli_num_rows($getProduct) > 0) {
            foreach($getProduct as $product) {
            if($product['productStatus'] == 'Available') {
            if($product['productStock'] > 0) {
            ?>
            <div class="col-12 col-md-4 col-lg-3 mb-5 plant" data-id="<?= $product['productId'] ?>">
                <a class="product-item h-100" href="view-product.php?productId=<?= $product['productId'] ?>">
                    <img src="./admin/assets/images/productImages/<?= $product['productThumbnail'] ?>"
                        class="img-fluid product-thumbnail">
                    <h3 class="product-title" style="letter-spacing: .1rem;"><?= $product['productName'] ?></h3>
                    <strong class="product-price" style="letter-spacing: .1rem;">P<?= $product['productPrice'] ?></strong>
                    <!--<p style="font-weight: 600; font-size: 15px;">Stock: <?= $product['productStock']; ?></p>-->

                    <span class="icon-cross">
                        <img src="./assets/images/cross.svg" class="img-fluid">
                    </span>
                </a>
            </div>
            <?php
            } else {
            ?>
            <div class="col-12 col-md-4 col-lg-3 mb-5">
                <a class="product-item h-100" href="javascript:void(0)">
                    <img src="./admin/assets/images/productImages/<?= $product['productThumbnail'] ?>"
                        class="img-fluid product-thumbnail">
                    <h3 class="text-danger fw-bold" style="letter-spacing: .1rem;">NOT AVAILABLE</h3>
                    <h3 class="product-title" style="letter-spacing: .1rem;"><?= $product['productName'] ?></h3>
                    <strong class="product-price" style="letter-spacing: .1rem;">P<?= $product['productPrice'] ?></strong>
                    <h4 style="letter-spacing: .1rem;"><strong>Stock: </strong><?= $product['productStock']; ?></h4>

                    <span class="icon-cross">
                        <img src="./assets/images/cross.svg" class="img-fluid">
                    </span>
                </a>
            </div>
            <?php
            }
            } else {
            ?>
            <div class="col-12 col-md-4 col-lg-3 mb-5">
                <a class="product-item h-100" href="javascript:void(0)">
                    <img src="./admin/assets/images/productImages/<?= $product['productThumbnail'] ?>"
                        class="img-fluid product-thumbnail">
                    <h3 class="text-danger fw-bold" style="letter-spacing: .1rem;">NOT AVAILABLE</h3>
                    <h3 class="product-title" style="letter-spacing: .1rem;"><?= $product['productName'] ?></h3>
                    <strong class="product-price" style="letter-spacing: .1rem;">P<?= $product['productPrice'] ?></strong>

                    <span class="icon-cross">
                        <img src="./assets/images/cross.svg" class="img-fluid">
                    </span>
                </a>
            </div>
            <?php
            }
            }
            } else {
            ?>
            <h6 class="text-center">No product available.</h6>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
})
</script>

<?php
include './components/footer.php';
include './components/bottom-script.php';
?>