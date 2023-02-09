<?php
include './components/head_css.php';
include './components/navbar.php';

?>

<style>
input[type='number'] {
    -moz-appearance: textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

.header-container {
    background: #fe827a !important;
    color: #fff !important;
    padding: 5px 15px;
    border-radius: 3px;
    text-transform: uppercase;
    font-weight: 600;
}

.untree_co-section {
    padding-bottom: 10px !important;
    padding-top: 40px !important;
}
</style>


<!-- Start Hero Section -->
<div class="hero p-2">
    <div class="container pt-4">
        <div class="row justify-content-between">
            <div class="col-lg-12">
                <div class="text-start">
                    <h1 style="letter-spacing: .1rem;">Shop Plants</h1>
                    <h6 class="text-white" style="letter-spacing: .1rem;">Browse through our selection and find the perfect plant for your space.</h6>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Hero Section -->

<?php
$getCategory = mysqli_query($conn, "SELECT * FROM tbl_category WHERE isDeleted = 0");
    if(mysqli_num_rows($getCategory) > 0) {
        foreach($getCategory as $category) {
            $categoryId = $category['categoryId'];
            $getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE categoryId = $categoryId AND isDeleted = 0");

            if(mysqli_num_rows($getProduct) > 0) {
                ?>
                <!--<div class="container text-center">-->
                <!--    <span class="text-light header-container h4 text-center"><?= $category['categoryName'] ?></span>-->
                <!--</div>-->
                
                <div class="container mt-5 text-center">
                    <span class="text-dark h2 text-center" style="letter-spacing: .1rem;"><?= $category['categoryName'] ?></span>
                </div>

                <div class="untree_co-section product-section before-footer-section">
                    <div class="container">
                        <div class="row d-flex flex-row justify-content-center">
                <?php
                
                //REVISION
                // Do not restrict the customer from
                // viewing the products even if they are
                // out of stock or unavailable. Instead,
                // disable the quantity input, change
                // the price to "not available," or
                // disable the "add to cart" button and
                // replace the text with "out of stock."
                
                //In short if item is out of stock display not available and make the button disabled
                
                //BEFORE REVISIONS
                
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
                                <a class="product-item h-100" href="view-product.php?productId=<?= $product['productId'] ?>">
                                <!--<a class="product-item h-100" href="javascript:void(0)">-->
                                    <img src="./admin/assets/images/productImages/<?= $product['productThumbnail'] ?>"
                                        class="img-fluid product-thumbnail">
                                    <h3 class="text-danger fw-bold">OUT OF STOCK</h3>
                                    <h3 class="product-title"><?= $product['productName'] ?></h3>
                                    <strong class="product-price">P<?= $product['productPrice'] ?></strong>
                                    <!--<h4><strong>Stock: </strong><?= $product['productStock']; ?></h4>-->

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
                            <a class="product-item h-100" href="view-product.php?productId=<?= $product['productId'] ?>">
                            <!--<a class="product-item h-100" href="javascript:void(0)">-->
                                <img src="./admin/assets/images/productImages/<?= $product['productThumbnail'] ?>"
                                    class="img-fluid product-thumbnail">
                                <h3 class="text-danger fw-bold">NOT AVAILABLE</h3>
                                <h3 class="product-title"><?= $product['productName'] ?></h3>
                                <strong class="product-price">P<?= $product['productPrice'] ?></strong>

                                <span class="icon-cross">
                                    <img src="./assets/images/cross.svg" class="img-fluid">
                                </span>
                            </a>
                        </div>
                        <?php
                    }
                }
                }
                
                //End of BEFORE REVISIONS
                
                //After revisions
                
               
                
                //End of after revisions
                
                
               ?>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="container text-center">
            <span class="h4">No product available</span>
        </div>
        <?php
    }
?>

<script>
$(document).ready(function() {})
</script>

<?php
include './components/footer.php';
include './components/bottom-script.php';
?>