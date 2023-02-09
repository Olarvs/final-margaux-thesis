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

.password-container {
    position: relative;
}

.password-container input[type="password"],
.password-container input[type="text"] {
    width: 100%;
    padding: 12px 45px 12px 12px;
    box-sizing: border-box;
}

.fa-eye,
.fa-eye-slash {
    position: absolute;
    top: 30%;
    right: 4%;
    cursor: pointer;
    color: gray;
    font-size: 18px;
}
</style>

<!-- UPDATE MODAL -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Update Account</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="updateForm">
                    <div class="form-group d-none">
                        <label>Admin ID</label>
                        <input type="text" name="adminId" class="form-control" id="adminId">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" id="username">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select style="border-color: #f7f7f7 !important; border-width: 1px !important;"
                            class="form-control form-select" id="role" name="role" aria-label="Default select example">
                            <option value="ADMIN">ADMIN</option>
                            <option value="STAFF">STAFF</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="password-container">
                            <input type="password" name="password" class="form-control" id="password">
                            <i class="fa-solid fa-eye" id="eye"></i>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="updateBtn" form="updateForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="mr-md-3 mr-xl-5 p-0">
                            <h2>Admin Account</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">Admin Account</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card p-3 pt-0">
                    <ul class="nav nav-tabs" style="border: none;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#enabled" data-toggle="tab">Enabled</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#disabled" data-toggle="tab">Disabled</a>
                        </li>
                    </ul>

                    <div class="tab-content pt-3 px-0">
                        <div class="tab-pane fade show active" id="enabled" role="tab-panel">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Admin enable account</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="enableTable">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <center>
                                                        Profile Image
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Name
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Name
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Username
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Email
                                                        </center>
                                                    </th>
                                                    
                                                    <th>
                                                        <center>
                                                        Role
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Action
                                                        </center>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="disabled" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Admin disable account</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="disableTable">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <center>
                                                        Profile Image
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Admin ID
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Name
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Username
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Email
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Role
                                                        </center>
                                                    </th>
                                                    <th>
                                                        <center>
                                                        Action
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
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->

<script>
$(document).ready(function() {
    // SHOW PASSWORD
    const passwordInput = document.querySelector("#password")
    const eye = document.querySelector("#eye")

    eye.addEventListener("click", function() {
        eye.classList.toggle("fa-eye-slash");
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
        passwordInput.setAttribute("type", type);
    })

    // DATATABLES
    $('#enableTable').css('text-align', 'center');
    var enable = $('#enableTable').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/admin-accounts-enable.php",
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
        enable.ajax.reload(null, false);
    }, 60000);

    var disable = $('#disableTable').DataTable({
        // "processing": true,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple",
        "scrollX": true,
        "sScrollXInner": "100%",
        "ajax": {
            url: "./tables/admin-accounts-disable.php",
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
        disable.ajax.reload(null, false);
    }, 60000);

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    }); // END DATATABLES

    // ENABLE
    $(document).on('click', '#getEnable', function(e) {
        e.preventDefault();
        var adminId = $(this).data('id');

        var form = new FormData();
        form.append('enable', true);
        form.append('adminId', adminId);

        $.ajax({
            type: "POST",
            url: "./backend/admin-accounts.php",
            data: form,
            cache: false,
            dataType: "text",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.includes('success')) {
                    enable.ajax.reload(null, false);
                    disable.ajax.reload(null, false);
                }
                console.log(response);
            }
        })
    })

    // DISABLE
    $(document).on('click', '#getDisable', function(e) {
        e.preventDefault();
        var adminId = $(this).data('id');

        var form = new FormData();
        form.append('disable', true);
        form.append('adminId', adminId);

        $.ajax({
            type: "POST",
            url: "./backend/admin-accounts.php",
            data: form,
            cache: false,
            dataType: "text",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.includes('success')) {
                    enable.ajax.reload(null, false);
                    disable.ajax.reload(null, false);
                }
                console.log(response);
            }
        })
    })

    // GET UPDATE
    $(document).on('click', '#getUpdate', function(e) {
        e.preventDefault();

        var adminId = $(this).data('id');
        var form = new FormData();
        form.append('adminId', adminId);
        form.append('getAccount', true);

        $.ajax({
            type: "POST",
            url: "./backend/admin-accounts.php",
            data: form,
            dataType: "text",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                var obj = JSON.parse(response);
                $('#updateModal').modal("show");
                $('#adminId').val(obj.adminId);
                $('#name').val(obj.name);
                $('#username').val(obj.username);
                $('#email').val(obj.email);
                $('#role').val(obj.role);
            }
        })
    })

    // UPDATE ACCOUNT
    $('#updateForm').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('updateAccount', true);

        $.ajax({
            type: "POST",
            url: "./backend/admin-accounts.php",
            data: form,
            dataType: "text",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if (response.includes('success')) {
                    $('#updateModal').modal("hide");
                    enable.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Account updated successfully!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        color: '#000',
                        background: '#fe827a',
                    })
                } else if (response.includes('email exist')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops...',
                        text: 'Email already used!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        color: '#000',
                        background: '#fe827a',
                    })
                } else if (response.includes('username exist')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops...',
                        text: 'Username already used!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        color: '#000',
                        background: '#fe827a',
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops...',
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
            }
        })
    })
})
</script>

<?php
include './components/bottom.php';
?>