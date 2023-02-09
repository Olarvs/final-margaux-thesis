<?php
include './components/head_css.php';
include './components/navbar.php';

if(!isset($_GET['productId'])) {
?>
<script>
location.href = 'index.php#categorySection';
</script>
<?php
} else {
    $productId = $_GET['productId'];
}
?>

<style>
body {
    background-color: #EBDCD5;
    /*background: url(./assets/images/bgpink.png) no-repeat;*/
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    height: 100vh;
}

.bottom {
    position: fixed;
    width: 100%;
    bottom: 0;
    height: auto;
}

input[type='number'] {
    -moz-appearance: textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

.customContainer {
    /* position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); */
    width: 1000px;
    max-width: 95%;
}

.cardPlant {
    background: #fe827a;
    border-color: #fe827a;
    color: #fff;
    /* margin-top: 120px; */
}

h6,
h4,
h5 {
    color: #212529;
    letter-spacing: 1px;
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

/*.descSection {*/
/*    height: 100%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    justify-content: space-between;*/
/*}*/

/* .hero-top {
    position: fixed;
    z-index: 2;
    width: 100%;
} */
</style>

<?php
$getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId AND isDeleted = 0");

$maxStock = 0;
foreach($getProduct as $row) {
$maxStock = $row['productStock'];
?>
<!--<div class="hero hero-top p-2">-->
<!--    <div class="container  pt-4">-->
<!--        <div class="row justify-content-between">-->
<!--            <div class="col-lg-12">-->
<!--                <div class="text-center">-->
<!--                    <h1><?= $row['productName'] ?></h1>-->

<!--                </div>-->
<!--            </div>-->

<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="container my-4 customContainer">
    <div class="row">
        <form id="addToCartForm">
            <div class="card rounded p-3 cardPlant shadow-lg">
                
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <!--<img onclick="window.open('./admin/assets/images/productImages/<?= $row['productThumbnail'] ?>')"-->
                        <!--    src="./admin/assets/images/productImages/<?= $row['productThumbnail'] ?>" alt=""-->
                        <!--    style="width: 100%; height: 400px; object-fit: cover;">-->
                        
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
                                
                                
                                <!--<h4><small>Total:</small> <strong>&#8369;</strong><strong-->
                                <!--        id="productTotal"><?= $row['productPrice'] ?></strong>-->
                                <!--</h4>-->
                                
                                <!--REVISIONS NUMBER 1-->
                                <?php
                                if($row['productStatus'] == 'Available'){
                                        if(intval($row['productStock']) > 0){
                                            // if stock is available
                                          echo '<h4 class="mt-3" style="letter-spacing: .1rem;"><strong>&#8369;</strong><strong
                                        id="productPrice">'.$row['productPrice'].'</strong></h4>';
                                          }else{
                                              
                                              //if out of stock
                                            echo '<h4 class="mt-3" style="letter-spacing: .1rem;"><strong>&#8369;</strong><strong
                                        id="productPrice">'.$row['productPrice'].'</strong></h4>';
                                        }
                                    }
                                    
                                    //if item is unvailable
                                    if($row['productStatus'] == 'Unavailable'){
                                      echo '<h4 class="mt-3" style="letter-spacing: .1rem;"><strong
                                        id="productPrice"> Unavailable </strong></h4>';
                                    }
                                    
                                    ?>
                                
                                <small class="text-dark">Quantity</small>
                                <div class="d-flex flex-row gap-2 qty-container mb-4" style="width: 50%;">
                                    
                                     <!--REVISIONS NUNMBER 1-->
                                
                                 <?php
                                if($row['productStatus'] == 'Available'){
                                        if(intval($row['productStock']) > 0){
                                            // if stock is available
                                         echo '<button style="padding: 7px 15px;" type="button"
                                                class="btn btn-primary prev qtyBtn customBtn">-</button>
                                                <input class="form-control number-spinner" type="number" name="qty" id="qty" value="1"
                                                min="1" readonly>
                                                <button style="padding: 7px 15px;" type="button"
                                                class="btn btn-primary next qtyBtn customBtn">+</button>';
                                          }else{
                                              
                                              //if out of stock
                                           echo '<button disabled style="padding: 7px 15px;" type="button"
                                                class="btn btn-primary prev qtyBtn customBtn">-</button>
                                                <input class="form-control number-spinner" type="number" name="qty" id="qty" value="0"
                                                min="1" readonly>
                                                <button disabled style="padding: 7px 15px;" type="button"
                                                class="btn btn-primary next qtyBtn customBtn">+</button>';
                                        }
                                    }
                                    
                                    //if item is unvailable
                                    if($row['productStatus'] == 'Unavailable'){
                                      echo '<button disabled style="padding: 7px 15px;" type="button"
                                                class="btn btn-primary prev qtyBtn customBtn">-</button>
                                                <input class="form-control number-spinner" type="number" name="qty" id="qty" value="0"
                                                min="1" readonly>
                                                <button disabled style="padding: 7px 15px;" type="button"
                                                class="btn btn-primary next qtyBtn customBtn">+</button>';
                                    }
                                    
                                    ?>
                                    
                                   
                                </div>
                                
                                <!--REVISIONS NUMBER 1-->
                                <?php
                                if($row['productStatus'] == 'Available'){
                                        if(intval($row['productStock']) > 0){
                                            // if stock is available
                                          echo '<button type="submit" class="btn btn-primary mt-sm-0 mt-2 customBtn" id="addToCartBtn" style="letter-spacing: .1rem;">Add to cart</button>';
                                          }else{
                                              
                                              //if out of stock
                                            echo '<button type="submit" disabled class="btn btn-primary mt-sm-0 mt-2 customBtn" id="addToCartBtn" style="letter-spacing: .1rem;">Out of stock</button>';
                                        }
                                    }
                                    
                                    //if item is unvailable
                                    if($row['productStatus'] == 'Unavailable'){
                                      echo '<button type="submit" disabled class="btn btn-primary mt-sm-0 mt-2 customBtn" id="addToCartBtn" style="letter-spacing: .1rem;">Unavailable</button>';
                                    }
                                    
                                    ?>
                                    
                                
                                
                                <h4 class="text-dark mt-3"><small>Sub-total:</small> <strong>&#8369;</strong>
                                
                                <!--REVISIONS NUNMBER 1-->
                                
                                 <?php
                                if($row['productStatus'] == 'Available'){
                                        if(intval($row['productStock']) > 0){
                                            // if stock is available
                                          echo '<strong id="productTotal">'.$row['productPrice'].'</strong>';
                                          }else{
                                              
                                              //if out of stock
                                            echo '<strong id="productTotal">0.00</strong>';
                                        }
                                    }
                                    
                                    //if item is unvailable
                                    if($row['productStatus'] == 'Unavailable'){
                                      echo '<strong id="productTotal">0.00</strong>';
                                    }
                                    
                                    ?>
                                
                                <h6 class="mt-4">
                                    <!--REVISIONS NUMBER 1-->
                                    
                                    <?php
                                    
                                    if($row['productStatus'] == 'Available'){
                                        if(intval($row['productStock']) > 0){
                                            
                                            // if stock is available
                                          echo '<small>Item stock: </small>'.$row['productionStock'];
                                          }else{
                                              
                                              //if out of stock
                                            echo '<small>Out of stock</small>';
                                        }
                                    }
                                    
                                    //if item is unvailable
                                    if($row['productStatus'] == 'Unavailable'){
                                      echo '<small>Item is unavailable</small>';
                                    }
                                    
                                    ?>
                                    
                                </h6>
                                <h5 class="text-start" style="letter-spacing: .1rem;"><?= ucfirst($row['productDesc']); ?></h5>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row mt-3">-->
                    <!--    <div class="d-flex flex-column flex-sm-row justify-content-between">-->
                    <!--        <div class="d-flex flex-row gap-2 qty-container">-->
                    <!--            <button style="padding: 7px 15px;" type="button"-->
                    <!--                class="btn btn-primary prev qtyBtn customBtn">-</button>-->
                    <!--            <input class="form-control number-spinner" type="number" name="qty" id="qty" value="1"-->
                    <!--                min="1" readonly>-->
                    <!--            <button style="padding: 7px 15px;" type="button"-->
                    <!--                class="btn btn-primary next qtyBtn customBtn">+</button>-->
                    <!--        </div>-->
                    <!--        <button type="submit" class="btn btn-primary mt-sm-0 mt-2 customBtn" id="addToCartBtn" style="letter-spacing: .1rem;">Add-->
                    <!--            to-->
                    <!--            cart</button>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>
        </form>
    </div>
</div>
<?php
}
?>

<!-- <div class="bottom p-2" style="background: #fe827a; height: auto;">
    <div class="container">
        <div class="row justify-content-between align-items-center p-2">
            <div class="col-lg-12">
                <div class="d-flex flex-column flex-sm-row justify-content-between">
                    <div class="d-flex flex-row gap-2 qty-container">
                        <button style="padding: 7px 15px;" type="button"
                            class="btn btn-primary prev qtyBtn customBtn">-</button>
                        <input class="form-control number-spinner" type="number" name="qty" id="qty" value="1" min="1"
                            readonly>
                        <button style="padding: 7px 15px;" type="button"
                            class="btn btn-primary next qtyBtn customBtn">+</button>
                    </div>
                    <button type="submit" class="btn btn-primary mt-sm-0 mt-2 customBtn" id="addToCartBtn">Add to
                        Cart</button>
                </div>
            </div>

        </div>
    </div>
</div> -->

<script>
$(window).on('load', function() {
    if(localStorage.getItem('status') == 'added') {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Product successfully added to cart!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            color: '#000',
            background: '#fe827a',
        })
        localStorage.removeItem('status');
    }
})
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
    $('#addToCartForm').on('submit', function(e) {
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
            var get_form = $('#addToCartForm')[0];
            var form = new FormData(get_form);
            form.append('productId', $('#productId').text());
            form.append('categoryId', $('#categoryId').text());
            form.append('productPrice', $('#productPrice').text());
            form.append('productTotal', $('#productTotal').text());
            form.append('addToCart', true);

            $.ajax({
                type: "POST",
                url: "./backend/add-to-cart.php",
                data: form,
                dataType: 'text',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#addToCartBtn').prop('disabled', true);
                    $('#addToCartBtn').text('Processing...');
                },
                complete: function() {
                    $('#addToCartBtn').prop('disabled', false);
                    $('#addToCartBtn').text('Add to Cart');
                },
                success: function(response) {
                    if (response.includes('success')) {
                        localStorage.setItem('status', 'added');
                        location.reload();
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