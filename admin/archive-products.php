<?php 
include './components/head_css.php'; 
include './components/navbar_sidebar.php'; 
?>
<!-- EDIT MODAL -->
<div class="modal fade restoreProductModal" id="restoreProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Restore Product</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="restoreProductForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Product ID</label>
                        <input type="text" class="form-control" id="restoreProductId" name="restoreProductId"
                            placeholder="Product ID" required>
                    </div>
                    Are you sure, you want restore this Product?
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="restoreProductForm" class="btn btn-primary"
                    id="restoreProductBtn">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade deleteProductModal" id="deleteProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Delete Product</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteProductForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Product ID</label>
                        <input type="text" class="form-control" id="deleteProductId" name="deleteProductId"
                            placeholder="Product ID" required>
                    </div>
                    Are you sure, you want to delete this Product permanently?
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="deleteProductForm" class="btn btn-primary"
                    id="deleteProductBtn">Yes</button>
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
                            <h2>Archive Product</h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor"> Archive Product</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $getproduct = mysqli_query($conn, 'SELECT a.categoryId, a.productId, a.productName, a.productDesc, a.productThumbnail,a.isDeleted, b.categoryName FROM tbl_product a   LEFT JOIN tbl_category b ON a.categoryId = b.categoryId WHERE a.isDeleted = "1";');

            if(mysqli_num_rows($getproduct) == 0) {
            ?>
            <h5>No product found.</h5>
            <?php
            } else {
            foreach($getproduct as $product) {
            ?>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <div class="card p-3">
                    <div class="image-cont mb-3" style="height: 200px">
                        <img src="./assets/images/productImages/<?= $product['productThumbnail']; ?>"
                            style="width: 100%; height: 100%; object-fit: cover;" alt="">
                    </div>
                    <div class="d-flex flex-column flex-wrap">
                        <h5 style="font-weight: 700;"><?= $product['productName']; ?></h5>
                        <h6 style="font-weight: 300;">Category : <?= $product['categoryName']; ?></h6>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex gap-1 w-100">
                                <!--<div class="dropdown">-->
                                <!--    <button data-id="<?= $product['productId'] ?>"-->
                                <!--        class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"-->
                                <!--        aria-expanded="false">Action</button>-->
                                <!--    <ul class="dropdown-menu">-->
                                <a class="restoreBtn" style="color: white;" href="#"
                                                data-id="<?= $product['productId'] ?>"><button class="btn btn-primary">Restore</button></a>
                                       
                                        <!--<li><a class="dropdown-item restoreBtn" href="#"-->
                                        <!--        data-id="<?= $product['productId'] ?>">Restore</a></li>-->
                                        <!--<li><a class="dropdown-item archiveProduct" href="javascript:void(0)"-->
                                        <!--        data-id="<?= $product['productId'] ?>">Delete</a></li>-->
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
            text: 'product restored successfully!',
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
            text: 'product deleted permanently!',
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
    $('#editProductThumbnail').on('change', function() {
        var file = this.files[0];

        if (file) {
            var reader = new FileReader();

            reader.addEventListener('load', function() {
                $('#file').attr("src", this.result);
            })

            reader.readAsDataURL(file);
        }
    })

    // Get Product
    $('.restoreBtn').on('click', function(e) {
        e.preventDefault();

        var restoreProductId = $(this).data('id');
        $('#restoreProductId').val(restoreProductId);
         $(".restoreProductModal").modal("show");
    })
    $('#restoreProductForm').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('restoreProduct', true);

        $.ajax({
            type: "POST",
            url: "./backend/unarchive.php",
            data: form,
            dataType: 'text',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#restoreProductBtn').attr('disabled', true);
                $('#restoreProductBtn').text('Processing');
            },
            complete: function() {
                $('#restoreProductBtn').attr('disabled', false);
                $('#restoreProductBtn').text('Yes');
            },
            success: function(response) {
                if (response.includes('success')) {
                    localStorage.setItem('status', 'restore');
                    location.reload();
                } else if (response.includes('invalid')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Invalid Product!',
                        iconColor: '#000',
                        confirmButtonColor: '#000',
                        showConfirmButton: false,
                        color: '#000',
                        background: '#fe827a',
                        timer: 5000,
                        timerProgressBar: true,
                    });
                    
                }    else if (response.includes('error')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'No Existing Category!',
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

        
        
    // ARCHIVE Product
    $('.archiveProduct').on('click', function(e) {
        e.preventDefault();

        var archiveProductId = $(this).data('id');

        $('#deleteProductId').val(archiveProductId);
        $('#deleteProductModal').modal('show');

    })

    $('#deleteProductForm').on('submit', function(e) {
        e.preventDefault();

        var form = new FormData(this);
        form.append('deleteProduct', true);

        $.ajax({
            type: "POST",
            url: "./backend/unarchive.php",
            data: form,
            dataType: 'text',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#deleteProductBtn').attr('disabled', true);
                $('#deleteProductBtn').text('Processing');
            },
            complete: function() {
                $('#deleteProductBtn').attr('disabled', false);
                $('#deleteProductBtn').text('Yes');
            },
            success: function(response) {
                if (response.includes('success')) {
                    localStorage.setItem('status', 'delete');
                    location.reload();
                } else if (response.includes('invalid')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Invalid Product!',
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
    $('.addProductModal').on('hidden.bs.modal', function() {
        $('#addProductForm')[0].reset();
    });

    $('.updateProductModal').on('hidden.bs.modal', function() {
        $('#editProductForm')[0].reset();
    });
})
</script>

<?php
include './components/bottom.php';
?>