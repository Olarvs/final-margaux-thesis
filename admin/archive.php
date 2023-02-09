<?php 
include './components/head_css.php'; 
include './components/navbar_sidebar.php'; 
?>
<!-- EDIT MODAL -->
<div class="modal fade restoreCategoryModal" id="restoreCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Restore Category</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="restoreCategoryForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Category ID</label>
                        <input type="text" class="form-control" id="restoreCategoryId" name="restoreCategoryId"
                            placeholder="Category ID" required>
                    </div>
                    Are you sure, you want restore this Category?
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="restoreCategoryForm" class="btn btn-primary"
                    id="restoreCategoryBtn">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade deleteCategoryModal" id="deleteCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Delete Category</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteCategoryForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Category ID</label>
                        <input type="text" class="form-control" id="deleteCategoryId" name="deleteCategoryId"
                            placeholder="Category ID" required>
                    </div>
                    Are you sure, you want to delete this category permanently?
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="deleteCategoryForm" class="btn btn-primary"
                    id="deleteCategoryBtn">Yes</button>
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
                            <h2>Archive Category</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor">Archive Category</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <a class="nav-link" href="archive-products.php">
                <button type="button" class="btn btn-primary" >Archive
                    Products</button>
                    </a>
            </div>
        </div>
        <div class="row">
            <?php
            $getCategory = mysqli_query($conn, 'SELECT * FROM tbl_category WHERE isDeleted = 1');

            if(mysqli_num_rows($getCategory) == 0) {
            ?>
            <h5>   No archived category found.</h5>
            <?php
            } else {
            foreach($getCategory as $category) {
            ?>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <div class="card p-3">
                    <div class="image-cont mb-3" style="height: 200px">
                        <img src="./assets/images/categoryImages/<?= $category['categoryThumbnail']; ?>"
                            style="width: 100%; height: 100%; object-fit: cover;" alt="">
                    </div>
                    <div class="d-flex flex-column flex-wrap">
                        <h5 style="font-weight: 700;"><?= $category['categoryName']; ?></h5>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex gap-1 w-100">
                                <!--<div class="dropdown">-->
                                <!--    <button data-id="<?= $category['categoryId'] ?>"-->
                                    <!--    class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"-->
                                    <!--    aria-expanded="false">Action</button>-->
                                    <!--<ul class="dropdown-menu">-->
                                       <a class="restoreBtn" style="color: white;" href="#"
                                                data-id="<?= $category['categoryId'] ?>"><button class="btn btn-primary">Restore</button></a>
                                        <!--<li><a class="dropdown-item archiveCategory" href="javascript:void(0)"-->
                                        <!--        data-id="<?= $category['categoryId'] ?>">Delete</a></li>-->
                                <!--    </ul>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            }
            ?>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->

<script>
$(window).on('load', function() {
    if (localStorage.getItem('status') == 'restore') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Category restored successfully!',
            iconColor: '#000',
            confirmButtonColor: '#000',
            showConfirmButton: false,
            color: '#000',
            background: '#fe827a',
            timer: 5000,
            timerProgressBar: true,
        });
        localStorage.removeItem('status');
    } else if (localStorage.getItem('status') == 'delete') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Category deleted permanently!',
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
    // Image preview
    $('#editCategoryThumbnail').on('change', function() {
        var file = this.files[0];

        if (file) {
            var reader = new FileReader();

            reader.addEventListener('load', function() {
                $('#file').attr("src", this.result);
            })

            reader.readAsDataURL(file);
        }
    })

    // Get Category
    $('.restoreBtn').on('click', function(e) {
        e.preventDefault();

        var restoreCategoryId = $(this).data('id');
        $('#restoreCategoryId').val(restoreCategoryId);
         $(".restoreCategoryModal").modal("show");
    })
    $('#restoreCategoryForm').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('restoreCategory', true);

        $.ajax({
            type: "POST",
            url: "./backend/unarchive.php",
            data: form,
            dataType: 'text',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#restoreCategoryBtn').attr('disabled', true);
                $('#restoreCategoryBtn').text('Processing');
            },
            complete: function() {
                $('#restoreCategoryBtn').attr('disabled', false);
                $('#restoreCategoryBtn').text('Yes');
            },
            success: function(response) {
                if (response.includes('success')) {
                    localStorage.setItem('status', 'restore');
                    location.reload();
                } else if (response.includes('invalid')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Invalid category!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        color: '#000',
                        background: '#fe827a',
                        timer: 5000,
                        timerProgressBar: true,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
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
    })

        
        
    // ARCHIVE CATEGORY
    $('.archiveCategory').on('click', function(e) {
        e.preventDefault();

        var archiveCategoryId = $(this).data('id');

        $('#deleteCategoryId').val(archiveCategoryId);
        $('#deleteCategoryModal').modal('show');

    })

    $('#deleteCategoryForm').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('deleteCategory', true);

        $.ajax({
            type: "POST",
            url: "./backend/unarchive.php",
            data: form,
            dataType: 'text',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#deleteCategoryBtn').attr('disabled', true);
                $('#deleteCategoryBtn').text('Processing');
            },
            complete: function() {
                $('#deleteCategoryBtn').attr('disabled', false);
                $('#deleteCategoryBtn').text('Yes');
            },
            success: function(response) {
                if (response.includes('success')) {
                    localStorage.setItem('status', 'delete');
                    location.reload();
                } else if (response.includes('invalid')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Invalid category!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        color: '#000',
                        background: '#fe827a',
                        timer: 5000,
                        timerProgressBar: true,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
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
    })

    // RESET MODAL
    $('.addCategoryModal').on('hidden.bs.modal', function() {
        $('#addCategoryForm')[0].reset();
    });

    $('.updateCategoryModal').on('hidden.bs.modal', function() {
        $('#editCategoryForm')[0].reset();
    });
})
</script>

<?php
include './components/bottom.php';
?>