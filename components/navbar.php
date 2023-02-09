<style>
.custom_dropdown {
    background-color: #fe827a !important;
}

.custom_dropdown li a.dropdown-item:hover {
    background-color: #212529;
    color: #fe827a;
}

.custom_dropstart .dropdown-menu[data-bs-popper] {
    margin-top: 10px;
}

@media (min-width: 1200px) {
    .custom_dropstart .dropdown-menu[data-bs-popper] {
        top: 0;
        right: 100%;
        left: auto;
        margin-top: 50px;
        margin-right: -25px;
    }
}
</style>



<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar-expand-xl navbar-dark bg-dark fixed-top" arial-label="Furni navigation bar">

    <div class="container">
        <a class="navbar-brand" href="index.php">Margaux Corner<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
            aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0" style="letter-spacing: .1rem;">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li><a class="nav-link" href="index.php#categoryDisplay">Category</a></li>
                <li><a class="nav-link" href="shop.php">Shop</a></li>
                <li><a class="nav-link" href="index.php#feedbackSection">Feedback</a></li>
            </ul>

            <ul class="navbar-nav">
                <?php
                if(!isset($_SESSION['margaux_user_id'])) {
                ?>
                <li><a class="nav-link" href="login.php"><img src="./assets/images/user.svg"></a></li>
                <?php
                }
                ?>
                <li style="padding-right: 10px;">
                    <div class="position-relative" style="width: 100%;">
                        <a class="nav-link cart-icon" href="cart.php"><img src="./assets/images/cart.svg">
                        </a>
                        <?php
                        if($cartCount > 0) {
                        ?>
                        <span style="top: 5px; left: 50%; margin-left: 5px;" class="position-absolute badge rounded-pill bg-danger">
                            <?= $cartCount ?>
                        </span>
                        <?php
                        }
                        ?>
                    </div>
                </li>
                <?php
                if(isset($_SESSION['margaux_user_id'])) {

                $getUserImage = mysqli_query($conn, "SELECt * FROM tbl_user WHERE user_id = $userId");

                $row = mysqli_fetch_array($getUserImage);

                $image = $row['profile_image'];
                ?>
                <li>
                    <div class="dropdown nav-link dropstart custom_dropstart">
                        <img class="dropdown-toggle" data-bs-toggle="dropdown" class="rounded-circle"
                            style="cursor: pointer; height: 26px; width: 26px; object-fit: cover; border-radius: 50%;" src="./assets/images/profile_image/<?= $image ?>">
                        <ul class="dropdown-menu dropdown-menu-start custom_dropdown" style="letter-spacing: .1rem;">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="current-order.php">Current Purchase</a></li>
                            <li><a class="dropdown-item" href="order-history.php">Purchase History</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>

</nav>

<div class="divider">
</div>

