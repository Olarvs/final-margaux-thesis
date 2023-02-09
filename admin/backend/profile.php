<?php
session_start();
require_once '../../database/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require_once '../../vendor/autoload.php';

if (isset($_POST['update_profile_details'])) {
    $mail = new PHPMAILER(true);
    $admin_id = $_SESSION['margaux_admin_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $new_pass = $_POST['new_pass'] ?? null;
    $new_pass_hashed = md5($new_pass);

    $admin_update_profile_array = array();

    $admin_update_profile_array['admin_id'] = $admin_id;
    $admin_update_profile_array['name'] = $name;
    $admin_update_profile_array['email'] = $email;
    $admin_update_profile_array['username'] = $username;
    $admin_update_profile_array['new_pass'] = $new_pass;
    $admin_update_profile_array['new_pass_hashed'] = $new_pass_hashed;

    $get_account = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE adminId = $admin_id");

    $row = mysqli_fetch_array($get_account);

    $check_email = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE email = '$email' AND adminId != $admin_id AND isVerified = 1");

    if (mysqli_num_rows($check_email) > 0) {
        echo 'email already used';
    } else {
        $checkUsername = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username = '$username' AND adminId != $admin_id");

        if (mysqli_num_rows($checkUsername) > 0) {
            echo 'username exist';
        } else {
            //Enable verbose debug output
            $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

            //Send using SMTP
            $mail->isSMTP();

            //Set the SMTP server to send through
            $mail->Host = 'smtp.gmail.com';

            //Enable SMTP authentication
            $mail->SMTPAuth = true;

            //SMTP username
            $mail->Username = 'margauxcscorner@gmail.com';

            //SMTP password
            $mail->Password = 'uqapxrlzstgpgjkq';
            //old djfkzhifoquvycgz
            //new uqapxrlzstgpgjkq

            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

            //Add a recipient
            $mail->addAddress($email, $name);

            //Set email format to HTML
            $mail->isHTML(true);

            $otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $mail->Subject = 'Email verification';
            $mail->Body = '<p>Your One-Time pin is: <b style="font-size: 30px;">' . $otp . '. </b>Please enter this code within 3 minutes</p><p>Incase you didn\'t request for an OTP, simply ignore this message.</p><p>Have a wonderful day!</p><p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

            $mail->send();
            $_SESSION['admin_update_profile_array'] = json_encode($admin_update_profile_array);
            $_SESSION['admin_update_email'] = $email;
            $_SESSION['admin_otp'] = $otp;
            $_SESSION['admin_time'] = $_SERVER['REQUEST_TIME'];
            echo 'success';
            exit();
        }
    }
}

if (isset($_POST['delete_image'])) {
    $admin_id = $_SESSION['margaux_admin_id'];
    $old_image = $_POST['old_profile'];

    $update_image = mysqli_query($conn, "UPDATE tbl_admin SET profile_image = 'profile.png' WHERE adminId = $admin_id");

    if ($update_image) {
        if (file_exists('../assets/img/profileImage/' . $old_image)) {
            unlink('../assets/img/profileImage/' . $old_image);
        }
        echo 'success';
    }
}

if (isset($_POST['update_profile_picture'])) {
    $image = $_FILES['profile_image']['name'];
    $image_tmp = $_FILES['profile_image']['tmp_name'];
    $old_image = $_POST['old_profile_pic'] ?? null;
    $admin_id = $_SESSION['margaux_admin_id'];

    $image_ext = explode('.', $image);
    $image_ext = strtolower(end($image_ext));

    $new_image_name = uniqid() . '.' . $image_ext;
    move_uploaded_file($image_tmp, '../assets/images/profileImage/' . $new_image_name);

    $update_profile = mysqli_query($conn, "UPDATE tbl_admin SET profile_image = '$new_image_name' WHERE adminId = $admin_id");

    if ($update_profile) {
        if ($old_image != 'profile.png') {
            if (file_exists('../assets/images/profileImage/' . $old_image)) {
                unlink('../assets/images/profileImage/' . $old_image);
            }
        }
        echo 'success';
    }
}
