<?php
include './components/head_css.php';
include './components/navbar.php';

if(!isset($_SESSION['verify_email'])) {
    header('location: register.php');
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

.custom_btn {
    background-color: #fe827a !important;
    border-color: #fe827a !important;
}

.custom_btn:hover {
    background-color: #b75c56 !important;
    border-color: #b75c56 !important;
}
</style>

<!-- Start Contact Form -->
<div class="pt-4 pt-lg-5 pb-4 pb-lg-5">

    <div class="container  bg-dark login pt-1 mb-5">

        <h1 class="text-center p-3 mb-3 rounded" style="color: #fe827a; font-weight: bold;">VERIFICATION</h1>
        <form class="px-3 mb-3" id="verify_form">
            <!-- Email input -->
            <div class="form-outline mb-2">
                <label class="form-label" for="form2Example1">Email address</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="<?= $_SESSION['verify_email']; ?>" readonly />

            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="otp">Verification Code</label>
                <input type="tel" id="otp" name="otp" minlength="6" maxlength="6" class="form-control" />
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn text-dark btn-block mb-2 px-4 w-100 custom_btn"
                id="verify_btn">VERIFY</button>
        </form>

    </div>
</div>

<!-- End Contact Form -->

<script>
$(document).ready(function() {
    // SUBMIT VERIFICATION
    $('#verify_form').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('verify', true);

        $.ajax({
            type: "POST",
            url: "./backend/verification.php",
            data: form,
            dataType: 'text',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#verify_btn').prop('disabled', true);
                $('#verify_btn').text('Processing...');
            },
            complete: function() {
                $('#verify_btn').prop('disabled', false);
                $('#verify_btn').text('VERIFY');
            },
            success: function(response) {
                if (response.includes('success')) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Verified successfully! You can now login.',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: true,
                        color: '#000',
                        background: '#fe827a',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = 'login.php'
                        }
                    })
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
                } else if (response.includes('expired')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops...',
                        text: 'Verification Code expired! Please try again.',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: true,
                        color: '#000',
                        background: '#fe827a',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = 'register.php'
                        }
                    })
                } else if (response.includes('invalid otp')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops...',
                        text: 'Invalid verification code!',
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
})
</script>

<?php
include './components/bottom-script.php';
?>