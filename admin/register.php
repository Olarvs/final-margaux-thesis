<?php
session_start();
if(isset($_SESSION['margaux_admin_id'])) {
    ?>
    <script>
        location.href = 'index.php';
    </script>
    <?php
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="./assets/images/logo.png" />
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
    width: 700px !important;
    max-width: 94% !important;
}

.password-container {
    position: relative;
}

.password-container input[type="password"],
.password-container input[type="text"] {
    width: 100%;
    padding: 27px 40px 27px 27px;
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
        <div class="custom_cont mx-auto">
            <div class="auth-form-light text-left py-4 px-4 px-sm-5">
                <div class="brand-logo d-flex align-items-center">
                    <img style="width: 50px;" src="./assets/images/logo.png" alt="logo">
                    <span style="font-size: 26px; font-weight: 600; letter-spacing: 1px;" class="text-light">SIGN
                        UP</span>
                </div>
                <form id="registerForm" class="pt-3">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="" class="text-light">Name</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name"
                                placeholder="Name" required>
                            <span class="error error_name"
                                style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="" class="text-light">Username</label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username"
                                placeholder="Username" required>
                            <span class="error error_username"
                                style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="" class="text-light">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                placeholder="Email" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="" class="text-light">Role</label>
                            <select class="form-select" id="role" name="role" aria-label="Default select example">
                                <option value="ADMIN">ADMIN</option>
                                <option value="STAFF">STAFF</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="" class="text-light">Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control form-control-lg" id="password"
                                    name="password" placeholder="Password" required>
                                <i class="fa-solid fa-eye" id="eye"></i>
                            </div>
                            <span class="error error_password"
                                style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="" class="text-light">Confirm Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control form-control-lg" id="confirmPassword"
                                    name="confirmPassword" placeholder="Confirm password" required>
                                <i class="fa-solid fa-eye" id="confirmEye"></i>
                            </div>
                            <span class="error error_confirmPassword"
                                style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" id="registerBtn"
                            class="btn btn-block btn-primary btn-lg text-dark font-weight-bold auth-form-btn">SIGN
                            UP</button>
                    </div>
                    <div class="text-center font-weight-light mt-3 text-light" style="font-size: 14px;">
                        Already have an account?
                        <a href="login.php" class="text-primary" id="login">Login now</a>
                        <style>#login:hover{text-decoration: none;}</style>
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
        const passwordInputConfirm = document.querySelector("#confirmPassword")
        const eyeConfirm = document.querySelector("#confirmEye")

        eye.addEventListener("click", function() {
            eye.classList.toggle("fa-eye-slash");
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
            passwordInput.setAttribute("type", type);
        })

        eyeConfirm.addEventListener("click", function() {
            eyeConfirm.classList.toggle("fa-eye-slash");
            const confirmType = passwordInputConfirm.getAttribute("type") === "password" ? "text" :
                "password"
            passwordInputConfirm.setAttribute("type", confirmType);
        })

        // VALIDATIONS
        var $regexName = /^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/;
        var $regexUsername = /^(?=[a-zA-Z0-9._]{8,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/;

        var $regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

        $('#name').on('keypress keydown keyup', function() {
            if (!$.trim($(this).val()).match($regexName)) {
                $('.error_name').html(
                    '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! No number should be included.'
                );
                $('#name').addClass('border-danger');
            } else {
                $('.error_name').text('');
                $('#name').removeClass('border-danger');
            }
        })

        $('#username').on('keypress keydown keyup', function() {
            if (!$.trim($(this).val()).match($regexUsername)) {
                $('.error_username').html(
                    '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! It should only contains alphanumeric characters, underscore and dot.'
                );
                $('#username').addClass('border-danger');
            } else {
                $('.error_username').text('');
                $('#username').removeClass('border-danger');
            }
        })

        $('#password').on('keypress keydown keyup', function() {
            if (!$.trim($(this).val()).match($regexPassword)) {
                $('.error_password').html(
                    '<i class="bi bi-exclamation-circle-fill"></i> Minimum eight characters, at least one uppercase letter, one lowercase letter and one number.'
                );
                $('#password').addClass('border-danger');
            } else {
                $('.error_password').text('');
                $('#password').removeClass('border-danger');
            }
        })

        $('#confirmPassword').on('keypress keydown keyup', function() {
            if (!$.trim($(this).val()).match($regexPassword)) {
                $('.error_confirmPassword').html(
                    '<i class="bi bi-exclamation-circle-fill"></i> Minimum eight characters, at least one uppercase letter, one lowercase letter and one number.'
                );
                $('#confirmPassword').addClass('border-danger');
            } else {
                $('.error_confirmPassword').text('');
                $('#confirmPassword').removeClass('border-danger');
            }
        })

        // REGISTER
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();

            if ($('#password').val() != $('#confirmPassword').val()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops...',
                    text: 'Password confirmation does not match!',
                    iconColor: '#000',
                    confirmButtonColor: '#000',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    color: '#000',
                    background: '#fe827a',
                })
            } else {
                if ($('.error_name').text() == '' && $('.error_username').text() == '' && $(
                        '.error_password').text() == '' && $('.error_confirmPassword').text() == '') {
                    var getForm = $('#registerForm')[0];
                    var form = new FormData(getForm);
                    form.append('register', true);

                    $.ajax({
                        type: "POST",
                        url: "./backend/register.php",
                        data: form,
                        dataType: "text",
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#registerBtn').prop('disabled', true);
                            $('#registerBtn').text('Processing...');
                        },
                        complete: function() {
                            $('#registerBtn').prop('disabled', false);
                            $('#registerBtn').text('SIGN UP');
                        },
                        success: function(response) {
                            if (response.includes('verification.php')) {
                                location.href = response;
                            } else if (response.includes('email exist')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ooops...',
                                    text: 'Email already used! Please try another email!',
                                    iconColor: '#000',
                                    confirmButtonColor: '#000',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    color: '#000',
                                    background: '#fe827a',
                                })
                            } else if (response.includes('username exist')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ooops...',
                                    text: 'Username already used! Please try another username!',
                                    iconColor: '#000',
                                    confirmButtonColor: '#000',
                                    showConfirmButton: false,
                                    timer: 3000,
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
                }
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