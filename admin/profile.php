<?php 
include './components/head_css.php'; 
include './components/navbar_sidebar.php'; 

$adminId = $_SESSION['margaux_admin_id'];
?>

<style>
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

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="mr-md-3 mr-xl-5 p-0">
                            <h2>Profile Settings</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">Profile Settings</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $getAdminInfo = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE adminId = $adminId");

        foreach($getAdminInfo as $row) {
        ?>
        <div class="row">
            <div class="col-md-12 grid-margin bg-light shadow-sm">
                <div class="block">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <input class="form-control mb-2" style="height: unset;" type="hidden" id="old_profile_pic"
                                name="old_profile_pic" value="">
                            <form id="profile_update">
                                <div class="row">
                                    <div class="col-md-3 border-right">
                                        <div class="d-flex flex-column align-items-center text-center mb-3 ">
                                            <img style="object-fit: cover;" class="rounded-circle mt-2 mt-lg-5"
                                                width="150px" height="150px"
                                                src="./assets/images/profileImage/<?= $row['profile_image'] ?>">
                                            <span class="font-weight-bold"><?= $row['name'] ?></span>
                                            <span class="text-dark-50"><?= $row['email'] ?></span>
                                            <?php
                                            if($row['profile_image'] != 'profile.png') {
                                            ?>
                                            <button type="button" class="btn btn-danger mb-2"
                                                style="padding: 3px 8px; font-size: 13px;"
                                                id="remove_profile_image">Remove</button>
                                            <?php
                                            }
                                            ?>
                                            <input class="form-control mb-2" style="height: unset;" type="hidden"
                                                id="old_profile_pic" name="old_profile_pic"
                                                value="<?= $row['profile_image'] ?>">
                                            <input class="form-control mb-2" style="height: unset;" type="file"
                                                id="profile_image">
                                            <span class="error error_image"
                                                style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                            <button type="button" class="btn btn-primary mb-2"
                                                style="padding: 3px 8px; font-size: 13px; color: #000;"
                                                id="update_image">Update</button>
                                        </div>
                                    </div>
                                    <div class="col-md-9 border-right">
                                        <div class="px-3 pt-md-5 pb-md-3">
                                            <div class="row mt-2">
                                                <div class="col-md-6"><label class="labels">Name</label><input
                                                        type="text" class="form-control" placeholder="Name"
                                                        value="<?= $row['name'] ?>" id="name" name="name" required>
                                                    <span class="error error_name"
                                                        style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="labels">Username</label>
                                                    <input type="text" class="form-control"
                                                        value="<?= $row['username'] ?>" id="username" name="username"
                                                        required>
                                                    <span class="error error_username"
                                                        style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <label class="labels">Email</label>
                                                    <input type="email" class="form-control"
                                                        value="<?= $row['email'] ?>" id="email" name="email" required>
                                                    <span class="error error_email"
                                                        style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label class="labels">New Password</label>
                                                    <input type="password" class="form-control" value="" id="new_pass"
                                                        name="new_pass">
                                                    <span class="error error_new_pass"
                                                        style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="labels">Confirm Password</label>
                                                    <input type="password" class="form-control" value="" id="c_pass"
                                                        name="c_pass">
                                                    <span class="error error_c_pass"
                                                        style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                                                </div>
                                            </div>

                                            <div class="mt-5 text-center">
                                                <button class="btn btn-primary text-dark profile-button" type="submit"
                                                    id="profile_update_btn">Save
                                                    Profile</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->

<script>
$(window).on('load', function() {
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
})
$(document).ready(function() {
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

    // Update Image
    $('#update_image').on('click', function(e) {
        e.preventDefault();

        if ($('#profile_image').val() == '') {
            $('.error_image').html(
                '<i class="bi bi-exclamation-circle-fill"></i> Upload image first!'
            );
        } else {
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

                    var form = new FormData();
                    form.append('update_profile_picture', true);
                    form.append('old_profile_pic', old_profile_pic);
                    form.append('profile_image', profile_image);
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

                $.ajax({
                    type: "POST",
                    url: "./backend/profile.php",
                    data: {
                        'delete_image': true,
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
                                    title: 'Failed',
                                    text: 'Incorrect password!',
                                });
                            } else if (response.includes('email already used')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: 'Email already used!',
                                });
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
            var form = new FormData(get_form);
            form.append('update_profile_details', true);

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
                    } else if (response.includes('username exist')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ooops...',
                            text: 'Username already used!',
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
    })
})
</script>

<?php
include './components/bottom.php';
?>