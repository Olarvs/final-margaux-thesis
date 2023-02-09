<?php
include './components/head_css.php';
include './components/navbar.php';
?>


<style>
/*.hero {*/
/*    background: url('https://res.cloudinary.com/dh3m4os9t/image/upload/v1672859079/background-images/cover-10_kuun99.jpg');*/
/*    background-size: 100%;*/
/*    background-repeat: no-repeat;*/
/*}*/
/* CUSTOM BTN */
.darkBtn {
    background: #212529 !important;
    border-color: #212529 !important;
    color: #f8f8f8;
}

.darkBtn:hover {
    background: #3d454d !important;
    border-color: #3d454d !important;
    color: #f8f8f8;
}

.selectCustom {
    width: unset !important;
}

.position {
    margin-top: 84px !important;
}

.swiper {
    width: 100%;
    height: 500px;
}

/* COMMENTS
    –––––––––––––––––––––––––––––––––––––––––––––––––– */
.home-testimonial {
    background-color: #231834;
    height: 380px
}

.home-testimonial-bottom {
    background-color: #f8f8f8;
    transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;
    margin-top: 20px;
    margin-bottom: 0px;
    position: relative;
    height: 130px;
    top: 190px
}

.home-testimonial h3 {
    color: var(--orange);
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase
}

.home-testimonial h2 {
    color: white;
    font-size: 28px;
    font-weight: 700
}

.testimonial-inner {
    position: relative;
    top: -174px
}

.testimonial-pos {
    position: relative;
    top: 24px
}

.testimonial-inner .tour-desc {
    border-radius: 5px;
    padding: 40px
}

.color-grey-3 {
    font-family: "Montserrat", Sans-serif;
    font-size: 14px;
    color: #6c83a2
}

.testimonial-inner img.tm-people {
    width: 60px;
    height: 60px;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    -o-object-fit: cover;
    object-fit: cover;
    max-width: none
}

.link-name {
    font-family: "Montserrat", Sans-serif;
    font-size: 14px;
    color: #6c83a2
}

.link-position {
    font-family: "Montserrat", Sans-serif;
    font-size: 12px;
    color: #6c83a2
}

/* RESET STYLES
    –––––––––––––––––––––––––––––––––––––––––––––––––– */
button {
    border: none;
    background: none;
}

a,
a:hover {
    color: inherit;
}

figure {
    margin: 0;
}


/* MAIN STYLES
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

.section-with-carousel .swiper-slide figure {
    position: relative;
    overflow: hidden;
}

.section-with-carousel .swiper-slide img {
    width: 100%;
    object-fit: cover;
}

.section-with-carousel .swiper-slide figcaption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    transform: translateY(20%);
    display: flex;
    align-items: baseline;
    justify-content: center;
    padding: 20px;
    text-align: center;
    opacity: 0;
    visibility: hidden;
    color: white;
    background: rgba(0, 0, 0, 0.5);
    transition: all 0.3s;
}

.section-with-carousel .swiper-slide figcaption svg {
    flex-shrink: 0;
    fill: white;
    margin-right: 10px;
}

.section-with-carousel .swiper-slide-active figcaption {
    opacity: 1;
    visibility: visible;
    transform: none;
}

.section-with-carousel .carousel-controls {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    padding: 0 12px;
    z-index: 1;
}

.section-with-carousel .carousel-controls .carousel-control {
    opacity: 0.25;
    transition: opacity 0.3s;
}

.section-with-carousel .carousel-controls .carousel-control:hover {
    opacity: 1;
}

.section-with-carousel .swiper-pagination-bullets {
    position: static;
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: auto;
    height: auto;
    background: transparent;
    opacity: 0.5;
    margin: 0 8px;
    border-radius: 0;
    transition: opacity 0.3s;
}

.section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet .line {
    width: 3px;
    height: 3px;
    background: black;
    transition: transform 0.3s;
}

.section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet .number {
    opacity: 0;
    transform: translateY(-7px);
    transition: all 0.3s;
}

.section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active {
    opacity: 1;
}

.section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active .line {
    transform: scaleX(8);
}

.section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active .number {
    opacity: 1;
    transform: none;
}

.copyright .col-auto:not(:last-child) {
    position: relative;
}

.copyright .col-auto:not(:last-child)::before {
    content: "•";
    position: absolute;
    top: 50%;
    right: -2px;
    transform: translateY(-50%);
}

@media (min-width: 768px) {
    .section-with-carousel .swiper-slide img {
        height: 370px;
    }
}

@media (min-width: 1200px) {
    .section-with-carousel .swiper-slide img {
        height: 420px;
    }

    .section-with-carousel .carousel-controls {
        padding: 0 50px;
    }
}

.feedbackCard {
    display: none;
}

.feedbackCard:nth-child(1),
.feedbackCard:nth-child(2),
.feedbackCard:nth-child(3) {
    display: inline-block;
}
</style>

<!-- Start Hero Section -->
<section id="home" class="hero">
    <div class="container">
        <div class="row py-5 d-flex justify-content-between align-items-center">
            <div class="col-lg-8 ">
                <div class="text-center text-lg-start">
                    <h1 style="letter-spacing: .1rem;"><span>Margaux Cacti & Succulents Corner</span></h1>
                    <h6 class="mb-4 text-white lh-base" style="letter-spacing: .1rem;">Welcome to our cacti and succulents online store. We are excited to be able to provide you with a wide range of these lovely and special plants!</h6>
                    <p>
                        <a href="shop.php" class="btn btn-secondary me-2" style="letter-spacing: .1rem">Shop Now</a>
                        <!-- <button id="explore" class="btn btn-white-outline">Explore</button> -->
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class=" d-flex justify-content-center">
                    <img src="./assets/images/kawaii2.png" class="w-100">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Section -->

<!-- SWIPER JS -->

<section class="section-with-carousel section-with-left-offset position-relative mt-5" id="categorySection">
    <div class="container">
        <h2 class="mb-3 text-center text-dark" style="font-weight: bold !important;">MARGAUX VARIETIES</h2>
    </div>
    <?php
$getCategory = mysqli_query($conn, "SELECT * FROM tbl_category WHERE isDeleted = 0");

if(mysqli_num_rows($getCategory) > 0) {
?>
    <div class="carousel-wrapper">
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php
                foreach($getCategory as $category) {
                ?>
                <div class="swiper-slide">
                    <figure>
                        <img src="./admin/assets/images/categoryImages/<?= $category['categoryThumbnail']; ?>" alt="">
                        <figcaption>
                            <h5 id="categoryDisplay" style="text-transform: uppercase; font-weight: 700;"><?= $category['categoryName']; ?>
                            </h5>
                        </figcaption>
                    </figure>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="carousel-controls">
        <div class="carousel-control carousel-control-left">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40">
                <path fill-rule="evenodd"
                    d="M10.78 19.03a.75.75 0 01-1.06 0l-6.25-6.25a.75.75 0 010-1.06l6.25-6.25a.75.75 0 111.06 1.06L5.81 11.5h14.44a.75.75 0 010 1.5H5.81l4.97 4.97a.75.75 0 010 1.06z">
                </path>
            </svg>
        </div>
        <div class="carousel-control carousel-control-right">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40">
                <path fill-rule="evenodd"
                    d="M13.22 19.03a.75.75 0 001.06 0l6.25-6.25a.75.75 0 000-1.06l-6.25-6.25a.75.75 0 10-1.06 1.06l4.97 4.97H3.75a.75.75 0 000 1.5h14.44l-4.97 4.97a.75.75 0 000 1.06z">
                </path>
            </svg>
        </div>
    </div>

    <?php
    }
    ?>
</section>

<?php
$getCategory = mysqli_query($conn, "SELECT * FROM tbl_category WHERE isDeleted = 0");

if(mysqli_num_rows($getCategory) > 0) {
?>
<div class="container mb-4" style="height: 100%;">
    <div class="row d-flex justify-content-center align-items-stretch" style="height: 100%;">
        <?php
        foreach($getCategory as $category) {
        ?> <a href="product.php?categoryId=<?= $category['categoryId']; ?>" class="col-sm-6 col-md-4 col-xxl-3 mb-4"
            style="height: 100%; text-decoration: none;">
            <div class="card px-2 pt-2" style="height: 100%;">
                <div class="image-cont" style="height: 200px; width: 100%;">
                    <img src="./admin/assets/images/categoryImages/<?= $category['categoryThumbnail']; ?>"
                        class="w-100 h-100" style="object-fit: cover;" alt="">
                </div>
                <div class="category-content mt-1 text-center">
                    <h5 style="text-transform: uppercase; font-weight: 700;"><?= $category['categoryName']; ?></h5>
                </div>
            </div>
        </a>

        <?php
        }
        ?>
    </div>
    <div class="row justify-content-center">
        <button type="button" class="btn btn-primary text-center darkBtn" style="width: inherit; letter-spacing: .1rem"
            onclick="location.href='shop.php'">VIEW ALL PRODUCTS</button>
    </div>
</div>
<?php
}
?>


<section id="products" class="product-section bg-dark t-0 ">
    <div class="container">
        <h2 class="mb-4 text-center b-3" style="font-weight: bold !important; color: #fe827a; letter-spacing: .1rem">NEW PRODUCTS</h2>
    </div>
    <div class="container">

        <div class="row">
            <div class="col-md-12 col-lg-3 mb-5 mb-lg-0 text-center text-lg-start text-white">
                <h2 class="mb-4 section-title text-white" style="letter-spacing: .1rem;">Our store has some beautiful new additions!</h2>
                <p class="mb-4 text-white" style="letter-spacing: .1rem;">Check out our newly added products now, whether you're looking for the ideal gift or simply want to bring a desert aesthetic to your home or workplace.</p>
                <p><a href="shop.php" class="btn btn-outline-secondary text-white" style="letter-spacing: .1rem">Go to Shop</a></p>
            </div>
            <?php
            $getProduct = mysqli_query($conn, "SELECT tbl_category.*, tbl_product.*
            FROM tbl_category
            LEFT JOIN tbl_product
            ON tbl_category.categoryId = tbl_product.categoryId
            WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0 ORDER BY tbl_product.productId DESC LIMIT 3");

            foreach($getProduct as $product) {
            ?>
            <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                <!--javascript:void(0)-->
                <a class="product-item" href="view-product.php?productId=<?= $product['productId'] ?>">
                    <img src="./admin/assets/images/productImages/<?= $product['productThumbnail'] ?>"
                        class="img-fluid product-thumbnail">
                    <h3 class="product-title text-white" style="letter-spacing: .1rem;"><?= $product['productName'] ?></h3>
                    <strong class="product-price text-white" style="letter-spacing: .1rem;">P<?= $product['productPrice'] ?></strong>
                    
                    <span class="icon-cross">
                        <img src="./assets/images/cross.svg" class="img-fluidd">
                    </span>
                </a>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<!-- End Product Section-->

<!-- Start Why Choose Us Section -->
<!-- <div class="about bg-dark p-2 w-100 text-white text-center bi">
    <h1>WHY CHOOSE US?</h1>
</div>
<div class="why-choose-section text-white" style="background-color: #fe827a;">
    <div class="container">


        <div class="row my-5 bg-white p-lg-3">


            <div class="col-6 col-md-6 col-lg-3 mb-4">
                <div class="feature">
                    <div class="icon">
                        <img src="./assets/images/truck.svg" alt="Image" class="imf-fluid">
                    </div>
                    <h3>Fast &amp; Free Shipping</h3>
                    <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.</p>
                </div>
            </div>

            <div class="col-6 col-md-6 col-lg-3 mb-4">
                <div class="feature">
                    <div class="icon">
                        <img src="./assets/images/bag.svg" alt="Image" class="imf-fluid">
                    </div>
                    <h3>Easy to Shop</h3>
                    <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.</p>
                </div>
            </div>

            <div class="col-6 col-md-6 col-lg-3 mb-4">
                <div class="feature">
                    <div class="icon">
                        <img src="./assets/images/support.svg" alt="Image" class="imf-fluid">
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.</p>
                </div>
            </div>

            <div class="col-6 col-md-6 col-lg-3 mb-4">
                <div class="feature">
                    <div class="icon">
                        <img src="./assets/images/return.svg" alt="Image" class="imf-fluid">
                    </div>
                    <h3>Hassle Free Returns</h3>
                    <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.</p>
                </div>
            </div>

        </div>

    </div>
</div> -->
<!-- End Why Choose Us Section -->

<div class="container my-5" id="feedbackSection">
    <h2 class="mb-3 text-center" style="font-weight: bold !important; color: #fe827a; letter-spacing: .1rem;">FEEDBACK
    </h2>
    <?php
        $getFeedback = mysqli_query($conn, "SELECT tbl_feedback.rate, tbl_user.`name`, tbl_feedback.`comment`, tbl_user.profile_image
        FROM tbl_feedback
        LEFT JOIN tbl_user
        ON tbl_feedback.userId = tbl_user.user_id");

        if(mysqli_num_rows($getFeedback) < 0) {
        ?>
    <div class="row justify-content-center">
        <p>No feedback available</p>
    </div>
    <?php
        } else {
        ?>
    <div class="row justify-content-center" id="feedbackContainer">
        <?php  
            foreach($getFeedback as $feedback) {
            ?>
        <div class="col-md-4 feedbackCard mb-4">
            <div class="card p-3 h-100">
                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                    <?php 
                    $feedbackCom = '';

                    if($feedback['comment'] != '' || $feedback['comment'] != NULL) {
                        $feedbackCom = '“'.$feedback['comment'].'”';
                    }
                    ?>
                    <p class="text-center"><?= $feedbackCom ?></p>
                    <img src="./assets/images/profile_image/<?= $feedback['profile_image'] ?>" alt=""
                        style="height: 80px; width: 80px; object-fit: cover; border-radius: 50%;">
                    <p><?= $feedback['name'] ?></p>
                    <p
                    <?php 
                    if($feedback['rate'] == 'Amazing'){
                      echo "style='color: #fe827a'";
                    }elseif($feedback['rate'] == 'Good'){
                      echo "style='color: green'";
                    }elseif($feedback['rate'] == 'Fair'){
                      echo "style='color: blue'";
                    }elseif($feedback['rate'] == 'Poor'){
                      echo "style='color: orange'";
                    }elseif($feedback['rate'] == 'Terrible'){
                      echo "style='color: red'";
                    }
                    ?>
                      !important; font-weight: bold; border: 2px solid #fe827a;" id="rate"><?= $feedback['rate'] ?></p>
                </div>
         
            </div>
        </div>
        <!--color: #fe827a-->
        <?php
            }
            ?>
    </div>
     <?php
    // if(mysqli_num_rows($getFeedback) > 3) {
     ?>
    <div class="row justify-content-center mt-3">
        <button type="button" class="btn btn-primary text-center darkBtn" style="width: inherit; letter-spacing: .1rem" onclick="location.href='feedbacks.php'">VIEW MORE</button>
        
    </div>
    <?php
    // }
    ?>
  
    <?php 
        } 
        ?>
</div>

<script>
$(window).on('load', function() {
    <?php
    if(isset($_SESSION['margaux_user_id'])) {
    ?>
    if (localStorage.getItem('status') == 'welcome') {
        Swal.fire({
            title: 'Welcome, <?= $_SESSION['margaux_name'] ?>!',
            toast: true,
            position: 'top-right',
            iconColor: '#fe827a',
            confirmButtonColor: '#fe827a',
            showConfirmButton: false,
            color: '#fe827a',
            background: '#212529',
            timer: 5000,
            timerProgressBar: true,
            customClass: {
                container: 'position'
            },
        })
        localStorage.removeItem('status');
    }
    <?php
    }
    ?>
    if (localStorage.getItem('status') == 'ordered') {
        Swal.fire({
            icon: 'success',
            title: 'Thank you!',
            text: 'Your order was successfully submitted! Please wait for the order confirmation we\'re about to send you via email.',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,
            color: '#000',
            background: '#fe827a',
        })
        localStorage.removeItem('status');
    }

    var element = document.querySelectorAll('.feedbackCard').length;
    // var Btn = document.querySelector('#viewMoreBtn');

    // if (element <= 3) {
    //     Btn.style.display = 'none';
    // }
    console.log(element);
})

$(document).ready(function() {

    // VIEW MORE BTN
    // let viewMoreBtn = document.querySelector('#viewMoreBtn');
    // let currentItem = 3;

    // viewMoreBtn.onclick = () => {
    //     let boxes = [...document.querySelectorAll('.feedbackCard')];
    //     for (var i = currentItem; i < currentItem + 3; i++) {
    //         boxes[i].style.display = 'inline-block';
    //         currentItem += 3;
    //         console.log(boxes.length);
    //         console.log(currentItem);
    //         if (currentItem >= boxes.length) {
    //             viewMoreBtn.style.display = 'none';
    //         }
    //     }
    //     currentItem += 3;
    //     console.log(currentItem);



    // }
})
</script>

<!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "101119269543917");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v15.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

<?php
include './components/footer.php';
include './components/bottom-script.php';
?>

<script>
const swiper = new Swiper('.swiper', {
    slidesPerView: 'auto',
    spaceBetween: 15,
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
</script>

<script>
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}
</script>


<script>
const sectionsWithCarousel = document.querySelectorAll(
    ".section-with-carousel"
);

createOffsets();
window.addEventListener("resize", createOffsets);

function createOffsets() {
    const sectionWithLeftOffset = document.querySelector(
        ".section-with-left-offset"
    );
    const sectionWithLeftOffsetCarouselWrapper = sectionWithLeftOffset.querySelector(
        ".carousel-wrapper"
    );
    const sectionWithRightOffset = document.querySelector(
        ".section-with-right-offset"
    );
    const sectionWithRightOffsetCarouselWrapper = sectionWithRightOffset.querySelector(
        ".carousel-wrapper"
    );
    const offset = (window.innerWidth - 1100) / 2;
    const mqLarge = window.matchMedia("(min-width: 1200px)");

    if (sectionWithLeftOffset && mqLarge.matches) {
        sectionWithLeftOffsetCarouselWrapper.style.marginLeft = offset + "px";
    } else {
        sectionWithLeftOffsetCarouselWrapper.style.marginLeft = 0;
    }

    if (sectionWithRightOffset && mqLarge.matches) {
        sectionWithRightOffsetCarouselWrapper.style.marginRight = offset + "px";
    } else {
        sectionWithRightOffsetCarouselWrapper.style.marginRight = 0;
    }
}

for (const section of sectionsWithCarousel) {
    let slidesPerView = [1.5, 2.5, 3.5];
    if (section.classList.contains("section-with-left-offset")) {
        slidesPerView = [1.5, 1.5, 2.5];
    }
    const swiper = section.querySelector(".swiper");
    new Swiper(swiper, {
        slidesPerView: slidesPerView[0],
        spaceBetween: 15,
        loop: true,
        lazyLoading: true,
        keyboard: {
            enabled: true
        },
        navigation: {
            prevEl: section.querySelector(".carousel-control-left"),
            nextEl: section.querySelector(".carousel-control-right")
        },
        pagination: {
            el: section.querySelector(".swiper-pagination"),
            clickable: true,
            renderBullet: function(index, className) {
                return `<div class=${className}>
            <span class="number">${index + 1}</span>
            <span class="line"></span>
        </div>`;
            }
        },
        breakpoints: {
            768: {
                slidesPerView: slidesPerView[1]
            },
            1200: {
                slidesPerView: slidesPerView[2]
            }
        }
    });
}
</script>