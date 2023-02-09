<?php
include './components/head_css.php';
include './components/navbar.php';

if(!isset($_SESSION['change_pass_email'])) {
    ?>
    <script>
        location.href = 'login.php';
    </script>
    <?php
} else {
    unset($_SESSION['forgot_pass_email']);
    unset($_SESSION['forgot_pass_otp']);
    unset($_SESSION['forgot_pass_time']);
}
?>

<style>
body {
    background-color: #EBDCD5;
    background: url(./assets/images/bgpink.png) no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    height: 100vh;
}

.login {
    max-width: 90%;
    width: 400px;
    border-radius: 5px;
    padding: 10px !important;
    color: aliceblue !important;
}

.password-container {
    position: relative;
}

.password-container input[type="password"],
.password-container input[type="text"] {
    width: 100%;
    padding: 12px 40px 12px 12px;
    box-sizing: border-box;
}

.fa-eye,
.fa-eye-slash {
    position: absolute;
    top: 30%;
    right: 4%;
    cursor: pointer;
    color: gray;
    font-size: 18px;
}
</style>

<!-- Start Contact Form -->
<div class="pt-4 pt-lg-5 pb-4 pb-lg-5">

    <div class="container  bg-dark login pt-1 mb-5">

        <h1 class="text-center p-3 mb-3 rounded" style="color: #fe827a; font-weight: bold;">RESET PASSWORD</h1>
        <form class="px-3 mb-3" id="resetPasswordForm">

            <!-- Password input -->
            <div class="form-outline mb-2">
                <label class="form-label" for="form2Example2">New Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" class="form-control" value="" required />
                    <i class="fa-solid fa-eye" id="eye"></i>
                </div>
                <span class="error error_password" style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-2">
                <label class="form-label" for="form2Example2">Confirm Password</label>
                <div class="password-container">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" value=""
                        required />
                    <i class="fa-solid fa-eye" id="confirm_eye"></i>
                </div>
                <span class="error error_confirm_password"
                    style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn text-dark btn-block mb-2 px-4 w-100" style="background-color: #fe827a;"
                id="resetPasswordBtn">RESET</button>
        </form>

    </div>
</div>

<!-- End Contact Form -->

<script>
$(document).ready(function() {
    // SHOW PASSWORD
    const passwordInput = document.querySelector("#password")
    const eye = document.querySelector("#eye")
    const passwordInputConfirm = document.querySelector("#confirm_password")
    const eyeConfirm = document.querySelector("#confirm_eye")

    eye.addEventListener("click", function() {
        eye.classList.toggle("fa-eye-slash");
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
        passwordInput.setAttribute("type", type);
    })

    eyeConfirm.addEventListener("click", function() {
        eyeConfirm.classList.toggle("fa-eye-slash");
        const type = passwordInputConfirm.getAttribute("type") === "password" ? "text" : "password"
        passwordInputConfirm.setAttribute("type", type);
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

    $('#confirm_password').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexPassword)) {
            $('.error_confirm_password').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! Minimum eight characters, at least one uppercase letter, one lowercase letter and one number.'
            );
            $('#confirm_password').addClass('border-danger');
        } else {
            $('.error_confirm_password').text('');
            $('#confirm_password').removeClass('border-danger');
        }
    })

    // SUBMIT LOGIN
    $('#resetPasswordForm').on('submit', function(e) {
        e.preventDefault();

        if ($('.error_password').text() == '' && $('.error_confirm_password').text() == '') {
            if ($('#password').val() != $('#confirm_password').val()) {
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
                var form = new FormData(this);
                form.append('resetPassword', true);

                $.ajax({
                    type: "POST",
                    url: "./backend/reset-password.php",
                    data: form,
                    dataType: 'text',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#resetPasswordBtn').prop('disabled', true);
                        $('#resetPasswordBtn').text('Processing...');
                    },
                    complete: function() {
                        $('#resetPasswordBtn').prop('disabled', false);
                        $('#resetPasswordBtn').text('RESET');
                    },
                    success: function(response) {
                        if (response.includes('success')) {
                            localStorage.setItem('status', 'changed_pass');
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
        }
    })
})
</script>

<?php
include './components/bottom-script.php';
?>