<?php 
include './components/head_css.php'; 
include './components/navbar_sidebar.php'; 

if($_SESSION['margaux_role'] != 'ADMIN') {
    ?>
    <script>
        location.href = 'index.php';
    </script>
    <?php
}
$adminId = $_SESSION['margaux_admin_id']; 

$getAdminName = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE adminId = $adminId");

$fetchAdminName = mysqli_fetch_array($getAdminName);

$adminName = $fetchAdminName['name'];

$getEarliestDate = mysqli_query($conn, "SELECT MIN(date(orderDateTimeCompleted)) as EarliestDate
FROM tbl_order");

$fetchEarlistDate = mysqli_fetch_array($getEarliestDate);

$earliestDate = $fetchEarlistDate['EarliestDate'];

$getLatestDate = mysqli_query($conn, "SELECT MAX(date(orderDateTimeCompleted)) as LatestDate
FROM tbl_order");

$fetchLatestDate = mysqli_fetch_array($getLatestDate);

$latestDate = $fetchLatestDate['LatestDate'];
?>

<style>
table .btn {
    padding: 5px 10px !important;
}
.selectCustom {
    width: unset !important;
}
</style>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="mr-md-3 mr-xl-5 p-0">
                            <h2>Daily Sales</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">Daily Sales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body" style="width: 100%;">
                        <div id="timeago"></div>
                        <h4 class="card-title">Daily Sales</h4>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <div class="row gap-2 p-0 mx-0">
                                <label for="" class="align-self-end">FROM</label>
                                <input type="date" class="form-control" name="from" id="from"
                                    value="<?= $earliestDate ?>" style="width: unset !important;">
                            </div>
                            <div class="row gap-2 p-0 mx-0">
                                <label for="" class="align-self-end">TO</label>
                                <input type="date" class="form-control" name="to" id="to" value="<?= $latestDate ?>"
                                    style="width: unset !important;">
                            </div>
                            <div class="row gap-2 p-0 mx-0">
                                <button class="btn btn-primary" id="dateFilter">FILTER</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="dailySales" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>
                                            Order ID
                                            </center>
                                        </th>
                                        <th>
                                            <center>
                                            Name
                                            </center>
                                        </th>
                                        <th>
                                            <center>
                                            Email
                                            </center>
                                        </th>
                                        <th>
                                            <center>
                                            Mode of Delivery
                                            </center>
                                        </th>
                                        <th>
                                            <center>
                                            Mode of Payment
                                            </center>
                                        </th>
                                        <th>
                                            <center>
                                            Date Completed
                                            </center>
                                        </th>
                                        <th>
                                            <center>
                                            Order Total
                                            </center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th id="orderTotalTable"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->

<script>
$(window).on('load', function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

    if (localStorage.getItem('status') == 'updateStockSettings') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Stock settings updated successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            color: '#000',
            background: '#fe827a',
            timer: 5000,
            timerProgressBar: true,
        });
        localStorage.removeItem('status');
    } else if (localStorage.getItem('status') == 'update') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Stock added successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            color: '#000',
            background: '#fe827a',
            timer: 5000,
            timerProgressBar: true,
        });
        localStorage.removeItem('status');
    } else if (localStorage.getItem('status') == 'archived') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Category moved to archived successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            color: '#000',
            background: '#fe827a',
            timer: 5000,
            timerProgressBar: true,
        });
        localStorage.removeItem('status');
    }
})

$(document).ready(function() {
    
    //REVISION NUMBER 9
    // Remove the Excel export option for
    // reports.
    
    // In short just remove the excel button
    
    
    //REVISION NUMBER 10
    // The date should be written out in    
    // words in exported reports; contact
    // information should be provided
    // above the report file; and a signature
    // and a statement that the printable
    // receipt is not valid without it should
    // be included.
    
    // DATATABLES
    <?php 
    $currentDateTime = date('F j, Y, g:i a');
    ?>
    fetchData('no');
    
    // REVISIONS NUMBER 10
    
    var getStartDate = $('#from').val();
    var getEndDate = $('#to').val();
    
    getStartDate  = new Date(getStartDate).toLocaleString('default', {  year: 'numeric', month: 'long', day: 'numeric', });
    getEndDate = new Date(getEndDate).toLocaleString('default', {  year: 'numeric', month: 'long', day: 'numeric', });

    function fetchData(isDateSearch, startDate = '', endDate = '') {
        $('#dailySales').css('text-align', 'center');
        var datatable = $('#dailySales').DataTable({
            // "processing": true,
            "serverSide": true,
            "paging": true,
            "pagingType": "simple",
            "scrollX": true,
            "sScrollXInner": "100%",
            "ajax": {
                url: "./tables/sales-report.php",
                type: "post",
                data: {
                    isDateSearch: isDateSearch,
                    startDate: startDate,
                    endDate: endDate
                },
                error: function(xhr, error, code) {
                    console.log(xhr, code);
                }
            },
            drawCallback: function(settings) {
                $('#orderTotalTable').html(settings.json.total);
            },
            "order": [
                [5, 'desc']
            ],
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            dom: 'Blfrtip',
             buttons: [
                    {
                        extend: 'print',
                        title: '',
                        text: 'PDF',
                        footer: true,
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '12pt')
                                .css('font-weight', 'bold')
                                .prepend(
                                    '<center><img src="https://res.cloudinary.com/dh3m4os9t/image/upload/v1674371596/icons/218311224_1157387011429396_5300322267837845292_n_xrd5ti.jpg" style="width: 80px; right: 0;"><br><span style="font-size: 26px; color:#fe827a">MARGAUX CACTI & SUCCULENTS CORNER</span><br>Brgy Sto Nino Purok 1, Cabanatuan City, Philippines<br><a href ="margauxcscorner@gmail.com">margauxcscorner@gmail.com</a><br>0927 975 7327<br><br>Sales from ' +
                                    getStartDate + ' to ' + getEndDate +
                                    '<br><br></center>'
                                );
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', '12pt');
                        },
                        messageBottom: '<br><hr width ="100%" style =""><div style ="padding: 10px; text-align: left;margin-bottom: 3.5rem;"><p style ="color:#38bdf8;">Please note: This report is not valid without the included signature.</p></div><div style="display: grid;grid-template-columns: 1fr 1fr;"><div><p>Date Exported: <?= $currentDateTime ?><br>Exported By: <?= $adminName ?></p></div><div style ="display: flex;justify-content: flex-end;align-items: flex-end;"><div  style="display: grid;grid-template-rows: 1fr 1fr;"><div  style ="display: block;"><hr width ="350px" style="font-weight: bold;"></div><div  style ="display: block;"><center>Staff Signature</center></div></div></div>'
                    }
                ],
        });
    }

    $('#dateFilter').click(function() {
        var startDate = $('#from').val();
        var endDate = $('#to').val();

        if (startDate != '' && endDate != '') {
            if (startDate > endDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops...',
                    text: 'Invalid date!',
                    iconColor: '#000',
                    confirmButtonColor: '#000',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    color: '#000',
                    background: '#fe827a',
                })
            } else {
                $('#dailySales').DataTable().destroy();
                fetchData('yes', startDate, endDate);
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Ooops...',
                text: 'Both date is required!',
                iconColor: '#000',
                confirmButtonColor: '#000',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                color: '#000',
                background: '#fe827a',
            })
        }
    })

    setInterval(function() {
        $('#dailySales').DataTable().ajax.reload(null, false);
    }, 10000); // END DATATABLES
})
</script>

<?php
include './components/bottom.php';
?>