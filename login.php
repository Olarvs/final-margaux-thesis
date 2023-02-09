<?php
include './components/head_css.php';
include './components/navbar.php';

if(isset($_SESSION['margaux_user_id'])) {
    header('location: index.php');
} else {
    if(isset($_SESSION['verify_email'])) {
        unset($_SESSION['verify_email']);
        unset($_SESSION['otp']);
    }

    if(isset($_SESSION['change_pass_email'])) {
        unset($_SESSION['change_pass_email']);
    }
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

        <h1 class="text-center p-3 mb-3 rounded" style="color: #fe827a; font-weight: bold; letter-spacing: .1rem;">Sign in</h1>
        <form class="px-3 mb-3" id="signin_form">
            <!-- Email input -->
            <div class="form-outline mb-2">
                <label class="form-label" for="form2Example1" style="letter-spacing: .1rem;">Email address</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="<?php if (isset($_COOKIE["margaux_email"])) { echo $_COOKIE["margaux_email"]; } ?>" />
                <span class="error error_email" style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>

            </div>

            <!-- Password input -->
            <div class="form-outline mb-2">
                <label class="form-label" for="form2Example2" style="letter-spacing: .1rem;">Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" class="form-control" value="<?php if ( isset($_COOKIE["margaux_password"])) { echo $_COOKIE["margaux_password"];
            } ?>" />
                    <i class="fa-solid fa-eye" id="eye"></i>
                </div>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form2Example31"
                            <?php if (isset($_COOKIE["margaux_email"]) && isset ($_COOKIE["margaux_password"])) { echo "checked"; } ?>
                            name="rem" />
                        <label class="form-check-label" for="form2Example31">Remember me</label>
                    </div>
                </div>

                <div class="col">
                    <!-- Simple link -->
                    <a style="color: #fe827a;" href="javascript:void(0)" id="forgotPass">Forgot password?</a>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn text-dark btn-block mb-2 px-4 w-100" style="background-color: #fe827a; letter-spacing: .1rem;"
                id="signin_btn">Sign in</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Don't have an account? <a style="color: #fe827a;" href="register.php">Register</a></p>
            </div>
        </form>

    </div>
</div>

<!-- End Contact Form -->

<script>
$(window).on('load', function() {
    if(localStorage.getItem('status') == 'changed_pass') {
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

    // SUBMIT LOGIN
    $('#signin_form').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('login', true);

        $.ajax({
            type: "POST",
            url: "./backend/login.php",
            data: form,
            dataType: 'text',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#signin_btn').prop('disabled', true);
                $('#signin_btn').text('Processing...');
            },
            complete: function() {
                $('#signin_btn').prop('disabled', false);
                $('#signin_btn').text('Sign in');
            },
            success: function(response) {
                if (response.includes('success')) {
                    <?php
                    if(isset($_SESSION['margaux_link_user'])) {
                    ?>
                    location.href = '<?= $_SESSION['margaux_link_user'] ?>';
                    <?php
                    } else {
                    ?>
                    localStorage.setItem('status', 'welcome');
                    location.href = 'index.php';
                    <?php
                    }
                    ?>
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

    $('#forgotPass').on('click', function(e) {
        e.preventDefault();

        if ($.trim($('#email').val()).length == 0) {
            $('.error_email').text('Input email first!');
        } else {
            $('.error_email').text('');
        }

        if ($('.error_email').text().length == 0) {
            var email = $('#email').val();
            var form = new FormData();
            form.append('email', email);
            form.append('forgotPassword', true);

            $.ajax({
                type: "POST",
                url: "./backend/forgot-password.php",
                data: form,
                dataType: "text",
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $('#forgotPass').addClass('d-none');
                },
                complete: function() {
                    $('#forgotPass').removeClass('d-none');
                },
                success: function(response) {
                    if (response.includes('success')) {
                        location.href = 'forgot-password-verification.php';
                    } else if (response.includes('invalid email')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ooops...',
                            text: 'Invalid email!',
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
                }
            })
        }
    })
})
</script>

<?php
include './components/footer.php';
include './components/bottom-script.php';
?>