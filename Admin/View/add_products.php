<!-- =================================ADD PRODUCT============================= -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <a href="index.php?actad=products"><i class='bx bx-arrow-back text-white'></i></a>
                </span> 
                Thêm sản phẩm
                <?php 
                    // $nganClick = $_GET['actad'];
                    // if ($nganClick == 'edit_product') {
                    //    echo "Chỉnh sửa sản phẩm";
                    // }
                    // elseif($nganClick == 'add_product'){
                    //     echo "Thêm sản phẩm";
                    // }
                ?>
            </h3>
        </div>
        <?php
        $collections = collection_getAll();
        $categories = categories_getAll();
        ?>
        <!-- thêm thành công -->
        <?php if(isset($_SESSION['thongbao']) ):?>
        <div class="alert alert-success" role="alert">
            <?=$_SESSION['thongbao']?>
        </div>
        <?php endif; unset($_SESSION['thongbao']); ?>

        <!-- đã thêm rồi -->
        <?php if(isset($_SESSION['loi']) ):?>
        <div class="alert alert-danger" role="alert">
            <?=$_SESSION['loi']?>
        </div>
        <?php endif; unset($_SESSION['loi']); ?>
        <div class="row ">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                    <form class="addProduct" action="index.php?actad=add_products" method="post" enctype="multipart/form-data">
                        <div class="forms-sample">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="Name">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="Name" name="Name">
                                    <?php echo isset($NameError) ? '<div style="color: orange;">' . $NameError . '</div>' : ''; ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ListedPrice">Giá</label>
                                    <input type="text" class="form-control" id="ListedPrice" name="ListedPrice">
                                    <?php echo isset($ListedPriceError) ? '<div style="color: orange;">' . $ListedPriceError . '</div>' : ''; ?>
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6">
                                <label for="CollectionID">Chọn một bộ sưu tập</label>
                                <select class="form-select" style="height: 48px; border-radius: 10px;" id="CollectionID" name="CollectionID">
                                    <?php foreach ($collections as $collection) : ?>
                                        <option value="<?= $collection['CollectionID'] ?>"><?= $collection['Name'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label for="Category" class="mt-4">Thể loại</label>
                                <select class="form-select" style="height: 48px; border-radius: 10px;" id="Category" name="Category">
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category['CategoryID'] ?>"><?= $category['Name'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label for="Description" class="mt-4">Mô tả</label>
                                <textarea id="Description" name="Description" rows="7" class="w-100" style="border-radius: 10px; border: none; padding: 10px 15px;"></textarea>
                                <?php echo isset($DescriptionError) ? '<div style="color: orange;">' . $DescriptionError . '</div>' : ''; ?>
                            </div>
                                <div class="form-group col-md-6">
                                    <label for="FileURL">Đường dẫn đến Google Drive</label>
                                    <input type="text" class="form-control" id="FileURL" name="FileURL">

                                    <label for="demo" class="mt-4">Bản xem trước</label>
                                    <!-- thông báo avatar lỗi -->
                                    <div id="error-message" class="error-message"></div>
                                    <!-- end thông báo avatar lỗi -->
                                    <div class="text-center">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img id="image-preview" src="<?php echo PRODUCT_PATH; ?>hinh_bia.jpg"
                                                    class="w-100" height="162"
                                                    style="border-radius:10px; border:solid 1px #fff;"
                                                    alt="ImageURL" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="mt-3">Khuyến nghị tải lên hình ảnh có độ phân giải 1440x260.
                                                    Tối đa 15 MB ở định dạng JPG, JPEG hoặc PNG</p>
                                                <input type="file" name="ImageURL" id="ImageURL"
                                                    class="btnUploadFile btnUploadFile2"
                                                    onchange="previewImage(this)" />
                                                <label for="ImageURL"><i class='bx bx-upload'></i> Chọn tệp</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end" style="margin-bottom:20px;">
                                    <button type="submit" name="submit" class="btn btn-outline-light btn-lg btn-block"> Thêm </button>
                                    <button type="reset" class="btn btn-outline-light btn-lg btn-block px-3" onclick="resetImage()">Nhập lại</button> 
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                    </div>
                    </div>
                </div>
            </div>         
        </div>
    </div>
    <script>
        // hàm show xem trước avatar
function previewImage(input) {
    var preview = document.getElementById('image-preview');
    var errorMessage = document.getElementById('error-message');
    errorMessage.innerHTML = '';

    var file = input.files[0];

    // Kiểm tra kích thước tệp
    if (file.size > 1500000) {
        errorMessage.innerHTML =
            '<div class="alert alert-danger" role="alert">Lỗi: Kích thước tệp ảnh quá lớn. Vui lòng chọn tệp nhỏ hơn.</div>';
        return;
    }

    // Kiểm tra đuôi tệp
    var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    var fileExtension = file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(fileExtension)) {
        errorMessage.innerHTML =
            '<div class="alert alert-danger" role="alert">Lỗi: Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG và GIF.</div>';
        return;
    }

    // Hiển thị ảnh xem trước
    var reader = new FileReader();
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };

    reader.readAsDataURL(file);
}
// reset FileImage
function resetImage() {
    var preview = document.getElementById('image-preview');
    var errorMessage = document.getElementById('error-message');
    var fileInput = document.getElementById('FileImage');

    preview.src = '<?php echo USER_PATH; ?>hinh_bia.jpg';
    errorMessage.innerHTML = '';
    fileInput.value = ''; // Xóa giá trị của input file để có thể chọn lại cùng một tệp
}
    </script>
<!-- =================================END ADD PRODUCT============================= -->
