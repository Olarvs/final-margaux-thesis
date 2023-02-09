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
?>

<style>
table .btn {
    padding: 5px 10px !important;
}
</style>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="mr-md-3 mr-xl-5 p-0">
                            <h2>User Account</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">User Account</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card p-3 pt-0">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableData">
                            <thead>
                                <tr>
                                    <th>
                                        <center>
                                        Profile Image
                                        </center>
                                    </th>
                                    <th>
                                        <center>
                                        User ID
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
                                        Mobile Number
                                        </center>
                                    </th>
                                    <th>
                                        <center>
                                        Gender
                                        </center>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->

<script>
$(document).ready(function() {
    $('#tableData').css('text-align', 'center');
    var dataTable = $('#tableData').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/user-accounts.php",
            type: "post",
            error: function() {}
        },
        "order": [
            [3, 'desc']
        ],
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
    });

    setInterval(function() {
        dataTable.ajax.reload(null, false);
    }, 60000);

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})
</script>

<?php
include './components/bottom.php';
?>