<?php 
include './components/head_css.php'; 
include './components/navbar_sidebar.php'; 
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
                            <h2>Product Sale</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">Product Sale</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body" style="width: 100%;">
                        <h4 class="card-title">Product Sale</h4>
                        <div class="table-responsive">
                            <table class="table table-striped" id="dailySales" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>
                                            Product Name
                                        </th>
                                        <th>
                                            Sale Quantity
                                        </th>
                                    </tr>
                                </thead>
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
    // DATATABLES
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
            error: function(xhr, error, code) {
                console.log(xhr, code);
            }
        },
        "order": [
            [0, 'desc']
        ],
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        dom: 'Blfrtip',
        buttons: [{
            extend: 'collection',
            text: 'Export',
            footer: true,
            buttons: [{
                    extend: 'copy',
                    title: 'Daily Sales Report',
                    footer: true
                },
                {
                    extend: 'excel',
                    title: 'Daily Sales Report',
                    footer: true
                },
                {
                    extend: 'csv',
                    title: 'Daily Sales Report',
                    footer: true
                },
                {
                    extend: 'pdf',
                    title: 'Daily Sales Report',
                    footer: true
                },
                {
                    extend: 'print',
                    title: 'Daily Sales Report',
                    footer: true
                }
            ],
        }, ],
    });

    setInterval(function() {
        datatable.ajax.reload(null, false);
    }, 10000); // END DATATABLES
})
</script>

<?php
include './components/bottom.php';
?>