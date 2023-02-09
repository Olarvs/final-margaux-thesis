<?php
include './components/head_css.php';
include './components/navbar.php';

if(!isset($_GET['cartId'])) {
?>
<script>
location.href = 'cart.php';
</script>
<?php
} else {
    $cartId = $_GET['cartId'];
    $_SESSION['cartId'] = $_GET['cartId'];
    $getProductId = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE cartId = $cartId");

    $fetchProductId = mysqli_fetch_array($getProductId);
    $productId = $fetchProductId['productId'];
    $productQty = $fetchProductId['productQty'];
    $productTotal = $fetchProductId['productTotal'];
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

.customContainer {
    width: 1000px;
    max-width: 95%;
}

.cardPlant {
    background: #fe827a;
    border-color: #fe827a;
    color: #fff;
}

.customBtn {
    background-color: #212529 !important;
    border-color: #212529 !important;
}

.customBtn:hover {
    background-color: #fff !important;
    border-color: #fff !important;
    color: #212529;
}

.descSection {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>

<?php
$getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId AND isDeleted = 0");

$maxStock = 0;
foreach($getProduct as $row) {
$maxStock = $row['productStock'];
?>
<div class="container my-4 customContainer">
    <div class="row">
        <form id="updateToCartForm">
            <div class="card rounded p-3 cardPlant shadow-lg">
                <!--<h1 class="text-uppercase fw-bold"><?= $row['productName'] ?></h1>-->
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <!--<img src="./admin/assets/images/productImages/<?= $row['productThumbnail'] ?>" alt=""-->
                        <!--    style="width: 100%; height: 300px; object-fit: cover;">-->
                        <img onclick="window.open('./admin/assets/images/productImages/<?= $row['productThumbnail'] ?>')"
                            src="./admin/assets/images/productImages/<?= $row['productThumbnail'] ?>" alt=""
                            class="d-block w-100 p-3">
                    </div>
                    
                    <div class="col-sm-6 mt-3 mt-sm-0">
                        <div class="descSection mt-2">
                            <h1 class="fw-bold" style="letter-spacing: .1rem;"><?= $row['productName'] ?></h1> 
                            
                            <h6 class="text-start d-none" id="productId"><?= $row['productId'] ?></h6>
                            <h6 class="text-start d-none" id="categoryId"><?= $row['categoryId'] ?></h6>
                            
                            <div class="d-flex flex-column">
                                <h4 class="mt-3 text-dark" style="letter-spacing: .1rem;"><strong>&#8369;</strong><strong
                                        id="productPrice"><?= $row['productPrice'] ?></strong></h4>
                                
                                <small class="text-dark">Quantity</small>
                                <div class="d-flex flex-row gap-2 qty-container mb-4" style="width: 50%;">
                                    <button style="padding: 7px 15px;" type="button"
                                    class="btn btn-primary prev qtyBtn customBtn">-</button>
                                    <input class="form-control number-spinner" type="number" name="qty" id="qty" value="1"
                                    min="1" readonly>
                                    <button style="padding: 7px 15px;" type="button"
                                    class="btn btn-primary next qtyBtn customBtn">+</button>
                                </div>
                                <button type="submit" class="btn btn-primary mt-sm-0 mt-2 customBtn" id="updateToCartBtn" style="letter-spacing: .1rem;">Update cart</button>
                                <h4 class="text-dark mt-3"><small>Sub-total:</small> <strong>&#8369;</strong><strong
                                        id="productTotal"><?= $productTotal ?></strong>
                                </h4>
                                <h6 class="mt-4 text-dark">
                                    <small>Available Stock:</small> <?= $row['productStock'] ?>
                                </h6>
                                <h5 class="text-start text-dark" style="letter-spacing: .1rem;"><?= ucfirst($row['productDesc']); ?></h5>
                                
                                
                            </div>
                        </div>
                    </div>
                 </div>
                <!--<div class="row mt-3">-->
                <!--    <div class="d-flex flex-column flex-sm-row justify-content-between">-->
                <!--        <div class="d-flex flex-row gap-2 qty-container">-->
                <!--            <button style="padding: 7px 15px;" type="button"-->
                <!--                class="btn btn-primary prev qtyBtn customBtn">-</button>-->
                <!--            <input class="form-control number-spinner" type="number" name="qty" id="qty"-->
                <!--                value="<?= $productQty ?>" min="1" readonly>-->
                <!--            <button style="padding: 7px 15px;" type="button"-->
                <!--                class="btn btn-primary next qtyBtn customBtn">+</button>-->
                <!--        </div>-->
                <!--        <button type="submit" class="btn btn-primary mt-sm-0 mt-2 customBtn" id="updateToCartBtn">Update-->
                <!--            to-->
                <!--            Cart</button>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </form>
    </div>
</div>
<?php
}
?>

<script>
$(document).ready(function() {
    $('.prev').on('click', function() {
        var prev = $(this).closest('.qty-container').find('input')
            .val();

        if (prev == 1) {
            var a = 1;
            $(this).closest('.qty-container').find('input').val(a);
        } else {
            var prevVal = prev - 1;
            $(this).closest('.qty-container').find('input').val(
                prevVal);
        }
    });

    $('.next').on('click', function() {
        var next = $(this).closest('.qty-container').find('input')
            .val();

        if (next == <?= $maxStock ?>) {
            $(this).closest('.qty-container').find('input').val(<?= $maxStock ?>);
        } else {
            var nextVal = ++next;
            $(this).closest('.qty-container').find('input').val(
                nextVal);
        }
    });

    $(".qtyBtn").on('click', function() {
        var total = parseFloat($('.number-spinner').val()).toFixed(2);
        var price = parseFloat($('#productPrice').text()).toFixed(2);

        var sum = parseFloat(total * price).toFixed(2);
        $('#productTotal').text(sum);
    });

    // ADD TO CART
    $('#updateToCartForm').on('submit', function(e) {
        e.preventDefault();

        var max = <?= $maxStock ?>;

        if ($('#qty').val() > max) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Out of stock! Available stock is ' + max + '.',
                iconColor: '#000',
                confirmButtonColor: '#000',
                showConfirmButton: false,
                color: '#000',
                background: '#fe827a',
                timer: 5000,
                timerProgressBar: true,
            });
        } else {
            var get_form = $('#updateToCartForm')[0];
            var form = new FormData(get_form);
            form.append('productId', $('#productId').text());
            form.append('categoryId', $('#categoryId').text());
            form.append('productPrice', $('#productPrice').text());
            form.append('productTotal', $('#productTotal').text());
            form.append('updateToCart', true);

            $.ajax({
                type: "POST",
                url: "./backend/add-to-cart.php",
                data: form,
                dataType: 'text',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#updateToCartBtn').prop('disabled', true);
                    $('#updateToCartBtn').text('Processing...');
                },
                complete: function() {
                    $('#updateToCartBtn').prop('disabled', false);
                    $('#updateToCartBtn').text('Update to Cart');
                },
                success: function(response) {
                    if (response.includes('success')) {
                        localStorage.setItem('status', 'updated');
                        location.href = 'cart.php';
                    } else if (response.includes('login first')) {
                        <?php
                        $_SESSION["margaux_link_user"] = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        ?>
                        Swal.fire({
                            icon: 'info',
                            title: 'Welcome to Margaux Corner!',
                            text: 'To order this product you need to login first!',
                            iconColor: '#000',
                            confirmButtonColor: '#000',
                            showConfirmButton: true,
                            confirmButtonText: 'Login',
                            color: '#000',
                            background: '#fe827a',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'login.php';
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ooops...',
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
        }
    })

})
</script>

<?php
include './components/bottom-script.php';
?>