<?php
include './components/head_css.php';
include './components/navbar.php';

if(!isset($_SESSION['margaux_user_id'])) {
    $_SESSION["margaux_link_user"] = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    header('location: login.php');
} else {
    $userId = $_SESSION['margaux_user_id'];
}
?>

<?php
$getUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user WHERE user_id = $userId");

$voucher = mysqli_query($conn, "SELECT * FROM tbl_voucher WHERE status = 'active'");

//gloabal state
$DeliveryMethod = 'PickUp';

foreach($getUserInfo as $userInfo) {
?>
<div class="container my-5">
    <main>
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 order-md-last">
                <?php
                $getCart = mysqli_query($conn, "SELECT tbl_product.productName, tbl_category.categoryName, tbl_cart.productQty, tbl_cart.productTotal
                FROM tbl_cart
                LEFT JOIN tbl_product
                ON tbl_cart.productId = tbl_product.productId
                LEFT JOIN tbl_category
                ON tbl_cart.categoryId = tbl_category.categoryId
                WHERE tbl_cart.userId = $userId");
                ?>
                <div class="card p-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary" style="letter-spacing: .1rem;">Order Summary</span>
                    </h4>
                    
                  
                     
                    <ul class="list-group mb-3">
                        <?php
                         $finalTotal = 0.00;
                         $totalDiscount = 0.00;
                         $finalSubtotal = 0.00;
                         $shippingFee = 00.00;//default price within ncr and calabarzon
                        foreach($getCart as $row) {
                           $shippingFee = $row['shippingFee']; 
                       echo  '<li class="list-group-item d-flex justify-content-between lh-sm">';
                            
                               
                                 
                                 if(floatval($row['productQty']) < 10){
                            
                                    echo '<div>
                                            <h6 class="my-0" style="letter-spacing: .1rem;">'.$row['productName'].'</h6>
                                                <small class="text-muted">x'.$row['productQty'].'</small>
                                          </div>';
                                          
                                }
                                //discounted 
                                if(floatval($row['productQty']) >= 10){
                                  
                                    echo '<div>
                                            <h6 class="my-0" style="letter-spacing: .1rem;">'.$row['productName'].'</h6>
                                                <small class="text-muted">x'.$row['productQty'].'</small>
                                                <small class="text-muted">(10% item discount)</small>
                                          </div>';
                                }
                                
                              
                             
                           
                           
                             if(floatval($row['productQty']) < 10){
                                   $finalTotal = floatval($finalTotal) + floatval($row['productTotal']); 
                                    echo ' <span class="text-muted"><strong>&#8369;</strong> <strong
                                    class="price" >'.$row['productTotal'].'</strong> ';
                                }
                                //discounted 
                                if(floatval($row['productQty']) >= 10){
                                    
                                    $discount = floatval($row['productTotal']) / 10;
                                    $discountedPrice = floatval($row['productTotal']) - floatval($discount);
        
                                    $finalTotal = floatval($finalTotal) + floatval($discountedPrice); 
                                    $totalDiscount = floatval($totalDiscount) + floatval($discount);
                                     echo '<span class="text-muted"><strong>&#8369;</strong> <strong
                                    class="price text-end">'.$row['productTotal'].'</strong><br><strong class="float-end text-decoration-line-through" style ="color: red;">&#8369; '.$discount.'.00</strong></span>';
                                }
                        
                         
                           
                       echo '</li>';
                       
                       echo '<li class="list-group-item d-flex justify-content-between lh-sm" style ="border-bottom:none;">
                       </li>';
                       
                       $finalSubTotal = floatval($finalSubTotal) + floatval($row['productTotal']);
                    
                        }
                        
                           $finalTotal = floatval($finalTotal) + floatval($shippingFee);
                        
                          echo '<li class="list-group-item d-flex justify-content-between lh-sm" style ="border-bottom:none;">
                                <span>Subtotal</span> <strong
                                    class="price subTotal" >&#8369; '.number_format(floatval($finalSubTotal), 2, '.', '').'</strong> 
                             </li>';
                             
                            
                  if($DeliveryMethod == 'PickUp'){
                      //$shippingFee = 0.00;//
                       echo '<li class="list-group-item d-flex justify-content-between lh-sm" style ="border-bottom:none;">
                                <div>
                                    <span>Shipping Fee</span>
                                </div>
                                <div>
                                    <strong>&#8369;</strong>
                                    <strong class="price shipping_fee" id="shipping_fee">'.number_format(floatval($shippingFee), 2, '.', '').'</strong>
                                </div> 
                             </li>';
                  }
                  if($DeliveryMethod == 'Ship'){
                      $shippingFee = $row['shippingFee'];
                       echo '<li class="list-group-item d-flex justify-content-between lh-sm" style ="border-bottom:none;">
                                <div>
                                    <span>Shipping Fee</span>
                                </div>
                                <div>
                                    <strong>&#8369;</strong>
                                    <strong class="price shipping_fee" id="shipping_fee">'.number_format(floatval($shippingFee), 2, '.', '').'</strong>
                                </div>
                             </li>';
                  }
                        echo '<li class="list-group-item d-flex justify-content-between lh-sm" style ="border-bottom:none;" id ="voucherTotalDiscount" hidden>
                                <span>Voucher Discount</span><strong
                                    class="price" style ="color: red;">-&#8369; '.number_format(floatval($totalDiscount), 2, '.', '').'</strong> 
                             </li>';
                  
                  
                          echo '<li class="list-group-item d-flex justify-content-between lh-sm" style ="border-bottom:none;">
                                <span>Discount Total</span><strong
                                    class="price" style ="color: red;">-&#8369; '.number_format(floatval($totalDiscount), 2, '.', '').'</strong> 
                             </li>';
                        
                        
                             
                         echo '<li class="list-group-item d-flex justify-content-between">
                            <div>
                                 <span><strong>Total</strong></span>
                            </div>
                            <div>
                            <input hidden value ="'.number_format(floatval($finalTotal), 2, '.', '').'" id ="hiddenTotalPrice" />
                                <strong style="font-size: 21px;">&#8369;</strong> <strong style="font-size: 21px;" class="totalPrice" id ="totalPrice">'.number_format(floatval($finalTotal), 2, '.', '').'</strong>
                            </div>
                        </li>';
                          ?>
    
                    
                        
                        
                    </ul>
                    
                      <!--VOUCHER LIST-->
                    <link
                      rel="stylesheet"
                      href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
                    />

                    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
                   
                     <style>
                    .swiper {
                      width: 480px;
                      height: 150px;
                      margin-bottom: 1rem;
                    }
                    .coupon {
                        height:150px;
                        background-color: #f4f4f4;
                        border: 1px solid #ccc;
                        border-radius:10px;
                        padding: 10px;
                        margin-bottom: 20px;
                    }
                    
                    .coupon .container {
                        display: flex;
                        justify-content: space-between;
                    }
                    
                    .coupon .discount {
                        font-size: 25px;
                        font-weight: bold;
                        color: #0088cc;
                    }
                    
                    .coupon .code {
                        margin-left: 10px;
                        margin-right: 10px;
                        font-size: 24px;
                        font-weight: bold;
                        color: #333;
                    }
                    
                    .coupon .expiration {
                        font-size: 10px;
                        color: #777;
                        margin-top: 5px;
                    }
             
                    .swiper-button-prev{
                        color: #777;
                    }
                    .swiper-button-next{
                        color: #777;
                    }
                    
                </style>
                   
                   <!-- Slider main container -->
                  
                            <!--<div class="swiper">-->
                              <!-- Additional required wrapper -->
                              <!--<div class="swiper-wrapper">-->
                                <!-- Slides -->
                                
                                <?php 
                                foreach($voucher as $voucherList) {
                                
                                // echo '<div class="swiper-slide">
                                //  <div class="coupon">
                                //   <div class="container">
                                //     <div class="discount">&#8369;'.$voucherList['discount'].'</div>
                                //     <div class="code"><strong>Voucher Code:</strong>'.$voucherList['voucher_code'].'</div>
                                //     <div class="expiration">Valid until: '.$voucherList['expiration_date'].'</div>
                                //   </div>
                                //  </div>
                                // </div>';
                                    
                                }
                                ?>
                                
                                
                              <!--</div>-->
                              <!-- If we need pagination -->
                              <!--<div class="swiper-pagination"></div>-->
                            
                              <!-- If we need navigation buttons -->
                              <!--<div class="swiper-button-prev"></div>-->
                              <!--<div class="swiper-button-next"></div>-->
                            
                              <!-- If we need scrollbar -->
                              <!--<div class="swiper-scrollbar"></div>-->
                            <!--</div>-->
                    
              
                    
                    <script defer>
                        const swiper = new Swiper('.swiper', {
                          // Optional parameters
                          direction: 'horizontal',
                          loop: true,
                        
                          // If we need pagination
                        //   pagination: {
                        //     el: '.swiper-pagination',
                        //   },
                        
                          // Navigation arrows
                          navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                          },
                        
                          // And if we need scrollbar
                        //   scrollbar: {
                        //     el: '.swiper-scrollbar',
                        //   },
                        });
                    </script>
                     <!--END OF VOUCHER LIST-->
                    
                    <!--<form id ="frmVoucherApply">-->
                    <!--<div class="row g-3">-->
                    <!--   <div class="col-sm-6">-->
                                
                    <!--            <input type="text" class="form-control" placeholder="Enter Voucher Code"-->
                    <!--                 id="voucherCode" name="voucherCode" />-->
                    <!--            <span class="error error_Voucher"-->
                    <!--                style="font-size: 12px; font-weight: 500; color: #fe827a;" id ="ErrorVoucherNote"></span>-->
                    <!--        </div>-->
                    <!--         <div class="col-sm-6">-->
                    <!--              <button class="btn btn-primary btn-sm" type="submit" id="btnVouhcerApply" >Apply voucher</button>-->
                    <!--    </div>-->
                     
                    <!--</div>-->
                    <!-- </form>-->
                    
                    
                    <script defer>
                        const form = document.getElementById("frmVoucherApply");
                        const voucherInput = document.getElementById("voucherCode");
                        const voucherInputErrorText = document.getElementById("ErrorVoucherNote");
                        const hiddenTotalPrice = document.getElementById("hiddenTotalPrice");
                        const totalPrice = document.getElementById("totalPrice");
                        
                        
                        const myInput = document.querySelector('#voucherCode');
                        const voucherInputListener = () => {
                              voucherInput.classList.remove("border-danger");
                              voucherInputErrorText.innerHTML = "";
                        }
                        myInput.addEventListener('input', voucherInputListener);
                        
                        //submit voucher code
                        form.addEventListener("submit", async (event) =>{
                           event.preventDefault();
                            voucherInput.classList.remove("border-danger");
                            voucherInputErrorText.innerHTML = "";
                       
                        //   print value of form
                             for (const control of form.elements) {
                                  console.log(control.name + " : " + control.value);
                                 }
                           try{
                                const response = await fetch("https://margaux-corner.online/backend/apply-voucher.php", {
                                  method: "POST",
                                  body: new FormData(form),
                                });
                                const getResponse = await response.json();
                                console.log(getResponse);
                                if(getResponse.statusCode === 'success' && getResponse.isExist === true){
                                
                                let finalPrice = 0.00;
                                finalPrice = parseFloat(hiddenTotalPrice.value) - parseFloat(getResponse.discount);
                                console.log(finalPrice);
                                console.log(totalPrice.value);
                                totalPrice.innerHTML = finalPrice.toFixed(2);
                                }
                                
                                if(getResponse.statusCode ==='success' && getResponse.isExist === false){
                                    voucherInput.classList.add("border-danger");
                                    voucherInputErrorText.innerHTML = "Voucher code doesn't exist!";
                                }
                           }catch(error){
                               console.error(error);
                           }
                        });
                        
                    </script>
                     <?php 
                     //list of vouchers
                      //      foreach($voucher as $coupon){
                       //      echo '<p>'.$coupon['voucher_code'].'</p>';
                       //   }
                     ?>
                     
                </div>
            </div>
            
            <?php
            $getInfo = mysqli_query($conn, "SELECT * FROM tbl_user WHERE user_id = $userId");

            foreach($getInfo as $row) {
            ?>
            <div class="col-md-6 col-lg-6">
                <div class="card p-4">
                    <h4 class="mb-3" style="letter-spacing: .1rem;">Checkout</h4>
                    <form id="checkoutForm">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="fullName" class="form-label" style="letter-spacing: .1rem;">Fullname</label>
                                <input type="text" class="form-control" id="fullName" placeholder=""
                                    value="<?= $userInfo['name'] ?>" id="fullName" name="fullName" required>
                                <span class="error error_fullName"
                                    style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label" style="letter-spacing: .1rem;">Contact Number</label>
                                <div class="input-group mb-3">
                                    <span style="font-size: 14px;" class="input-group-text" id="basic-addon1">+63</span>
                                    <input type="text" class="form-control" placeholder="9912937615" id="contactNumber"
                                        name="contactNumber" value="<?= $userInfo['mobile_no'] ?>" required>
                                </div>
                                <span class="error error_contactNumber"
                                    style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                            </div>

                            <!-- <div class="col-12">
                                <label for="email" class="form-label">Email <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="email" class="form-control" id="email" placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div> -->




                        </div>

                        <hr class="my-4">

                        <div class="row g-3 mb-3">
                            <div class="col-sm-12">
                                <label for="lastName" class="form-label" style="letter-spacing: .1rem;">Choose Delivery Method</label>
                                <select class="form-select form-control" id="deliveryMethod" onChange ={getSelectedDeliveryMethod(this.value)}  name="deliveryMethod">
                                    <option value="PICK UP">Pick up</option>
                                    <option value="DELIVERY">Delivery</option>
                                </select>
                                <script>
                                    const getSelectedDeliveryMethod = (...params) =>{
                                        console.log(params[0])
                                    }
                                </script>
                            </div>
                            <div class="col-sm-12 d-none" id="courierContainer">
                                <label for="courier" class="form-label" style="letter-spacing: .1rem;">Courier</label>
                                <!--Niremove ko sa select tag para walang dropdown
                                class="form-select"-->
                                <select class="form-control" id="preferredCourier"  name="preferredCourier" style="background-color: white;">
                                    <option value="LALAMOVE">LALAMOVE</option>
                                    
                                    <!--DONE-->
                                    <!--REVISION NUMBER 7-->
                                    <!--Remove LBC Express from the-->
                                    <!--delivery method's courier option.-->
                                    
                                    <!--After revisions-->
                                    
                                    <!--<option value="LBC EXPRESS">LBC EXPRESS</option>-->
                                    
                                    <!--After revisions-->
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6  d-none" id="lbcModeContainer">
                                <label for="lastName" class="form-label" style="letter-spacing: .1rem;">Choose LBC Mode</label>
                                <select class="form-select form-control" id="lbcMode" name="lbcMode">
                                    <option value="PICK UP">PICK UP</option>
                                    <option value="DOOR-TO-DOOR">DOOR-TO-DOOR</option>
                                </select>
                            </div>
                            <div class="col-sm-6  d-none" id="lbcBranchContainer">
                                <label for="lastName" class="form-label" style="letter-spacing: .1rem;">Nearest LBC Branch</label>
                                <input type="text" class="form-control" id="lastName" placeholder="" value=""
                                    id="lbcBranch" name="lbcBranch">
                            </div>
                        </div>
                            <!--<div class="col-sm-12">-->
                            <!--    <label style="letter-spacing: .1rem;">Pickup location</label>-->
                            <!--    <select class="form-control" disabled style="background-color: white;">-->
                            <!--        <option>Purok 1, Brgy. Sto Niño, 3100, Cabanatuan City, Nueva Ecija</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                        <div class="row g-3 mb-3" id="pickupDateTimeContainer">
                            <div class="col-sm-6">
                                <label style="letter-spacing: .1rem;">Date</label>
                                <input type="date" class="form-control" name="pickUpDate" id="pickUpDate" required>
                            </div>
                            
                            <div class="col-sm-6">
                                
                                <!--DONE-->
                                <!--REVISIONS NUMBER 4-->
                                <!--In the pickup method, replace the-->
                                <!--time picker with a drop-down list of-->
                                <!--possible pickup hours.-->
                                
                                <!--After Revisions-->
                                
                                <label style="letter-spacing: .1rem;">Time</label>
                                <input type="time" class="form-control" min="08:00" max ="17:00" name="pickUpTime" id="pickUpTime" required>
                                <span class="error error_Time" style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                
                                <!--End of after revisions-->
                                    
                            </div>
                        </div>

                        <div class="row g-3 mb-3 d-none" id="addressContainer">
                            <div class="col-sm-4">
                                <label for="province" class="form-label" style="letter-spacing: .1rem;">Province</label>
                                <select class="form-select form-control" id="province" name="province">
                                </select>
                                <input class="form-control" type="hidden" name="provinceValue" id="provinceValue"
                                    value="<?= $userInfo['province'] ?>">
                            </div>
                            <div class="col-sm-4">
                                <label for="city" class="form-label" style="letter-spacing: .1rem;">City</label>
                                <select class="form-select form-control" id="city" name="city">
                                </select>
                                <input class="form-control" type="hidden" name="cityValue" id="cityValue"
                                    value="<?= $userInfo['city'] ?>">
                            </div>
                            <div class="col-sm-4">
                                <label for="barangay" class="form-label" style="letter-spacing: .1rem;">Barangay</label>
                                <select class="form-select form-control" id="barangay" name="barangay">
                                </select>
                                <input class="form-control" type="hidden" name="barangayValue" id="barangayValue"
                                    value="<?= $userInfo['barangay'] ?>">
                            </div>

                            <div class="col-12">
                                <label for="" style="letter-spacing: .1rem;">Blk/Lot/Street/Floor No.</label>
                                <textarea style="resize: none;" class="form-control" id="block" name="block"
                                    rows="3"><?= $userInfo['block'] ?></textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row g-3 mb-3">
                            <div class="col-sm-12">
                                <label for="lastName" class="form-label" style="letter-spacing: .1rem;">Choose Payment Method</label>
                                <select class="form-select form-control" id="paymentMethod" name="paymentMethod">
                                    <option value="CASH ON DELIVERY/PICKUP">Cash on Delivery / Pick up</option>
                                    <option value="GCASH">GCash</option>
                                </select>
                            </div>
                            <div class="col-sm-6 d-none" id="gcashNumberContainer">
                                <label for="lastName" class="form-label" style="letter-spacing: .1rem;">GCash Number <small>(For refund purposes, if
                                        order gets cancelled.)</small></label>
                                <div class="input-group mb-3">
                                    <span style="font-size: 14px;" class="input-group-text" id="basic-addon1">+63</span>
                                    <input type="text" class="form-control" placeholder="9912937615" id="gcashNumber"
                                        name="gcashNumber" value="">
                                </div>
                                <span class="error error_gcashNumber"
                                    style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                            </div>
                        </div>

                        <!--REVISIONS 5-->
                        <!-- Add a bulk order option, as well as a -->
                        <!-- special discount or vouchers for bulk -->
                        <!-- orders. Pricing should be different -->
                        <!-- than for a single product purchase. -->
                        
                        <!--In short make a voucher page in admin panel where admin or staff can create a voucher-->
                        <!--Then customers can add a voucher to their  final payment to have a discount using the voucher code-->
                        
                        <div class="row g-3 mb-3 d-none" id="gcashContainer">
                            <div class="col-12 text-center">
                                <div class="d-flex flex-column gap-1 justify-content-center align-items-center">
                                    <label for="" style="letter-spacing: .1rem;">Scan to pay</label>
                                    <img style="width: 150px;" src="./admin/assets/images/gcash/gcashQr.png" alt="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" style="letter-spacing: .1rem;">Proof of Payment</label>
                                <input style="line-height: 37.5px;" type="file" name="proofOfPayment"
                                    id="proofOfPayment" class="form-control">
                                <span class="error error_proofOfPayment"
                                    style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                            </div>
                            <div class="col-sm-6">
                                <label for="" style="letter-spacing: .1rem;">Reference Number</label>
                                <input style="line-height: 37.5px;" type="tel" name="referenceNum" id="referenceNum"
                                    class="form-control">
                                <span class="error error_referenceNum"
                                    style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                            </div>
                        </div>
                        <hr>
                      

                        <!--            REVISION NUMBER 8           -->
                        <!--    Make a note to inform customers     -->
                        <!--    that they cannot cancel an order    -->
                        <!--    once it has been confirmed.         -->
                        <!--    In short, just add  a notice        -->
                        
                         
                            <p class="cancel-note" style ="font-weight: 500; color: #28282B; letter-spacing: .1rem;"><strong style="color: #fe827a;">Important Note:</strong> Once an order has been <strong>confirmed</strong>, it cannot be <strong>cancelled</strong>. Please double check your order before submitting.</p>
                    
                        
                        <button class="w-100 btn btn-primary btn-lg" type="submit" id="checkoutBtn" style="letter-spacing: .1rem;">Complete order</button>
                        
                    </form>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </main>
</div>
<?php
}
?>

<script>
$(window).on('load', function() {
    // GET TOTAL
    // var overall_total = 0;
    // $('.price').each(function() {
    //     var subtotal = parseFloat($(this).text());
    //     overall_total += subtotal;
    // })

    // $('.totalPrice').text(parseFloat(overall_total).toFixed(2));

    // GET ADDRESS
    var province_value = $('#provinceValue').val();
    var city_value = $('#cityValue').val();
    var barangay_value = $('#barangayValue').val();

    $.ajax({
        url: "./backend/get-address.php",
        type: "POST",
        data: {
            get_all_prov: true,
        },
        success: function(data) {
            $('#province').html(data);
            if (province_value == '' || province_value == null) {
                $('#city').attr('disabled', true);
                $('#barangay').attr('disabled', true);
                $('#block').attr('disabled', true);
                $('#province').val('');
            } else {
                $('#province').val(province_value);
                $('#city').attr('disabled', false);
            }
        }
    })

    if (province_value == '') {
        var data = '<option value="">Select Province First</option>';
        $('#city').html(data);
    } else {
        $.ajax({
            url: "./backend/get-address.php",
            type: "POST",
            data: {
                prov_db: province_value,
                get_all_city: true,
            },
            success: function(data) {
                $('#city').html(data);
                if (city_value == '' || city_value == null) {
                    $('#city').attr('disabled', false);
                    $('#barangay').attr('disabled', true);
                    $('#block').attr('disabled', true);
                    $('#city').val('');
                } else {
                    $('#city').val(city_value);
                }
            }
        })
    }

    if (city_value == '') {
        var data = '<option value="">Select Province First</option>';
        $('#barangay').html(data);
    } else {
        $.ajax({
            url: "./backend/get-address.php",
            type: "POST",
            data: {
                city_db: city_value,
                get_all_brgy: true,
            },
            success: function(data) {
                $('#barangay').html(data);
                if (barangay_value == '' || barangay_value == null) {
                    $('#city').attr('disabled', false);
                    $('#barangay').attr('disabled', false);
                    $('#block').attr('disabled', true);
                    $('#barangay').val('');
                } else {
                    $('#barangay').val(barangay_value);
                }
            }
        })
    }
})

$(document).ready(function() {
    // DATE VALIDATION
    $(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day;
        $('#pickUpDate').attr('min', maxDate);
    });
    
    // VALIDATIONS
    var $regexFullName = /^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/;
    var $regexPhoneNumber = /^9\d{9}$/;
    var $regexReferenceNum = /^[0-9]{13}$/;
    
    //try jquery
  $('#pickUpTime').on('invalid', function() {
     $('.error_Time').html(
                '<p class="mt-1 text-wrap lh-sm" style="width: 12rem;"><i class="bi bi-exclamation-circle-fill"></i> The available pick up time is between 8am - 5pm.</p>'
            );
            $('#pickUpTime').addClass('border-danger');
    });

    $('#fullName').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexfullName)) {
            $('.error_fullName').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! No number should be included.'
            );
            $('#fullName').addClass('border-danger');
        } else {
            $('.error_fullName').text('');
            $('#fullName').removeClass('border-danger');
        }
    })

    $('#contactNumber').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexPhoneNumber)) {
            $('.error_contactNumber').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! No letters should be included and minimum and maximum of 10 numbers only.'
            );
            $('#contactNumber').addClass('border-danger');
        } else {
            $('.error_contactNumber').text('');
            $('#contactNumber').removeClass('border-danger');
        }
    })

    $('#gcashNumber').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexPhoneNumber)) {
            $('.error_gcashNumber').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! No letters should be included and minimum and maximum of 10 numbers only.'
            );
            $('#gcashNumber').addClass('border-danger');
        } else {
            $('.error_gcashNumber').text('');
            $('#gcashNumber').removeClass('border-danger');
        }
    })

    $('#referenceNum').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexReferenceNum)) {
            $('.error_referenceNum').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! No letters should be included and minimum and maximum of 13 numbers only.'
            );
            $('#referenceNum').addClass('border-danger');
        } else {
            $('.error_referenceNum').text('');
            $('#referenceNum').removeClass('border-danger');
        }
    })

    // GET CITY
    $("#province").change(function() {
        if ($(this).val() == '') {
            $('#provinceValue').val('');
            $('#cityValue').val('');
            $('#barangayValue').val('');
            $('#city').val('');
            $('#barangay').val('');
            $('#block').val('');
            $('#city').attr('disabled', true);
            $('#barangay').attr('disabled', true);
            $('#block').attr('disabled', true);
        } else {
            $('#provinceValue').val($(this).val());
            $('#barangay').val('');
            $('#cityValue').val('');
            $('#block').val('');
            $('#barangayValue').val('');
            $('#city').attr("disabled", false);
            $('#barangay').attr('disabled', true);
            $('#block').attr('disabled', true);
            var province_id = $(this).val();
            $.ajax({
                url: "./backend/get-address.php",
                type: "POST",
                data: {
                    province_id: province_id,
                    get_city: true,
                },
                success: function(data) {
                    $('#city').html(data);
                   
                }
                
                
            })
            $.ajax({
            url: "./backend/shipping-fee.php",
                type: "POST",
                data:{
                    province_id: province_id,
                    get_shipping_fee: true,
                },
                success: function(data){
                    var shipping = $('.shipping_fee').text();
                    var totalprice = $('.totalPrice').text();
                    totalprice = parseFloat(totalprice) - parseFloat(shipping);
                    $('.totalPrice').text(totalprice.toFixed(2));
                    $('.shipping_fee').html(data);
                    shipping = $('.shipping_fee').text();
                    totalprice = $('.totalPrice').text();
                    totalprice = parseFloat(shipping) + parseFloat(totalprice);
                     $('.totalPrice').text(totalprice.toFixed(2));
                }
        
            })    
            }
        
    })

    // GET BARANGAY
    $("#city").change(function() {
        if ($(this).val() == '') {
            $('#cityValue').val('');
            $('#barangayValue').val('');
            $('#barangay').val('');
            $('#block').val('');
            $('#city').attr('disabled', false);
            $('#barangay').attr('disabled', true);
            $('#block').attr('disabled', true);
        } else {
            $('#cityValue').val($(this).val());
            $('#barangayValue').val('');
            $('#city').attr("disabled", false);
            $('#barangay').attr('disabled', false);
            $('#block').attr('disabled', true);
            var city_id = $(this).val();
            console.log(city_id);
            $.ajax({
                url: "./backend/get-address.php",
                type: "POST",
                data: {
                    city_id: city_id,
                    get_barangay: true,
                },
                success: function(data) {
                    $('#barangay').html(data);
                }
            })
        }
    })

    $('#barangay').change(function() {
        if ($(this).val() == '') {
            $('#barangayValue').val('');
            $('#block').val('');
            $('#city').attr('disabled', false);
            $('#barangay').attr('disabled', false);
            $('#block').attr('disabled', true);
        } else {
            $('#barangayValue').val($(this).val());
            $('#block').attr("disabled", false);
        }
    })

    // DELIVERY METHOD ON CHANGE
    $('#deliveryMethod').on('change', function(e) {
        e.preventDefault();

        var deliveryMethod = $('#deliveryMethod').val();

        if (deliveryMethod == 'DELIVERY') {
            $('#pickUpDate').attr('required', false);
            $('#pickUpTime').attr('required', false);
            $('#province').attr('required', true);
            $('#city').attr('required', true);
            $('#barangay').attr('required', true);
            $('#block').attr('required', true);
            $('#proofOfPayment').attr('required', true);
            $('#referenceNum').attr('required', true);
            $('#gcashNumber').attr('required', true);
            $('#courierContainer').removeClass('d-none');
            $('#addressContainer').removeClass('d-none');
            $('#pickupDateTimeContainer').addClass('d-none');
            $('#gcashContainer').removeClass('d-none');
            $('#gcashNumberContainer').removeClass('d-none');
            $('#preferredCourier').val('LALAMOVE');
            $('#paymentMethod')
                .find('option')
                .remove()
                .end()
                .append('<option value="GCASH">GCASH</option>');
                var province_id = $('#province').val();
            $.ajax({
            url: "./backend/shipping-fee.php",
                type: "POST",
                data:{
                    province_id: province_id,
                    get_shipping_fee: true,
                },
                success: function(data){
                    $('.shipping_fee').html(data);
                    var shipping = $('.shipping_fee').text();
                    var totalprice =  $('.totalPrice').text();
                    totalprice = parseFloat(shipping) + parseFloat(totalprice);
                     $('.totalPrice').text(totalprice.toFixed(2))  ;
                }
        
            })    
        } else {
            $('#pickUpDate').attr('required', true);
            $('#pickUpTime').attr('required', true);
            $('#province').attr('required', false);
            $('#city').attr('required', false);
            $('#barangay').attr('required', false);
            $('#block').attr('required', false);
            $('#proofOfPayment').attr('required', false);
            $('#referenceNum').attr('required', false);
            $('#gcashNumber').attr('required', false);
            $('#courierContainer').addClass('d-none');
            $('#addressContainer').addClass('d-none');
            $('#pickupDateTimeContainer').removeClass('d-none');
            $('#gcashContainer').addClass('d-none');
            $('#gcashNumberContainer').addClass('d-none');
            $('#lbcModeContainer').addClass('d-none');
            $('#lbcBranchContainer').addClass('d-none');
            $('#lbcMode').val('PICK UP');
            $('#preferredCourier').val('LALAMOVE');
            $('#paymentMethod')
                .find('option')
                .remove()
                .end()
                .append('<option value="CASH ON DELIVERY/PICKUP">CASH ON DELIVERY/PICKUP</option>')
                .append('<option value="GCASH">GCASH</option>');
                var shipping = $('.shipping_fee').text();
                $('.shipping_fee').text("0.00");
                    var totalprice = $('.totalPrice').text();
                    totalprice = parseFloat(totalprice) - parseFloat(shipping);
                    $('.totalPrice').text(totalprice.toFixed(2))  ;
                
        }
        
        
    })

    // COURIER ON CHANGE
    $('#preferredCourier').on('change', function(e) {
        e.preventDefault();

        var selectedCourier = $(this).val();

        if (selectedCourier == 'LBC EXPRESS') {
            $('#lbcModeContainer').removeClass('d-none');
            $('#lbcBranchContainer').removeClass('d-none');
        } else {
            $('#lbcModeContainer').addClass('d-none');
            $('#lbcBranchContainer').addClass('d-none');
            $('#lbcMode').val('PICK UP');
        }
    })

    // LBC MODE ON CHANGE
    $('#lbcMode').on('change', function(e) {
        if ($(this).val() == 'PICK UP') {
            $('#lbcBranchContainer').removeClass('d-none');
            $('#lbcBranch').attr('required', true);
        } else {
            $('#lbcBranchContainer').addClass('d-none');
            $('#lbcBranch').attr('required', false);
        }
    })

    $('#paymentMethod').on('change', function(e) {
        e.preventDefault();

        if ($(this).val() == 'GCASH') {
            $('#gcashContainer').removeClass('d-none');
            $('#gcashNumberContainer').removeClass('d-none');
            $('#proofOfPayment').attr('required', true);
            $('#referenceNum').attr('required', true);
            $('#gcashNumber').attr('required', true);
        } else {
            $('#gcashContainer').addClass('d-none');
            $('#gcashNumberContainer').addClass('d-none');
            $('#proofOfPayment').attr('required', false);
            $('#referenceNum').attr('required', false);
            $('#gcashNumber').attr('required', false);
        }
    })

    // CHECKOUT
    $('#checkoutForm').on('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            icon: 'question',
            title: 'Hey!',
            text: 'Are you sure, you want to check this out?',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: "Yes",
            color: '#000',
            background: '#fe827a',
        }).then((result) => {
            if (result.isConfirmed) {
                if ($('#proofOfPayment').val().length != 0) {
                    var user_id = $('#user_id').val();
                    var proofOfPayment = $('#proofOfPayment').val();
                    var image_ext = $('#proofOfPayment').val().split('.').pop().toLowerCase();

                    if ($.inArray(image_ext, ['png', 'jpg', 'jpeg']) == -1) {
                        $('.error_proofOfPayment').html(
                            '<i class="bi bi-exclamation-circle-fill"></i> File not supported!'
                        );
                        $('#proofOfPayment').addClass('border-danger');
                    } else {
                        $('.error_proofOfPayment').html('');
                        $('#proofOfPayment').removeClass('border-danger');
                        var imageSize = $('#proofOfPayment')[0].files[0].size;

                        if (imageSize > 10485760) {
                            $('.error_proofOfPayment').html(
                                '<i class="bi bi-exclamation-circle-fill"></i> File too large!'
                            );
                            $('#proofOfPayment').addClass('border-danger');
                        } else {
                            $('.error_proofOfPayment').html('');
                            $('#proofOfPayment').removeClass('border-danger');
                            if ($('.error_fullName').text() == '' && $('.error_contactNumber')
                                .text() == '' &&
                                $(
                                    '.error_proofOfPayment').text() == '' && $(
                                    '.error_referenceNum').text() ==
                                '') {
                                var getForm = $('#checkoutForm')[0];
                                var form = new FormData(getForm);
                                form.append('orderTotal', $('.totalPrice').text());
                                form.append('checkout', true);
                                $.ajax({
                                    url: "./backend/checkout.php",
                                    type: "POST",
                                    data: form,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function() {
                                        $('#checkoutBtn').prop('disabled', true);
                                        $('#checkoutBtn').text('Processing...');
                                    },
                                    complete: function() {
                                        $('#checkoutBtn').prop('disabled', false);
                                        $('#checkoutBtn').text(
                                            'Continue to checkout');
                                    },
                                    success: function(response) {
                                        if (response.includes('success')) {
                                            localStorage.setItem('status',
                                                'ordered');
                                            location.href = 'index.php';
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Ooops!',
                                                text: 'Something went wrong!!',
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
                        }
                    }
                } else {
                    if ($('.error_fullName').text() == '' && $('.error_contactNumber').text() ==
                        '' && $(
                            '.error_proofOfPayment').text() == '' && $('.error_referenceNum')
                        .text() == '') {
                        var getForm = $('#checkoutForm')[0];
                        var form = new FormData(getForm);
                        form.append('orderTotal', $('.totalPrice').text());
                        form.append('checkout', true);
                        $.ajax({
                            url: "./backend/checkout.php",
                            type: "POST",
                            data: form,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                $('#checkoutBtn').prop('disabled', true);
                                $('#checkoutBtn').text('Processing...');
                            },
                            complete: function() {
                                $('#checkoutBtn').prop('disabled', false);
                                $('#checkoutBtn').text('Continue to checkout');
                            },
                            success: function(response) {
                                if (response.includes('success')) {
                                    localStorage.setItem('status', 'ordered');
                                    location.href = 'index.php';
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Ooops!',
                                        text: 'Something went wrong!!',
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
                }
            }
        })
    })
})
</script>

<?php
include './components/bottom-script.php';
?>