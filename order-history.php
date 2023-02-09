<?php
include './components/head_css.php';
include './components/navbar.php';

if(!isset($_SESSION['margaux_user_id'])) {
    ?>
<script>
location.href = 'login.php';
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

.btn {
    padding: 3px 10px !important;
    font-size: 13px !important;
}
</style>

<div class="hero p-2">
    <div class="container  pt-4">
        <div class="row justify-content-between">
            <div class="col-lg-12">
                <div class="text-center">
                    <h1 style="letter-spacing: .1rem;">PURCHASE HISTORY</h1>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="container my-5">
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-striped" id="orderHistory">
                <thead>
                    <tr>
                        <th><center>Order ID</center></th>
                        <th><center>Delivery Method</center></th>
                        <th><center>Payment Method</center></th>
                        <th><center>Order Date & Time</center></th>
                        <th><center>Order Completed Date & Time</center></th>
                        <th><center>Order Status</center></th>
                        <th><center>Order Total</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
$(window).on('load', function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

    if (localStorage.getItem('status') == 'feedback') {
        Swal.fire({
            icon: 'success',
            title: 'Your feedback successfully submitted!',
            text: 'Thank you for giving us a feedback!',
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
    // DATATABLES
    $('#stocks').css('text-align', 'center');
    var dataTable = $('#orderHistory').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/order-history.php",
            type: "post",
            error: function(xhr, error, code) {
                console.log(xhr, code);
            }
        },
        "order": [
            [3, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
    });

    setInterval(function() {
        dataTable.ajax.reload(null, false);
    }, 10000); // END DATATABLES

    // CLICK FEEDBACK
    $(document).on('click', '#getRate', function(e) {
        e.preventDefault();

        var orderId = $(this).data('id');

        location.href = 'give-us-feedback.php?id=' + orderId;
    })
})
</script>

<?php
include './components/footer.php';
include './components/bottom-script.php';
?>