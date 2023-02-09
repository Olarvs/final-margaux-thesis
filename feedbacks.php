<?php
include './components/head_css.php';
include './components/navbar.php';

?>

<style>
input[type='number'] {
    -moz-appearance: textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

.header-container {
    background: #fe827a !important;
    color: #fff !important;
    padding: 5px 15px;
    border-radius: 3px;
    text-transform: uppercase;
    font-weight: 600;
}

.untree_co-section {
    padding-bottom: 10px !important;
    padding-top: 40px !important;
}
</style>


<!--Start Feedback-->
<div class="container my-5" id="feedbackSection">
    <h2 class="mb-3 text-center" style="font-weight: bold !important; color: #fe827a; letter-spacing: .1rem;">FEEDBACK
    </h2>
    <?php
        $getFeedback = mysqli_query($conn, "SELECT tbl_feedback.rate, tbl_user.`name`, tbl_feedback.`comment`, tbl_user.profile_image
        FROM tbl_feedback
        LEFT JOIN tbl_user
        ON tbl_feedback.userId = tbl_user.user_id");

        if(mysqli_num_rows($getFeedback) < 0) {
        ?>
    <div class="row justify-content-center">
        <p>No feedback available</p>
    </div>
    <?php
        } else {
        ?>
    <div class="row justify-content-center" id="feedbackContainer">
        <?php  
            foreach($getFeedback as $feedback) {
            ?>
        <div class="col-md-4 feedbackCard mb-4">
            <div class="card p-3 h-100">
                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                    <?php 
                    $feedbackCom = '';

                    if($feedback['comment'] != '' || $feedback['comment'] != NULL) {
                        $feedbackCom = '“'.$feedback['comment'].'”';
                    }
                    ?>
                    <p class="text-center"><?= $feedbackCom ?></p>
                    <img src="./assets/images/profile_image/<?= $feedback['profile_image'] ?>" alt=""
                        style="height: 80px; width: 80px; object-fit: cover; border-radius: 50%;">
                    <p><?= $feedback['name'] ?></p>
                    <p
                    <?php 
                    if($feedback['rate'] == 'Amazing'){
                      echo "style='color: #fe827a'";
                    }elseif($feedback['rate'] == 'Good'){
                      echo "style='color: green'";
                    }elseif($feedback['rate'] == 'Fair'){
                      echo "style='color: blue'";
                    }elseif($feedback['rate'] == 'Poor'){
                      echo "style='color: orange'";
                    }elseif($feedback['rate'] == 'Terrible'){
                      echo "style='color: red'";
                    }
                    ?>
                      !important; font-weight: bold; border: 2px solid #fe827a;" id="rate"><?= $feedback['rate'] ?></p>
                </div>
            </div>
        </div>
        <!--color: #fe827a-->
        <?php
            }
            ?>
    </div>
    <?php
    if(mysqli_num_rows($getFeedback) > 3) {
    ?>
    
    <?php
    }
    ?>
  
    <?php 
        } 
        ?>
</div>

<!--End Feedbacks-->
<?php
include './components/footer.php';
include './components/bottom-script.php';
?>