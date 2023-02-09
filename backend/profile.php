<?php
session_start();
require_once '../database/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/autoload.php';

if (isset($_POST['update_profile_details'])) {
    $mail = new PHPMAILER(true);
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $provinceValue = $_POST['provinceValue'] ?? null;
    $cityValue = $_POST['cityValue'] ?? null;
    $barangayValue = $_POST['barangayValue'] ?? null;
    $block = $_POST['block'] ?? null;
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $new_pass = $_POST['new_pass'] ?? null;
    $new_pass_hashed = md5($new_pass);

    $update_profile_array = array();

    $update_profile_array['user_id'] = $user_id;
    $update_profile_array['name'] = $name;
    $update_profile_array['birthday'] = $birthday;
    $update_profile_array['gender'] = $gender;
    $update_profile_array['provinceValue'] = $provinceValue;
    $update_profile_array['cityValue'] = $cityValue;
    $update_profile_array['barangayValue'] = $barangayValue;
    $update_profile_array['block'] = $block;
    $update_profile_array['email'] = $email;
    $update_profile_array['phoneNumber'] = $phoneNumber;
    $update_profile_array['new_pass'] = $new_pass;
    $update_profile_array['new_pass_hashed'] = $new_pass_hashed;

    $get_account = mysqli_query($conn, "SELECT * FROM tbl_user WHERE user_id = $user_id");

    $row = mysqli_fetch_array($get_account);

    $check_email = mysqli_query($conn, "SELECT * FROM tbl_user WHERE email = '$email' AND user_id != $user_id AND verified = 'VERIFIED'");

    if (mysqli_num_rows($check_email) > 0) {
        echo 'email already used';
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
        $_SESSION['update_profile_array'] = json_encode($update_profile_array);
        $_SESSION['update_email'] = $email;
        $_SESSION['otp'] = $otp;
        $_SESSION['time'] = $_SERVER['REQUEST_TIME'];
        echo 'success';
        exit();
    }

}

if (isset($_POST['delete_image'])) {
    $user_id = $_POST['user_id'];
    $old_image = $_POST['old_profile'];

    $update_image = mysqli_query($conn, "UPDATE tbl_user SET profile_image = 'profile.png' WHERE user_id = $user_id");

    if ($update_image) {
        if (file_exists('../assets/img/profile_image/' . $old_image)) {
            unlink('../assets/img/profile_image/' . $old_image);
        }
        echo 'success';
    }
}

if (isset($_POST['update_profile_picture'])) {
    $image = $_FILES['profile_image']['name'];
    $image_tmp = $_FILES['profile_image']['tmp_name'];
    $old_image = $_POST['old_profile_pic'] ?? null;
    $user_id = $_POST['user_id'];

    $image_ext = explode('.', $image);
    $image_ext = strtolower(end($image_ext));

    $new_image_name = uniqid() . '.' . $image_ext;
    move_uploaded_file($image_tmp, '../assets/images/profile_image/' . $new_image_name);

    $update_profile = mysqli_query($conn, "UPDATE tbl_user SET profile_image = '$new_image_name' WHERE user_id = $user_id");

    if ($update_profile) {
        if ($old_image != 'profile.png') {
            if (file_exists('../assets/images/profile_image/' . $old_image)) {
                unlink('../assets/images/profile_image/' . $old_image);
            }
        }
        echo 'success';
    }
}