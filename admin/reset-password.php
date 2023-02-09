<?php
session_start();
if(!isset($_SESSION['admin_change_pass_email'])) {
    ?>
<script>
location.href = 'login.php';
</script>
<?php
}
unset($_SESSION['admin_forgot_pass_time']);
unset($_SESSION['admin_forgot_pass_otp']);
unset($_SESSION['admin_forgot_pass_email']);
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
                    <span style="font-size: 26px; font-weight: 600; letter-spacing: 1px;" class="text-light">RESET
                        PASSWORD</span>
                </div>
                <form id="resetPassForm" class="pt-3">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg" id="email" name="email"
                            placeholder="Email" value="<?= $_SESSION['admin_change_pass_email'] ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <div class="password-container">
                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                placeholder="Password" required>
                            <i class="fa-solid fa-eye" id="eye"></i>
                        </div>
                        <span class="error error_password"
                            style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
                    </div>
                    <div class="form-group">
                        <div class="password-container">
                            <input type="password" class="form-control form-control-lg" id="cpassword" name="cpassword"
                                placeholder="Confirm Password" required>
                            <i class="fa-solid fa-eye" id="ceye"></i>
                        </div>
                        <span class="error error_confirmPassword"
                            style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
                    </div>
                    <div class="mt-3">
                        <button type="submit"
                            class="btn btn-block btn-primary btn-lg text-dark font-weight-bold auth-form-btn"
                            id="resetPassBtn">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // SHOW PASSWORD
        const passwordInput = document.querySelector("#password")
        const eye = document.querySelector("#eye")
        const cpasswordInput = document.querySelector("#cpassword")
        const ceye = document.querySelector("#ceye")

        eye.addEventListener("click", function() {
            eye.classList.toggle("fa-eye-slash");
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
            passwordInput.setAttribute("type", type);
        })

        ceye.addEventListener("click", function() {
            ceye.classList.toggle("fa-eye-slash");
            const type = cpasswordInput.getAttribute("type") === "password" ? "text" : "password"
            cpasswordInput.setAttribute("type", type);
        })

        // VALIDATIONS
        var $regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

        $('#password').on('keypress keydown keyup', function() {
            if (!$.trim($(this).val()).match($regexPassword)) {
                $('.error_password').html(
                    '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! Minimum eight characters, at least one uppercase letter, one lowercase letter and one number.'
                );
                $('#password').addClass('border-danger');
            } else {
                $('.error_password').text('');
                $('#password').removeClass('border-danger');
            }
        })

        $('#cpassword').on('keypress keydown keyup', function() {
            if (!$.trim($(this).val()).match($regexPassword)) {
                $('.error_confirmPassword').html(
                    '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! Minimum eight characters, at least one uppercase letter, one lowercase letter and one number.'
                );
                $('#cpassword').addClass('border-danger');
            } else {
                $('.error_confirmPassword').text('');
                $('#cpassword').removeClass('border-danger');
            }
        })

        $('#resetPassForm').on('submit', function(e) {
            e.preventDefault();

            if ($('.error_password').text() == '' && $('.error_confirmPassword').text() == '') {
                var form = new FormData(this);
                form.append('resetPassword', true);

                $.ajax({
                    type: "POST",
                    url: "./backend/forgot-password.php",
                    data: form,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('#resetPassBtn').prop('disabled', true);
                        $('#resetPassBtn').text('Processing...');
                    },
                    complete: function() {
                        $('#resetPassBtn').prop('disabled', false);
                        $('#resetPassBtn').text('Reset');
                    },
                    success: function(response) {
                        if (response.includes('success')) {
                            localStorage.setItem('status', 'password_updated');
                            location.href = 'login.php';
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