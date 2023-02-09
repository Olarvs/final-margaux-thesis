<?php
include './components/head_css.php';

if(!isset($_SESSION['margaux_user_id'])) {
    ?>
<script>
location.href = 'login.php';
</script>
<?php
} else {
    if(!isset($_GET['id'])) {
        ?>
<script>
location.href = 'order-history.php';
</script>
<?php
    } else {
        $userId = $_SESSION['margaux_user_id'];
        $orderId = $_GET['id'];

        $check = mysqli_query($conn, "SELECT * FROM tbl_order WHERE userId = $userId AND orderId = $orderId AND orderStatus = 'COMPLETED' AND feedback = 0");

        if(mysqli_num_rows($check) == 0) {
            ?>
<script>
location.href = 'order-history.php';
</script>
<?php
        }
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
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card p-3" style="background: #fe827a; border-color: #fe827a;">
                <div class="header__title text-center">
                    <span class="h3 text-center text-light text-uppercase" style="font-weight: 700; letter-spacing: .1rem;">Give us a
                        feedback!</span>
                </div>
                <div class="rating__cont mt-3">
                    <form action="" id="feedbackForm">
                        <div class="text-center">
                            <span class="h6 text-light" style="letter-spacing: .1rem;">Your rating:</span>
                        </div>
                        <div class="rating">
                            <select class="form-control form-select" aria-label="Default select example" id="rate"
                                name="rate" required>
                                <option value="">Select rating</option>
                                <option value="Amazing">Amazing</option>
                                <option value="Good">Good</option>
                                <option value="Fair">Fair</option>
                                <option value="Poor">Poor</option>
                                <option value="Terrible">Terrible</option>
                            </select>
                        </div>
                        <div class="text-center mt-3">
                            <span class="h6 text-light" style="letter-spacing: .1rem;">What could we improve?</span>
                        </div>
                        <div class="comment">
                            <div class="form-floating">
                                <textarea class="form-control" rows="5" style="resize: none;"
                                    placeholder="Leave a comment here" id="comment" name="comment"></textarea>
                                <label for="floatingTextarea">Your feedback</label>
                            </div>
                        </div>
                        <button class="btn btn-primary mt-3" style="background: #1b1b1b; width: 100%; letter-spacing: .1rem;"
                            type="submit" id="submitBtn">Submit feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

<script>
$(document).ready(function() {
    $('#feedbackForm').on('submit', function(e) {
        e.preventDefault();

        var orderId = '<?= $orderId ?>';
        var form = new FormData(this);
        form.append('orderId', orderId);
        form.append('feedback', true);

        $.ajax({
            type: "POST",
            url: "./backend/feedback.php",
            data: form,
            dataType: "text",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                $('#submitBtn').prop('disabled', true);
                $('#submitBtn').text('Processing...');
            },
            complete: function() {
                $('#submitBtn').prop('disabled', false);
                $('#submitBtn').text('Submit feedback');
            },
            success: function(response) {
                if (response.includes('success')) {
                    localStorage.setItem('status', 'feedback');
                    location.href = 'order-history.php';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops!',
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