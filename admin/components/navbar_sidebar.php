<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <a class="navbar-brand brand-logo" style="font-weight: 700; color: #fe827a;"
                        href="index.php">Margaux Corner</a>
                    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="./assets/images/logo.png"
                            alt="logo" style="object-fit: cover;" /></a>
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <!-- <ul class="navbar-nav mr-lg-4 w-100">
          <li class="nav-item nav-search d-none d-lg-block w-100">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="search">src
                  <i class="mdi mdi-magnify"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul> -->
                <ul class="navbar-nav navbar-nav-right">
                    <!-- <li class="nav-item dropdown mr-1">
            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-message-text mx-0"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="messageDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                    <img src="./assets/images/faces/face4.jpg" alt="image" class="profile-pic">
                </div>
                <div class="item-content flex-grow">
                  <h6 class="ellipsis font-weight-normal">David Grey
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    The meeting is cancelled
                  </p>
                </div>
              </a>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                    <img src="./assets/images/faces/face2.jpg" alt="image" class="profile-pic">
                </div>
                <div class="item-content flex-grow">
                  <h6 class="ellipsis font-weight-normal">Tim Cook
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    New product launch
                  </p>
                </div>
              </a>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                    <img src="./assets/images/faces/face3.jpg" alt="image" class="profile-pic">
                </div>
                <div class="item-content flex-grow">
                  <h6 class="ellipsis font-weight-normal"> Johnson
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    Upcoming board meeting
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown mr-4">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell mx-0"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                  <div class="item-icon bg-success">
                    <i class="mdi mdi-information mx-0"></i>
                  </div>
                </div>
                <div class="item-content">
                  <h6 class="font-weight-normal">Application Error</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Just now
                  </p>
                </div>
              </a>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                  <div class="item-icon bg-warning">
                    <i class="mdi mdi-settings mx-0"></i>
                  </div>
                </div>
                <div class="item-content">
                  <h6 class="font-weight-normal">Settings</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Private message
                  </p>
                </div>
              </a>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                  <div class="item-icon bg-info">
                    <i class="mdi mdi-account-box mx-0"></i>
                  </div>
                </div>
                <div class="item-content">
                  <h6 class="font-weight-normal">New user registration</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    2 days ago
                  </p>
                </div>
              </a>
            </div>
          </li> -->
                    <?php
                    $adminId = $_SESSION['margaux_admin_id'];
                    $getAccount = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE adminId = $adminId");

                    foreach($getAccount as $row) {
                    ?>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle d-flex flex-row align-items-center" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img style="object-fit: cover;" src="./assets/images/profileImage/<?= $row['profile_image'] ?>" alt="profile" />
                            <span class="nav-profile-name"><?= $row['username'] ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="profile.php">
                                <i class="mdi mdi-settings text-primary"></i>
                                Profile Account
                            </a>
                            <a class="dropdown-item" href="logout.php">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar" style="letter-spacing: .1rem;">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                        <i class="fa-solid fa-fw fa-house menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <!--Product-->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#archive" aria-expanded="false"
                            aria-controls="archive">
                            <i class="fa-solid fa-fw fa-clipboard-list menu-icon"></i>
                            <span class="menu-title">Products</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="archive">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="category.php"> Category </a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="archive.php"> Archive
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <!--EndProduct-->
                    <li class="nav-item">
                        <a class="nav-link" href="inventory.php">
                        <i class="fa-solid fa-fw fa-boxes-stacked menu-icon"></i>
                            <span class="menu-title">Inventory</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false"
                            aria-controls="auth">
                            <i class="fa-solid fa-fw fa-clipboard-list menu-icon"></i>
                            <span class="menu-title">Orders</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="auth">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pickup.php"> Pick Up </a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="delivery.php"> Delivery
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="completed-order.php">
                        <i class="fa-solid fa-fw fa-check-to-slot menu-icon"></i>
                            <span class="menu-title">Completed Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cancelled-order.php">
                        <i class="fa-solid fa-fw fa-rectangle-xmark menu-icon"></i>
                            <span class="menu-title">Cancelled Orders</span>
                        </a>
                    </li>

                    <?php 
                    if($_SESSION['margaux_role'] == 'ADMIN') {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#accounts" aria-expanded="false"
                            aria-controls="accounts">
                            <i class="fa-solid fa-fw fa-address-card menu-icon"></i>
                            <span class="menu-title">Accounts</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="accounts">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="user-accounts.php"> Users </a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="admin-accounts.php"> Admin
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
                    }
                    ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#homepage" aria-expanded="false"
                            aria-controls="homepage">
                            <i class="fa-solid fa-palette menu-icon"></i>
                            <span class="menu-title">Manage Homepage</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="homepage">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Background </a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.html"> Display Image
                                    </a></li>
                            </ul>
                        </div>
                    </li> -->
                    <?php
                    if($_SESSION['margaux_role'] == 'ADMIN') {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#report" aria-expanded="false"
                            aria-controls="report">
                            <i class="fa-solid fa-fw fa-chart-line menu-icon"></i>
                            <span class="menu-title">Reports</span> 
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="report">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="sales-report.php"> Sales Report</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="inventory-report.php"> Inventory Report
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
            <!-- partial -->