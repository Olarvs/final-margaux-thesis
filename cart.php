<?php
include './components/head_css.php';
include   './components/navbar.php';

if(!isset($_SESSION['margaux_user_id'])) {
    $_SESSION["margaux_link_user"] = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>
    <script>
        location.href = 'login.php';
    </script>
    <?php
} else {
    if(isset($_SESSION['cartId'])) {
        unset($_SESSION['cartId']);
    }
    $userId = $_SESSION['margaux_user_id'];
}
?>

<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
body {
    background: url(./assets/images/bgpink.png) no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    height: 100%;
}
.c_btn_trash {
    background-color: #000 !important;
    border-color: #000 !important;
}

.c_btn_trash:hover {
    background-color: #1b1b1b !important;
    border-color: #1b1b1b !important;
}

.c_btn_qty {
    background-color: #fe827a !important;
    border-color: #fe827a !important;
}

.c_btn_qty:hover {
    background-color: #1b1b1b !important;
    border-color: #1b1b1b !important;
}

.c_btn_qty_add {
    background-color: #fe827a !important;
    border-color: #fe827a !important;
}

.c_btn_qty_add:hover {
    background-color: #1b1b1b !important;
    border-color: #1b1b1b !important;
}

/*PARA SA LOADING SCREEN*/
#loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 9999;
  display: none;
}

.loading-icon {
  position: absolute;
  top: 45%;
  left: 45%;
  transform: translate(-50%, -50%);
  width: 100px;
  height: 100px;
  border: 8px solid #fe827a;
  border-top: 8px solid #000;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
/*END NG LOADING SCREEN*/
</style>

<!--LOADING-->

<div id="loading-screen">
     <div class="loading-icon">
    </div>
</div>
<!--END LOADING-->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateQtyForm">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>

<section class="h-100 gradient-custom">
    <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h4 class="mb-0" style="letter-spacing: .1rem;">Your cart</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        $getCart = mysqli_query($conn, "SELECT tbl_product.productThumbnail, tbl_product.productName, tbl_cart.productPrice, tbl_cart.productTotal, tbl_cart.productQty, tbl_cart.productId, tbl_cart.userId, tbl_category.categoryName, tbl_cart.cartId
                        FROM tbl_cart
                        LEFT JOIN tbl_product
                        ON tbl_product.productId = tbl_cart.productId
                        LEFT JOIN tbl_category
                        ON tbl_cart.categoryId = tbl_category.categoryId
                        WHERE tbl_cart.userId = $userId AND (tbl_product.isDeleted = 0 AND tbl_category.isDeleted = 0)");

                        $status = 0;

                        if(mysqli_num_rows($getCart) <= 0) {
                        $status = 0;
                        ?>
                        <h6 class="text-center" style="letter-spacing: .1rem;">No items in cart</h6>
                        <?php
                        } else {
                        $status = 1;
                            foreach($getCart as $row) {
                            ?>
                        <!-- Single item -->
                        <div class="row">
                            <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                <!-- Image -->
                                <div class="bg-image hover-overlay hover-zoom ripple rounded"
                                    data-mdb-ripple-color="light">
                                    <img src="./admin/assets/images//productImages/<?= $row['productThumbnail'] ?>"
                                        class="w-100" alt="" />
                                    <a href="#!">
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                    </a>
                                </div>
                                <!-- Image -->
                            </div>

                            <div class="col-lg-5 col-md-6 mb-4 mb-lg-0 mt-4">
                                <!-- Data -->
                                <p style="letter-spacing: .1rem;"><strong><?= $row['productName'] ?></strong><br><span
                                        class="text-danger"><?= $row['categoryName'] ?></span>
                                </p>
                                
                                <!--REVISIONS NUMBER 3-->
                                <!--Replace the trash/delete icon in the-->
                                <!--delete function with the "remove"-->
                                <!--button in the cart page.-->
                                
                                <!-- In short, just replace logo with remove text in the button -->
                                
                                <!--After revisions-->
                                
                                <!--<i class="fa-solid fa-trash-can fa-fw removeItem" data-id="<?= $row['cartId'] ?>"  title="Remove item" style="cursor: pointer;">Remove</i>-->
                                <button type="button" class="btn btn-danger mt-1 me-1 mb-2 removeItem"
                                    data-id="<?= $row['cartId'] ?>">
                                    <!--<i class="fa-solid fa-trash-can fa-fw"></i>-->
                                    Remove
                                </button>
                                
                                <!--Before revisions-->
                                
                                <!-- Data -->
                            </div>

                            <div class="col-lg-4 col-md-6 mb-lg-0 text-start text-md-end">

                                <!-- Price -->
                                <!--<p id= "productId" value ="<?= $row['productId'] ?>" ><?= $row['productId'] ?></p>-->
                                <p class="text-start text-md-end" style="letter-spacing: .1rem;">
                                    Quantity: <strong
                                        data-price="<?= $row['productQty'] ?>"><?= $row['productQty'] ?></strong>
                                        <br>
                                    Price: <strong
                                        data-price="<?= $row['productPrice'] ?>"><?= $row['productPrice'] ?></strong><br>
                                    Item Subtotal: <strong data-subtotal="<?= $row['productTotal'] ?>"
                                        class="subTotal"><?= $row['productTotal'] ?></strong>
                                </p>
                                <!-- Price -->
                                <div class="d-flex mt-2 w-50">
                                    <button style="padding: 7px 15px;" type="button"
                                    class="btn btn-outline-danger prev qtyBtn customBtn me-1 border-danger" onClick ="decrementQuantity(<?= $row['productId'] ?>)"><i class="fa fa-minus"></i></button>
                                    <!--<input class="form-control number-spinner" name="qty" id="qty" -->
                                    <!--min="1"><?= $row['productQty'] ?></input>-->
                                    <input hidden value ="$row" id ="rowContent"/>
                                    <input class="d-inline text-center py-1 border-solid rounded" style="width:100px;" value ="<?= $row['productQty'] ?>"
                                     readOnly min ="1" id = "qtyProductValue"></input>
                                    <button style="padding: 7px 15px;" type="button" onClick ="incrementQuantity(<?= $row['productId'] ?>)"
                                    class="btn btn-outline-danger next qtyBtn customBtn ms-1 border-danger"><i class="fa fa-plus"></i></button>
                                </div>
                                
                                    
                                    
                                <!--REVISIONS NUMBER 2    -->
                                <!-- Replace the "update quantity" button -->
                                <!-- with "+" and "-" buttons for updating -->
                                <!-- quantity in the cart page. -->
                                
                                <!--In short replace Update quantity button with "+" and "-" quantity -->
                                <!--So that it will not require to go to another web page-->
                                
                                <!--Before Revisions-->
                                
                                <!--<button onclick="location.href='update-product.php?cartId=<?= $row['cartId'] ?>'"-->
                                <!--    type="button" class="btn btn-primary btn-sm me-1 mb-2 updateQty"-->
                                <!--    data-id="<?= $row['cartId'] ?>" style="letter-spacing: .1rem;">Update Quantity-->
                                <!--</button>-->
                                .
                                <!--End of Before Revisions-->
                                
                                <!--After Revisions-->
                                
                            <!--<div class="d-flex flex-column">-->
                              
                                <!--<small class="text-dark">Quantity</small>-->
                            <!--    <div class="d-flex flex-row gap-2 qty-container" style="width: 50%;">-->
                            <!--        <button style="padding: 7px 15px;" type="button"-->
                            <!--        class="btn btn-primary prev qtyBtn customBtn" onClick ="decrementQuantity(<?= $row['productId'] ?>)">-</button>-->
                                    <!--<input class="form-control number-spinner" name="qty" id="qty" -->
                                    <!--min="1"><?= $row['productQty'] ?></input>-->
                            <!--        <input hidden value ="$row" id ="rowContent"/>-->
                            <!--        <input style ="border-color:#fda4af; width:100px;" value ="<?= $row['productQty'] ?>"-->
                            <!--         readOnly min ="1" id = "qtyProductValue"></input>-->
                            <!--        <button style="padding: 7px 15px;" type="button" onClick ="incrementQuantity(<?= $row['productId'] ?>)"-->
                            <!--        class="btn btn-primary next qtyBtn customBtn">+</button>-->
                            <!--    </div>-->
                                <!--<button type="submit" class="btn btn-primary mt-sm-0 mt-2 customBtn" id="updateToCartBtn" style="letter-spacing: .1rem;">Update cart</button>-->
                            <!--</div>-->
                            
                                <script>
                                
                                //Sample fetch
                                
                                //Get all active course
                                
                                // const getAllActiveCourse = async () =>{
                                //     try{
                                //         const sendRequest = await fetch('../backend/all-course-active.php');
                                
                                //         const Response = await sendRequest.json();
                                //         let Output = '';
                                
                                //         Output += ``+Response.length+``;
                                //         document.querySelector('#countCourse').innerHTML = Output;
                                //     }catch(e){
                                //         console.error(e);
                                //     }
                                // }
                                
                                
                            //     const saveChanges = async (...params) =>{
                            //     let btnChangePic = document.getElementById('btnChangePic');
                            //         Create a FormData object.
                            //     imageformData = new FormData();
                               
                            //     imageformData.append('userId', params[0]);
                            //     imageformData.append('Image_Url', params[1]);
                            //     let message = '';
                            //     try{
                            //       const fetchResponse = await fetch("../controller/user-edit-pic.php",{
                            //           method: "POST",
                            //           body:imageformData,
                            //       });
                            //       const receivedStatus = await fetchResponse.json();
                            //       console.log(receivedStatus)
                            //       if(receivedStatus.statusCode === 200){
                            //          alertShowSuccess.removeAttribute("hidden");
                            //          btnChangePic.setAttribute("disabled", "disabled");
                            //           alertShowSuccess.classList.add('show');
                            //           message += ` Updated Succesfully!`
                                     
                            //         delayedRemoveAlert = () =>{   
                            //             alertShowSuccess.classList.remove('show');  
                            //             alertShowSuccess.setAttribute("hidden", "hidden");
                            //         }
                            //         setTimeout(delayedRemoveAlert, 3000);
                            //       }
                            //       document.querySelector('#alertSuccessMessage').innerHTML = message;
                            //     }catch(e){
                            //       console.log(e);
                            //     }
                            //   }
                            
                                //form.append('productId', $('#productId').text());
                                // form.append('categoryId', $('#categoryId').text());
                                // form.append('productPrice', $('#productPrice').text());
                                // form.append('productTotal', $('#productTotal').text());
                                // form.append('updateToCart', true);
                                
                                const updateQuantity = async (...params) =>{
                                    // Create a FormData object.
                                // imageformData = new FormData();
                               
                                // imageformData.append('userId', params[0]);
                                // imageformData.append('Image_Url', params[1]);
                                // let message = '';
                                let formData = new FormData();
                                formData.append('productId', params[1]);
                                formData.append('categoryId', $('#categoryId').text());
                                formData.append('productPrice', $('#productPrice').text());
                                formData.append('productTotal', $('#productTotal').text());
                                formData.append('updateToCart', params[0]);
                                formData.append('UpdateAction', params[0]);
                                try{
                                  const fetchResponse = await fetch("./backend/update-cart.php",{
                                      method: "POST",
                                      body:formData,
                                  });
                                  const getResponse = await fetchResponse.json();
                                  console.log(getResponse)
                                  if(getResponse.statusCode === 'success'){
                                    location.reload()
                                  }
                                  
                                }catch(e){
                                  console.log(e);
                                }
                              }
                                                                
                                let quantityValueCart3 = document.getElementById('qtyProductValue').value;
                                
                                    const decrementQuantity = (id) =>{
                                        if(parseFloat(quantityValueCart3) >1){
                                            quantityValueCart3 = parseFloat(quantityValueCart3)  - parseFloat(1);
                                        document.getElementById('qtyProductValue').value = quantityValueCart3;
                                        console.log(quantityValueCart3)
                                        updateQuantity('Decrement',id)
                                        }else{
                                        //quantity must not be below 1
                                        }
                                        
                                       
                                        document.getElementById("loading-screen").style.display = "none";
                                        document.getElementById("loading-screen").style.display = "block";
                                    }
                                    
                                    const incrementQuantity = (id) =>{
                                        // quantityValueCart3 = parseFloat(quantityValueCart3)  + parseFloat(1);
                                        // document.getElementById('qtyProductValue').value = quantityValueCart3;
                                        // console.log(quantityValueCart3)
                                        updateQuantity('Increment',id)
                                    
                                        document.getElementById("loading-screen").style.display = "none";
                                        document.getElementById("loading-screen").style.display = "block";
                                    }
                                </script>
                                
                                <!--End of after revisions-->
                                
                                
                            </div>
                        </div>
                        <!-- Single item -->

                        <hr class="my-4" />
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h4 class="mb-0" style="letter-spacing: .1rem;">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                           
                             <?php 
                                    foreach($getCart as $row){
                                        echo ' 
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                            
                                        <div>
                                                 <strong style="letter-spacing: .1rem;">'.$row['productName'].'</strong>
                                               </div>
                                            <span style="letter-spacing: .1rem;">₱<strong>'.$row['productTotal'].'</strong></span>
                                            </li>';
                                    }
                                ?>
                                <hr>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                               
                                <div>
                                    
                                    <strong style="letter-spacing: .1rem;">Subtotal:</strong>
                                </div>
                                <span style="letter-spacing: .1rem;">₱<strong class="totalAmount">0.00</strong></span>
                            </li>
                        </ul>

                        <?php
                        if($status != 0) {
                        ?>
                        <button type="button" onclick="location.href='checkout.php'" class="btn btn-primary btn-sm btn-block c_btn_qty" style="letter-spacing: .1rem;">
                            Check out
                        </button>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(window).on('load', function() {
    // ALERTS
    if (localStorage.getItem('status') == 'updated') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Item updated successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            color: '#000',
            background: '#fe827a',
        })
        localStorage.removeItem('status');
    } else if (localStorage.getItem('status') == 'deleted') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Item deleted successfully!',
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

    var gdtotal = 0;
    $('.subTotal').each(function() {
        var subtotal = parseFloat($(this).text());
        gdtotal += subtotal;
    })
    $('.totalAmount').text(gdtotal.toFixed(2));
})

$(document).ready(function() {
    $('.removeItem').on('click', function(e) {
        e.preventDefault();

        var cartId = $(this).data('id');


        Swal.fire({
            icon: 'question',
            title: 'Hey!',
            text: 'Are you sure, you want to remove this item?!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: true,
            showDenyButton: true,
            denyButtonText: `Cancel`,
            confirmButtonText: 'Yes',
            color: '#000',
            background: '#fe827a',
        }).then((result) => {
            if (result.isConfirmed) {
                var form = new FormData();
                form.append('deleteItem', true);
                form.append('cartId', cartId);

                $.ajax({
                    type: "POST",
                    url: "./backend/add-to-cart.php",
                    data: form,
                    dataType: 'text',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.includes('success')) {
                            localStorage.setItem('status', 'deleted');
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
})

</script>

<?php
include './components/footer.php';
include './components/bottom-script.php';
?>