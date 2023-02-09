<?php

use function PHPSTORM_META\map;

include './components/head_css.php'; 
include './components/navbar_sidebar.php'; 

if(!isset($_GET['categoryId'])) {
    ?>
<script>
location.href = 'category.php';
</script>
<?php
} else {
    $categoryId = $_GET['categoryId'];

    $getCategoryName = mysqli_query($conn, "SELECT * FROM tbl_category WHERE categoryId = $categoryId");

    $fetchCategoryName = mysqli_fetch_array($getCategoryName);

    $categoryName = $fetchCategoryName['categoryName'];
}
?>

<!-- INSERT MODAL -->
<div class="modal fade addProductModal" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Add Product</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Category ID</label>
                        <input type="text" class="form-control" id="addCategoryId" name="addCategoryId"
                            placeholder="Category Name" value="<?= $categoryId ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Product Name</label>
                        <input type="text" class="form-control" id="addProductName" name="addProductName"
                            placeholder="Product Name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Product Image</label>
                        <input class="form-control" accept=".jpg, .jpeg, .png, .jfif" type="file"
                            id="addProductThumbnail" name="addProductThumbnail">
                        <span class="error errorAddProductThumbnail"
                            style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-floating">
                            <label for="addProductDescription" name="">Product Description</label>
                            <textarea class="form-control" placeholder="Product description" id="addProductDescription"
                                name="addProductDescription" style="height: 100px"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Product Price</label>
                        <input type="number" class="form-control" id="addProductPrice" name="addProductPrice"
                            placeholder="Product Price" onkeydown="return event.keyCode !== 69" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Product Stock</label>
                        <input type="number" class="form-control" id="addProductStock" name="addProductStock"
                            placeholder="Product Stock" onkeydown="return event.keyCode !== 69" required>
                    </div>
                    <div class="form-group">
                        <label for="addProductStatus">Product Status</label>
                        <select class="form-select" aria-label="Default select example" id="addProductStatus"
                            name="addProductStatus" style="color: #495057;">
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addProductForm" class="btn btn-primary" id="addProductBtn">Add
                    product</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade editProductModal" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Add Product</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Product ID</label>
                        <input type="text" class="form-control" id="editProductId" name="editProductId"
                            placeholder="Category Name" value="" required>
                    </div>
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Category ID</label>
                        <input type="text" class="form-control" id="editCategoryId" name="editCategoryId"
                            placeholder="Category Name" value="" required>
                    </div>
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Old Product Thumbnail</label>
                        <input type="text" class="form-control" id="editOldProductThumbnail" name="editOldProductThumbnail"
                            placeholder="Category Name" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="editProductName"
                            placeholder="Product Name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Product Image</label>
                        <input class="form-control" accept=".jpg, .jpeg, .png, .jfif" type="file"
                            id="editProductThumbnail" name="editProductThumbnail">
                        <span class="error errorEditProductThumbnail"
                            style="font-size: 12px; font-weight: 500; color: #fe827a;"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-floating">
                            <label for="editProductDescription" name="">Product Description</label>
                            <textarea class="form-control" placeholder="Product description" id="editProductDescription"
                                name="editProductDescription" style="height: 100px"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Product Price</label>
                        <input type="number" class="form-control" id="editProductPrice" name="editProductPrice"
                            placeholder="Product Price" onkeydown="return event.keyCode !== 69" required>
                    </div>
                    <div class="form-group">
                        <label for="editProductStatus">Product Status</label>
                        <select class="form-select" aria-label="Default select example" id="editProductStatus"
                            name="editProductStatus" style="color: #495057;">
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="editProductForm" class="btn btn-primary" id="editProductBtn">Edit
                    product</button>
            </div>
        </div>
    </div>
</div> <!-- END EDIT MODAL -->

<!-- DELETE MODAL -->
<div class="modal fade deleteProductModal" id="deleteProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 h2" id="exampleModalLabel">Product</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteProductForm" enctype="multipart/form-data">
                    <div class="form-group d-none">
                        <label for="exampleInputUsername1">Product ID</label>
                        <input type="text" class="form-control" id="deleteProductId" name="deleteProductId"
                            placeholder="Product ID" required>
                    </div>
                    Are you sure, you want this to move in archive?
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
                            <h2><?= $categoryName ?></h2>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i onclick="location.href='index.php'" class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p onclick="location.href='category.php'" class="text-muted mb-0 hover-cursor">Category</p>
                            <p class="text-muted mb-0 hover-cursor">/</p>
                            <p class="text-primary mb-0 hover-cursor"><?= $categoryName ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target=".addProductModal">Add
                    Product</button>
            </div>
        </div>
        <div class="row">
            <?php
            $getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE categoryId = $categoryId AND isDeleted = 0");

            if(mysqli_num_rows($getProduct) == 0) {
            ?>
            <h5>No product found.</h5>
            <?php
            } else {
            foreach($getProduct as $product) {
            ?>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <div class="card p-3 h-100">
                    <div class="image-cont mb-3" style="height: 200px">
                        <img src="./assets/images/productImages/<?= $product['productThumbnail']; ?>"
                            style="width: 100%; height: 100%; object-fit: cover;" alt="">
                    </div>
                    <div class="d-flex flex-column">
                        <h5 style="font-weight: 700;"><?= $product['productName']; ?></h5>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex gap-1 w-100">
                                <div class="dropdown">
                                    <button data-id="<?= $product['productId'] ?>"
                                        class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">Action</button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item editBtn" href="#"
                                                data-id="<?= $product['productId'] ?>">Edit</a></li>
                                        <li><a class="dropdown-item archiveProduct" href="#"
                                                data-id="<?= $product['productId'] ?>">Archive</a></li>
                                    </ul>
                                </div>
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
    if (localStorage.getItem('status') == 'insert') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Product added successfully!',
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
            text: 'Product updated successfully!',
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
            text: 'Product moved to archived successfully!',
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
    $('.editBtn').on('click', function(e) {
        e.preventDefault();

        var editProductId = $(this).data('id');

        $.ajax({
            url: './backend/product.php',
            type: 'POST',
            data: {
                'getProduct': true,
                'getProductId': editProductId,
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $(".editProductModal").modal("show");
                $("#editProductId").val(obj.productId);
                $("#editCategoryId").val(obj.categoryId);
                $("#editProductName").val(obj.productName);
                $("#editProductDescription").val(obj.productDesc);
                $("#editProductPrice").val(obj.productPrice);
                $("#editProductStock").val(obj.productStock);
                $("#editProductStatus").val(obj.productStatus);
                $("#editOldProductThumbnail").val(obj.productThumbnail);
                $("#file").attr("src", "./assets/images/categoryImages/" + obj
                    .productThumbnail);
                // console.log(response);
            }
        })
    })

    // Insert Category
    $('#addProductForm').on('submit', function(e) {
        e.preventDefault();

        if ($('#addProductThumbnail').val().length != 0) {
            var addProductThumbnail = $('#addProductThumbnail').val();
            var image_ext = $('#addProductThumbnail').val().split('.').pop().toLowerCase();

            if ($.inArray(image_ext, ['png', 'jpg', 'jpeg', 'jfif']) == -1) {
                $('.errorAddProductThumbnail').html(
                    '<i class="bi bi-exclamation-circle-fill"></i> File not supported!'
                );
            } else {
                var imageSize = $('#addProductThumbnail')[0].files[0].size;

                if (imageSize > 10485760) {
                    $('.errorAddProductThumbnail').html(
                        '<i class="bi bi-exclamation-circle-fill"></i> File too large!'
                    );
                } else {
                    var form = new FormData(this);
                    form.append('addProduct', true);

                    $.ajax({
                        type: "POST",
                        url: "./backend/product.php",
                        data: form,
                        dataType: 'text',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#addProductBtn').attr('disabled', true);
                            $('#addProductBtn').text('Processing');
                        },
                        complete: function() {
                            $('#addProductBtn').attr('disabled', false);
                            $('#addProductBtn').text('Add product');
                        },
                        success: function(response) {
                            if (response.includes('success')) {
                                localStorage.setItem('status', 'insert');
                                location.reload();
                            } else if (response.includes('exist')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: 'Product already exist!',
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
                            // console.log(response);
                        }
                    })
                }
            }
        } else {
            var form = new FormData(this);
            form.append('addProduct', true);

            $.ajax({
                type: "POST",
                url: "./backend/product.php",
                data: form,
                dataType: 'text',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#addProductBtn').attr('disabled', true);
                    $('#addProductBtn').text('Processing');
                },
                complete: function() {
                    $('#addProductBtn').attr('disabled', false);
                    $('#addProductBtn').text('Add product');
                },
                success: function(response) {
                    if (response.includes('success')) {
                        localStorage.setItem('status', 'insert');
                        location.reload();
                    } else if (response.includes('exist')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Product already exist!',
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
        }
    })

    // Update Category
    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();

        if ($('#editProductThumbnail').val().length != 0) {
            var editProductThumbnail = $('#editProductThumbnail').val();
            var image_ext = $('#editProductThumbnail').val().split('.').pop().toLowerCase();

            if ($.inArray(image_ext, ['png', 'jpg', 'jpeg', 'jfif']) == -1) {
                $('.errorEditProductThumbnail').html(
                    '<i class="bi bi-exclamation-circle-fill"></i> File not supported!'
                );
            } else {
                var imageSize = $('#editProductThumbnail')[0].files[0].size;

                if (imageSize > 10485760) {
                    $('.errorEditProductThumbnail').html(
                        '<i class="bi bi-exclamation-circle-fill"></i> File too large!'
                    );
                } else {
                    var form = new FormData(this);
                    form.append('editProduct', true);

                    $.ajax({
                        type: "POST",
                        url: "./backend/product.php",
                        data: form,
                        dataType: 'text',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#editProductBtn').attr('disabled', true);
                            $('#editProductBtn').text('Processing');
                        },
                        complete: function() {
                            $('#editProductBtn').attr('disabled', false);
                            $('#editProductBtn').text('Update category');
                        },
                        success: function(response) {
                            if (response.includes('success')) {
                                localStorage.setItem('status', 'update');
                                location.reload();
                            } else if (response.includes('exist')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: 'Product already exist!',
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
                }
            }
        } else {
            var form = new FormData(this);
            form.append('editProduct', true);

            $.ajax({
                type: "POST",
                url: "./backend/product.php",
                data: form,
                dataType: 'text',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#editProductBtn').attr('disabled', true);
                    $('#editProductBtn').text('Processing');
                },
                complete: function() {
                    $('#editProductBtn').attr('disabled', false);
                    $('#editProductBtn').text('Update product');
                },
                success: function(response) {
                    if (response.includes('success')) {
                        localStorage.setItem('status', 'update');
                        location.reload();
                    } else if (response.includes('exist')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Category already exist!',
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
        }
    })

    // ARCHIVE CATEGORY
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
            url: "./backend/product.php",
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
                    localStorage.setItem('status', 'archived');
                    location.reload();
                } else if (response.includes('invalid')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Invalid product!',
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

    $('.updateCategoryModal').on('hidden.bs.modal', function() {
        $('#editCategoryForm')[0].reset();
    });
})
</script>

<?php
include './components/bottom.php';
?>