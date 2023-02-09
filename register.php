<?php
include './components/head_css.php';
include './components/navbar.php';

if(isset($_SESSION['margaux_user_id'])) {
    ?>
    <script>
        location.href = 'index.php';
    </script>
    <?php
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
    width: 800px;
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

    <div class="container bg-dark login pt-1 mb-5">

        <h1 class="text-center p-3 mb-3 rounded" style="color: #fe827a; font-weight: bold; letter-spacing: .1rem;">Create account</h1>
        <form class="p-3" id="register_form">
            <div class="row form-group">
                <div class="col-md-12">
                    <!-- Email input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="name" style="letter-spacing: .1rem;">Full name</label>
                        <input type="text" id="name" name="name" class="form-control" required />
                    </div>
                    <span class="error error_name" style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-6">
                    <!-- Email input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="email" style="letter-spacing: .1rem;">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" />
                    </div>
                    <span class="error error_email" style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
                </div>

                <div class="col-md-6">
                    <div class="form-outline mb-2">
                        <label class="form-label" for="username" style="letter-spacing: .1rem;">Mobile number</label>
                        <div class="input-group input-group-merge">
                            <span style="font-size: 14px;" class="input-group-text">+63</span>
                            <input type="tel" id="phoneNumber" pattern="[9]{1}[0-9]{2}[0-9]{3}[0-9]{4}" name="phoneNumber" class="form-control"
                                placeholder="9123456789" required />
                        </div>
                    </div>
                    <span class="error error_phoneNumber"
                        style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-6">
                    <!-- Email input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="gender" style="letter-spacing: .1rem;">Sex</label>
                        <select class="form-select form-control" aria-label="Default select example" id="gender"
                            name="gender">
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-outline mb-2">
                        <label class="form-label" for="birthday" style="letter-spacing: .1rem;">Birthdate</label>
                        <input type="date" name="birthday" id="birthday" class="form-control" />
                    </div>
                    <span class="error error_birthday" style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
                </div>
            </div>

            <div class="row form-group mb-3">
                <div class="col-md-6">
                    <!-- Email input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="password" style="letter-spacing: .1rem;">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" class="form-control" />
                            <i class="fa-solid fa-eye" id="eye"></i>
                        </div>
                    </div>
                    <span class="error error_password"
                        style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
                </div>

                <div class="col-md-6">
                    <!-- Password input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="confirmPassword" style="letter-spacing: .1rem;">Confirm password</label>
                        <div class="password-container">
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" />
                            <i class="fa-solid fa-eye" id="confirmEye"></i>
                        </div>
                    </div>
                    <span class="error error_confirmPassword"
                        style="font-size: 14px; font-weight: 500; color: #fe827a;"></span>
                </div>
            </div>
            
            <!-- Terms & Conditions and Privacy Policy -->
            <p>By creating an account or signing in, I agree to the processing of my personal data in agreement with the <a class="text-white" href="https://www.freeprivacypolicy.com/live/e7fa3eb1-d047-4000-9c82-f3c48165ed77"><b>Privacy Policy</b></a> and <a class="text-white" href="https://www.termsandconditionsgenerator.com/live.php?token=ZrhJWwMIvM69MsnbtomYADL6C8WKcK1M"><b>Terms & Conditions</b></a>.</p>

            <!-- Submit button -->
            
            <button type="submit" class="btn text-dark btn-block mb-2 mt-2 px-4 w-100"
                style="background-color: #fe827a; letter-spacing: .1rem;" id="signup_btn">Create</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Already have an account? <a style="color: #fe827a;" href="login.php">Login now</a></p>
            </div>
        </form>

    </div>
</div>

<!-- End Contact Form -->

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

    var $regexPhoneNumber = /^9\d{9}$/;

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

    $('#phoneNumber').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexPhoneNumber)) {
            $('.error_phoneNumber').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! Must start with 9 and has 10 numbers.'
            );
            $('#phoneNumber').addClass('border-danger');
        } else {
            $('.error_phoneNumber').text('');
            $('#phoneNumber').removeClass('border-danger');
        }
    })

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

    $('#confirmPassword').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexPassword)) {
            $('.error_confirmPassword').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! Minimum eight characters, at least one uppercase letter, one lowercase letter and one number.'
            );
            $('#confirmPassword').addClass('border-danger');
        } else {
            $('.error_confirmPassword').text('');
            $('#confirmPassword').removeClass('border-danger');
        }
    })

    // SUBMIT REGISTER
    $('#register_form').on('submit', function(e) {
        e.preventDefault();

        var birthday = $('#birthday').val();
        d = new Date(birthday.split("/").reverse().join("-"))
        var curDate = new Date();

        curDate.setYear(curDate.getFullYear() - 18);
        if (curDate >= d) {
            $('.error_birthday').html('');

            if($.trim($('#password').val()) != $.trim($('#confirmPassword').val())) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
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
                var get_form = $('#register_form')[0];
                var form = new FormData(get_form);
                form.append('register', true);

                $.ajax({
                    type: "POST",
                    url: "./backend/register.php",
                    data: form,
                    dataType: 'text',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#signup_btn').prop('disabled', true);
                        $('#signup_btn').text('Processing...');
                    },
                    complete: function() {
                        $('#signup_btn').prop('disabled', false);
                        $('#signup_btn').text('Sign up');
                    },
                    success: function(response) {
                        if(response.includes('verification.php')) {
                            location.href = response;
                        } else if(response.includes('email already used')) {
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
        } else {
            $('.error_birthday').html(
                '<i class="bi bi-exclamation-circle-fill"></i> You must be atleast 18 years old!'
            );
        }

    })
})
</script>

<?php
include './components/footer.php';
include './components/bottom-script.php';
?>