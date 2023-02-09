<?php
session_start();
require_once '../database/config.php';

if (isset($_POST['get_all_prov'])) {

    $get_all_prov = mysqli_query($conn, "SELECT * FROM refprovince ORDER BY provDesc");

    if (mysqli_num_rows($get_all_prov) != 0) {
        ?>
        <option value="">Select Province</option>
        <?php
        foreach ($get_all_prov as $all_prov) {
            ?>
            <option value="<?php echo $all_prov['provCode'] ?>"><?php echo $all_prov['provDesc']; ?></option>
            <?php
        }
        ?>
        <?php
    }
}

if(isset($_POST['get_all_city'])) {
    $prov_db = $_POST['prov_db'];
    $get_all_city = mysqli_query($conn, "SELECT * FROM refcitymun WHERE provCode = '$prov_db' ORDER BY citymunDesc");

    if (mysqli_num_rows($get_all_city) != 0) {
        ?>
        <option value="">Select City</option>
        <?php
        foreach($get_all_city as $all_city) {
            ?>
            <option value="<?php echo $all_city['citymunCode'] ?>"><?php echo $all_city['citymunDesc']; ?></option>
            <?php
        }
        ?>
        <?php
    }
}

if(isset($_POST['get_all_brgy'])) {
    $city_db = $_POST['city_db'];
    $get_all_brgy = mysqli_query($conn, "SELECT * FROM refbrgy WHERE citymunCode = '$city_db' ORDER BY brgyDesc");

    if (mysqli_num_rows($get_all_brgy) != 0) {
        ?>
        <option value="">Select Barangay</option>
        <?php
        foreach($get_all_brgy as $all_brgy) {
            ?>
            <option value="<?php echo $all_brgy['brgyCode'] ?>"><?php echo $all_brgy['brgyDesc']; ?></option>
            <?php
        }
        ?>
        <?php
    }
}

// ON CHANGE
if (isset($_POST['get_city'])) {
    $province_id = $_POST['province_id'];

    $get_city = mysqli_query($conn, "SELECT * FROM refcitymun WHERE provCode = $province_id ORDER BY citymunDesc");

    if (mysqli_num_rows($get_city) != 0) {
        ?>
        <option value="">Select City</option>
        <?php
        foreach($get_city as $city) {
            ?>
            <option value="<?php echo $city['citymunCode'] ?>"><?php echo $city['citymunDesc']; ?></option>
            <?php
        }
        ?>
        <?php
    }
}

if (isset($_POST['get_barangay'])) {
    $city_id = $_POST['city_id'];

    $get_barangay = mysqli_query($conn, "SELECT * FROM refbrgy WHERE citymunCode = $city_id ORDER BY brgyDesc");

    if (mysqli_num_rows($get_barangay) != 0) {
        ?>
        <option value="">Select Barangay</option>
        <?php
        foreach($get_barangay as $barangay) {
            ?>
            <option value="<?php echo $barangay['brgyCode'] ?>"><?php echo $barangay['brgyDesc']; ?></option>
            <?php
        }
        ?>
        <?php
    }
}