<?php
session_start();
if(isset($_SESSION['margaux_admin_id'])) {
    ?>
<script>
location.href = 'index.php';
</script>
<?php
}

unset($_SESSION['admin_change_pass_email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Margaux Corner</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./assets/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="./assets/images/logo.png" />
    <script src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
</head>

<style>
body {
    background: url(../assets/images/bgpink.png) no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
    background-attachment: fixed !important;
    height: 100vh !important;
}

.auth .auth-form-light {
    border-radius: 7px !important;
    background: #212529 !important;
}

.form-control {
    background-color: #fff !important;
    color: #212529 !important;
    border-radius: 3px !important;
    font-size: 14px !important;
}

.btn {
    box-shadow: none !important;
}

.form-select {
    background-color: #fff !important;
    color: #212529 !important;
    border-radius: 3px !important;
    height: 55px !important;
}

.auth-form-light {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #212529 !important;
    border-radius: 5px;
    width: 500px !important;
    max-width: 94% !important;
}

.password-container {
    position: relative;
}

.password-container input[type="password"],
.password-container input[type="text"] {
    width: 100%;
    padding: 27px 50px 27px 27px;
    box-sizing: border-box;
}

.fa-eye,
.fa-eye-slash {
    position: absolute;
    top: 33%;
    right: 4%;
    cursor: pointer;
    color: gray;
    font-size: 18px;
}
</style>

<body>
    <div class="row w-100 mx-0">
        <div class="col-md-8 col-lg-6 col-xl-4 mx-auto">
            <div class="auth-form-light text-left py-4 px-4 px-sm-5">
                <div class="brand-logo d-flex align-items-center">
                    <img style="width: 50px;" src="./assets/images/logo.png" alt="logo">
                    <span style="font-size: 26px; font-weight: 600; letter-spacing: 1px;" class="text-light">SIGN
                        IN</span>
                </div>
                <form id="loginForm" class="pt-3">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" id="username" name="username"
                            placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <div class="password-container">
                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                placeholder="Password" required>
                            <i class="fa-solid fa-eye" id="eye"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <select class="form-select" id="role" name="role" aria-label="Default select example">
                            <option value="ADMIN">ADMIN</option>
                            <option value="STAFF">STAFF</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <button type="submit"
                            class="btn btn-block btn-primary btn-lg text-dark font-weight-bold auth-form-btn"
                            id="signInBtn">SIGN IN</button>
                    </div>
                    <div class="my-2 d-flex align-items-center justify-content-end">
                        <!-- <div class="form-check">
                            <label class="form-check-label text-light">
                                <input type="checkbox" class="form-check-input text-light">
                                Keep me signed in
                            </label>
                        </div> -->
                        <a href="forgot-password.php" class="auth-link text-light justify-self-right" style="font-size: 14px;">Forgot password?</a>
                    </div>
                    <div class="text-center font-weight-light text-light mt-2" style="font-size: 14px;">
                        Don't have an account?
                        <a href="register.php" class="text-primary">Create</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(window).on('load', function() {
        if (localStorage.getItem('status') == 'password_updated') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Password reset successfully! You can now login.',
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
        // SHOW PASSWORD
        const passwordInput = document.querySelector("#password")
        const eye = document.querySelector("#eye")

        eye.addEventListener("click", function() {
            eye.classList.toggle("fa-eye-slash");
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
            passwordInput.setAttribute("type", type);
        })

        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            var form = new FormData(this);
            form.append('login', true);

            $.ajax({
                type: "POST",
                url: "./backend/login.php",
                data: form,
                dataType: "text",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#signInBtn').prop('disabled', true);
                    $('#signInBtn').text('Processing...');
                },
                complete: function() {
                    $('#signInBtn').prop('disabled', false);
                    $('#signInBtn').text('SIGN IN');
                },
                success: function(response) {
                    if (response.includes('success')) {
                        localStorage.setItem('status', 'welcome');
                        location.href = 'index.php';
                    } else if (response.includes('invalid')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ooops...',
                            text: 'Invalid credentials!',
                            iconColor: '#000',
                            confirmButtonColor: '#000',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            color: '#000',
                            background: '#fe827a',
                        })
                    } else if (response.includes('not activate')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ooops...',
                            text: 'Your account is still disabled. Please wait for admin to enable it!',
                            iconColor: '#000',
                            confirmButtonColor: '#000',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            color: '#000',
                            background: '#fe827a',
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
        })
    })
    </script>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="./assets/vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="./assets/js/off-canvas.js"></script>
    <script src="./assets/js/hoverable-collapse.js"></script>
    <script src="./assets/js/template.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- endinject -->
</body>

</html>