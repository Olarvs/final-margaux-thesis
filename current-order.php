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
                    <h1 style="letter-spacing: .1rem;">CURRENT PURCHASE</h1>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="container my-5">
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-striped" id="currentOrder">
                <thead>
                    <tr>
                        <th><center>Order ID</center></th>
                        <th><center>Delivery Method</center></th>
                        <th><center>Payment Method</center></th>
                        <th><center>Order Date & Time</center></th>
                        <th><center>Order Total</center></th>
                        <th><center>Status</center></th>
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
    })

    $(document).ready(function() {
        // DATATABLES
        $('#currentOrder').css('text-align', 'center');
        var dataTable = $('#currentOrder').DataTable({
            // "processing": true,
            "serverSide": true,
            "paging": true,
            "pagingType": "simple",
            "scrollX": true,
            "sScrollXInner": "100%",
            "ajax": {
                url: "./tables/current-order.php",
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

        // CANCEL ORDER
        $(document).on('click', '#getCancel', function(e) {
            e.preventDefault();

            var orderId = $(this).data('id');
            var form = new FormData();
            form.append('cancel', true);
            form.append('orderId', orderId);

            Swal.fire({
                icon: 'question',
                title: 'Hey!',
                text: 'Are you sure, you want to cancel this order?',
                iconColor: '#000',
                confirmButtonColor: '#000',
                showConfirmButton: true,
                showCancelButton: true,
                color: '#000',
                background: '#fe827a',
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "./backend/order.php",
                        data: form,
                        dataType: "text",
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(response) {
                            if(response.includes('success')) {  
                                dataTable.ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Order successfully cancelled!',
                                    iconColor: '#000',
                                    confirmButtonColor: '#000',
                                    showConfirmButton: false,
                                    color: '#000',
                                    background: '#fe827a',
                                    timer: 5000,
                                    timerProgressBar: true,
                                });
                            } else if(response.includes('invalid')) {  
                                dataTable.ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: 'Invalid orded id!',
                                    iconColor: '#000',
                                    confirmButtonColor: '#000',
                                    showConfirmButton: false,
                                    color: '#000',
                                    background: '#fe827a',
                                    timer: 5000,
                                    timerProgressBar: true,
                                });
                            } else {
                                dataTable.ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
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
            })
        })
    })
</script>

<?php
include './components/footer.php';
include './components/bottom-script.php';
?>