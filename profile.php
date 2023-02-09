<?php
include './components/head_css.php';
include './components/navbar.php';

if(!isset($_SESSION['margaux_user_id'])) {
    $_SESSION["margaux_link_user"] = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    header('location: login.php');
} else {
    unset($_SESSION['update_profile_array']);
    unset($_SESSION['update_email']);
    unset($_SESSION['otp']);
    unset($_SESSION['time']);
    $user_id = $_SESSION['margaux_user_id'];
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

.custom_cont {
    max-width: 90%;
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

<input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['margaux_user_id'] ?>">

<!-- Start Contact Form -->
<div class="pt-4 pt-lg-5 pb-4 pb-lg-5">
    <div class="container">

        <div class="block">
            <div class="row justify-content-center">


                <div class="col-md-12 col-lg-12 p-4 bg-dark text-white rounded custom_cont">
                    <?php
                    $get_user_info = mysqli_query($conn, "SELECT * FROM tbl_user WHERE user_id = $user_id");

                    $gender = '';

                    foreach($get_user_info as $row) {
                    $gender = $row['gender'];
                    ?>
                    <input class="form-control mb-2" style="height: unset;" type="hidden" id="old_profile_pic"
                        name="old_profile_pic" value="<?= $row['profile_image'] ?>">
                    <form id="profile_update">
                        <div class="row">
                            <div class="col-lg-4 border-right">
                                <div class="d-flex flex-column align-items-center text-center mb-3 ">
                                    <img style="object-fit: cover;" class="rounded-circle mt-2 mt-lg-5" width="150px"
                                        height="150px" src="./assets/images/profile_image/<?= $row['profile_image'] ?>">
                                    <span class="font-weight-bold" style="letter-spacing: .1rem;"><?= $row['name'] ?></span>
                                    <span class="text-white-50" style="letter-spacing: .1rem;"><?= $row['email'] ?></span>
                                    <?php
                                    if($row['profile_image'] != 'profile.png') {
                                    ?>
                                    <button type="button" class="btn btn-danger mb-2"
                                        style="padding: 3px 8px; font-size: 13px; letter-spacing: .1rem;"
                                        id="remove_profile_image">Remove</button>
                                    <?php
                                    }
                                    ?>
                                    <input class="form-control mb-2" style="height: unset;" type="file"
                                        id="profile_image">
                                    <span class="error error_image"
                                        style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                    <button type="button" class="btn btn-primary mb-2"
                                        style="padding: 3px 8px; font-size: 13px; color: #000; letter-spacing: .1rem;"
                                        id="update_image">Update</button>
                                </div>
                            </div>
                            <div class="col-lg-4 border-right">
                                <div class="px-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="text-right" style="letter-spacing: .1rem;">Profile Settings</h4>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12"><label class="labels" style="letter-spacing: .1rem;">Name</label><input type="text"
                                                class="form-control" placeholder="Name" value="<?= $row['name'] ?>"
                                                id="name" name="name" required>
                                            <span class="error error_name"
                                                style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="labels" style="letter-spacing: .1rem;">Birthday</label>
                                            <input type="date" class="form-control" value="<?= $row['birthday'] ?>"
                                                id="birthday" name="birthday" required>
                                            <span class="error error_birthday"
                                                style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                        </div>
                                        <div class="col-md-12"><label class="labels" style="letter-spacing: .1rem;">Sex</label>
                                            <select class="form-select form-control" id="gender" name="gender">
                                                <option value="Female">Female</option>
                                                <option value="Male">Male</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12"><label class="labels" style="letter-spacing: .1rem;">Province</label>
                                            <select class="form-select form-control" id="province"
                                                style="font-size: 14px;">
                                            </select>
                                            <input class="form-control" type="hidden" name="provinceValue"
                                                id="provinceValue" value="<?php echo $row['province']; ?>">
                                        </div>
                                        <div class="col-md-12"><label class="labels" style="letter-spacing: .1rem;">City</label>
                                            <select class="form-select form-control" id="city" style="font-size: 14px;">
                                            </select>
                                            <input class="form-control" type="hidden" name="cityValue" id="cityValue"
                                                value="<?php echo $row['city']; ?>">
                                        </div>
                                        <div class="col-md-12"><label class="labels" style="letter-spacing: .1rem;">Barangay</label>
                                            <select class="form-select form-control" id="barangay"
                                                style="font-size: 14px;">
                                            </select>
                                            <input class="form-control" type="hidden" name="barangayValue"
                                                id="barangayValue" value="<?php echo $row['barangay']; ?>">
                                        </div>
                                        <div class="col-md-12"><label class="labels" style="letter-spacing: .1rem;">Blk/Lot/Street/Floor
                                                No.</label><input type="text" class="form-control"
                                                placeholder="Enter block address" value="<?php echo $row['block']; ?>"
                                                id="block" name="block"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="px-3">
                                    <div class="d-none d-lg-flex justify-content-between align-items-center mb-3">
                                        <h4 class="text-right invisible" style="letter-spacing: .1rem;">Profile Settings</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="labels" style="letter-spacing: .1rem;">Email address</label>
                                        <input type="email" class="form-control" placeholder="Enter email address"
                                            value="<?= $row['email'] ?>" id="email" name="email" required>
                                        <span class="error error_email"
                                            style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label mb-0" for="username" style="letter-spacing: .1rem;">Mobile number</label>
                                        <div class="input-group input-group-merge">
                                            <span style="font-size: 14px;" class="input-group-text">+63</span>
                                            <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control"
                                                value="<?= $row['mobile_no'] ?>" placeholder="9992736514" required />
                                        </div>
                                        <span class="error error_phoneNumber"
                                            style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                    </div>
                                    <!-- <div class="col-md-12 "><label class="labels">Old Password</label><input type="text"
                                            class="form-control" placeholder="Old Password" value=""></div> -->
                                    <div class="col-md-12">
                                        <label class="labels" style="letter-spacing: .1rem;">New password</label>
                                        <div class="password-container">
                                            <input type="password" class="form-control" placeholder="New Password"
                                                value="" id="new_pass" name="new_pass">
                                            <i class="fa-solid fa-eye" id="eye"></i>
                                        </div>
                                        <span class="error error_new_pass"
                                            style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                    </div>
                                    <div class="col-md-12"><label class="labels" style="letter-spacing: .1rem;">Confirm new password</label>
                                        <div class="password-container">
                                            <input type="password" class="form-control"
                                                placeholder="Repeat New Password" id="c_pass" name="c_pass" value="">
                                            <i class="fa-solid fa-eye" id="confirmEye"></i>
                                        </div>
                                        <span class="error error_c_pass"
                                            style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                    </div>
                                    <div class="mt-5 text-center">
                                        <button class="btn btn-primary text-dark profile-button" type="submit"
                                            id="profile_update_btn" style="letter-spacing: .1rem;">Save
                                            Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>


    </div>

</div>

<script>
$(window).on('load', function() {
    // ALERTS
    if (localStorage.getItem('status') == 'profile_updated') {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Profile updated successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            color: '#000',
            background: '#fe827a',
        })
        localStorage.removeItem('status');
    } else if (localStorage.getItem('status') == 'image_updated') {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Profile image updated successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            color: '#000',
            background: '#fe827a',
        })
        localStorage.removeItem('status');
    } else if (localStorage.getItem('status') == 'delete_image') {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Profile image deleted successfully!',
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
    // GET ADDRESS
    var province_value = $('#provinceValue').val();
    var city_value = $('#cityValue').val();
    var barangay_value = $('#barangayValue').val();

    $.ajax({
        url: "./backend/get-address.php",
        type: "POST",
        data: {
            get_all_prov: true,
        },
        success: function(data) {
            $('#province').html(data);
            if (province_value == '' || province_value == null) {
                $('#city').attr('disabled', true);
                $('#barangay').attr('disabled', true);
                $('#block').attr('disabled', true);
                $('#province').val('');
            } else {
                $('#province').val(province_value);
                $('#city').attr('disabled', false);
            }
        }
    })

    if (province_value == '') {
        var data = '<option value="">Select Province First</option>';
        $('#city').html(data);
    } else {
        $.ajax({
            url: "./backend/get-address.php",
            type: "POST",
            data: {
                prov_db: province_value,
                get_all_city: true,
            },
            success: function(data) {
                $('#city').html(data);
                if (city_value == '' || city_value == null) {
                    $('#city').attr('disabled', false);
                    $('#barangay').attr('disabled', true);
                    $('#block').attr('disabled', true);
                    $('#city').val('');
                } else {
                    $('#city').val(city_value);
                }
            }
        })
    }

    if (city_value == '') {
        var data = '<option value="">Select Province First</option>';
        $('#barangay').html(data);
    } else {
        $.ajax({
            url: "./backend/get-address.php",
            type: "POST",
            data: {
                city_db: city_value,
                get_all_brgy: true,
            },
            success: function(data) {
                $('#barangay').html(data);
                if (barangay_value == '' || barangay_value == null) {
                    $('#city').attr('disabled', false);
                    $('#barangay').attr('disabled', false);
                    $('#block').attr('disabled', true);
                    $('#barangay').val('');
                } else {
                    $('#barangay').val(barangay_value);
                }
            }
        })
    }
})

$(document).ready(function() {
    // SHOW PASSWORD
    const passwordInput = document.querySelector("#new_pass")
    const eye = document.querySelector("#eye")
    const passwordInputConfirm = document.querySelector("#c_pass")
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

    // GET GENDER
    $("#gender").val("<?= $gender ?>").attr("selected", "selected");

    // GET CITY
    $("#province").change(function() {
        if ($(this).val() == '') {
            $('#provinceValue').val('');
            $('#cityValue').val('');
            $('#barangayValue').val('');
            $('#city').val('');
            $('#barangay').val('');
            $('#block').val('');
            $('#city').attr('disabled', true);
            $('#barangay').attr('disabled', true);
            $('#block').attr('disabled', true);
        } else {
            $('#provinceValue').val($(this).val());
            $('#barangay').val('');
            $('#cityValue').val('');
            $('#block').val('');
            $('#barangayValue').val('');
            $('#city').attr("disabled", false);
            $('#barangay').attr('disabled', true);
            $('#block').attr('disabled', true);
            var province_id = $(this).val();
            $.ajax({
                url: "./backend/get-address.php",
                type: "POST",
                data: {
                    province_id: province_id,
                    get_city: true,
                },
                success: function(data) {
                    $('#city').html(data);
                }
            })
        }
    })

    // GET BARANGAY
    $("#city").change(function() {
        if ($(this).val() == '') {
            $('#cityValue').val('');
            $('#barangayValue').val('');
            $('#barangay').val('');
            $('#block').val('');
            $('#city').attr('disabled', false);
            $('#barangay').attr('disabled', true);
            $('#block').attr('disabled', true);
        } else {
            $('#cityValue').val($(this).val());
            $('#barangayValue').val('');
            $('#city').attr("disabled", false);
            $('#barangay').attr('disabled', false);
            $('#block').attr('disabled', true);
            var city_id = $(this).val();
            console.log(city_id);
            $.ajax({
                url: "./backend/get-address.php",
                type: "POST",
                data: {
                    city_id: city_id,
                    get_barangay: true,
                },
                success: function(data) {
                    $('#barangay').html(data);
                }
            })
        }
    })

    $('#barangay').change(function() {
        if ($(this).val() == '') {
            $('#barangayValue').val('');
            $('#block').val('');
            $('#city').attr('disabled', false);
            $('#barangay').attr('disabled', false);
            $('#block').attr('disabled', true);
        } else {
            $('#barangayValue').val($(this).val());
            $('#block').attr("disabled", false);
        }
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

    $('#new_pass').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexPassword)) {
            $('.error_new_pass').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! Minimum eight characters, at least one uppercase letter, one lowercase letter and one number.'
            );
            $('#new_pass').addClass('border-danger');
        } else {
            $('.error_new_pass').text('');
            $('#new_pass').removeClass('border-danger');
        }
    })

    $('#c_pass').on('keypress keydown keyup', function() {
        if (!$.trim($(this).val()).match($regexPassword)) {
            $('.error_c_pass').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Invalid format! Minimum eight characters, at least one uppercase letter, one lowercase letter and one number.'
            );
            $('#c_pass').addClass('border-danger');
        } else {
            $('.error_c_pass').text('');
            $('#c_pass').removeClass('border-danger');
        }
    })

    // UPDATE PROFILE
    $('#profile_update').on('submit', function(e) {
        e.preventDefault();

        var get_form = $('#profile_update')[0];

        if ($('#new_pass').val().length != 0) {
            if ($('#c_pass').val().length == 0) {
                $('#c_pass').prop('required', true);
            } else {
                if ($('#new_pass').val() != $('#c_pass').val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Password confirmation does not match!',
                    });
                } else {
                    var user_id = $('#user_id').val();
                    var form = new FormData(get_form);
                    form.append('update_profile_details', true);
                    form.append('user_id', user_id);

                    $.ajax({
                        url: "./backend/profile.php",
                        type: "POST",
                        data: form,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#profile_update_btn').prop('disabled', true);
                            $('#profile_update_btn').text('Processing...');
                        },
                        complete: function() {
                            $('#profile_update_btn').prop('disabled', false);
                            $('#profile_update_btn').text('Save Profile');
                        },
                        success: function(response) {
                            if (response.includes('wrong password')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ooops...',
                                    text: 'Incorrect password!',
                                    iconColor: '#000',
                                    confirmButtonColor: '#000',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    color: '#000',
                                    background: '#fe827a',
                                })
                            } else if (response.includes('email already used')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ooops...',
                                    text: 'Email already used!',
                                    iconColor: '#000',
                                    confirmButtonColor: '#000',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    color: '#000',
                                    background: '#fe827a',
                                })
                            } else if (response.includes('success')) {
                                location.href = 'profile-verification.php';
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: 'Something went wrong!',
                                });
                            }
                            console.log(response);
                        }
                    })
                }
            }
        } else {
            $('#c_pass').prop('required', false);
            var user_id = $('#user_id').val();
            var form = new FormData(get_form);
            form.append('update_profile_details', true);
            form.append('user_id', user_id);

            $.ajax({
                url: "./backend/profile.php",
                type: "POST",
                data: form,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#profile_update_btn').prop('disabled', true);
                    $('#profile_update_btn').text('Processing...');
                },
                complete: function() {
                    $('#profile_update_btn').prop('disabled', false);
                    $('#profile_update_btn').text('Save Profile');
                },
                success: function(response) {
                    if (response.includes('email already used')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ooops...',
                            text: 'Email already used!',
                            iconColor: '#000',
                            confirmButtonColor: '#000',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            color: '#000',
                            background: '#fe827a',
                        })
                    } else if (response.includes('success')) {
                        location.href = 'profile-verification.php';
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

    // REMOVE PROFILE
    $('#remove_profile_image').on('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure you want to remove your profile image?',
            iconColor: '#000',
            confirmButtonColor: '#000',
            cancelButtonColor: '#d9534f',
            showConfirmButton: true,
            color: '#000',
            background: '#fe827a',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                var old_image = $('#old_profile_pic').val();
                var user_id = $('#user_id').val();

                $.ajax({
                    type: "POST",
                    url: "./backend/profile.php",
                    data: {
                        'delete_image': true,
                        'user_id': user_id,
                        'old_profile': old_image,
                    },
                    success: function(response) {
                        if (response.includes('success')) {
                            localStorage.setItem('status', 'delete_image');
                            location.reload();
                        }
                        console.log(response);
                    }
                })
            }
        })
    })

    // Update Image
    $('#update_image').on('click', function(e) {
        e.preventDefault();

        if ($('#profile_image').val() == '') {
            $('.error_image').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Upload image first!'
            );
        } else {
            var user_id = $('#user_id').val();
            var profile_image = $('#profile_image').val();
            var image_ext = $('#profile_image').val().split('.').pop().toLowerCase();

            if ($.inArray(image_ext, ['png', 'jpg', 'jpeg']) == -1) {
                $('.error_image').html(
                    '<i class="bi bi-exclamation-circle-fill"></i> File not supported!'
                );
            } else {
                var imageSize = $('#profile_image')[0].files[0].size;

                if (imageSize > 10485760) {
                    $('.error_image').html(
                        '<i class="bi bi-exclamation-circle-fill"></i> File too large!'
                    );
                } else {
                    var old_profile_pic = $('#old_profile_pic').val();
                    var profile_image = $('#profile_image').prop("files")[0];
                    var user_id = $('#user_id').val();

                    var form = new FormData();
                    form.append('update_profile_picture', true);
                    form.append('old_profile_pic', old_profile_pic);
                    form.append('profile_image', profile_image);
                    form.append('user_id', user_id);
                    $.ajax({
                        url: "./backend/profile.php",
                        type: "POST",
                        data: form,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.includes('success')) {
                                localStorage.setItem('status', 'image_updated');
                                location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: 'Something went wrong!',
                                    iconColor: '#000',
                                    confirmButtonColor: '#000',
                                    showConfirmButton: false,
                                    color: '#000',
                                    background: '#fe827a',
                                    timer: 5000,
                                    timerProgressBar: true,
                                });
                            }
                            console.log(response);
                        }
                    })
                }
            }
        }
    })
})
</script>

<?php
include './components/footer.php';
include './components/bottom-script.php';
?>