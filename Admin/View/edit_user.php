<!-- =============================ADD USER=========================== -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <a href="index.php?actad=user"><i class='bx bx-arrow-back text-white'></i></a>
                </span> Sửa tài khoản
            </h3>
        </div>
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
        <?php endif; unset($_SESSION['loi']);

 ?>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                    <form class="editUser" action="index.php?actad=edit_user&UserID=<?php echo htmlspecialchars($_GET['UserID']); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="UserID" value="<?php echo isset($_GET['UserID']) ? htmlspecialchars($_GET['UserID']) : ''; ?>">

                            <div class="forms-sample">
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Username">Tên người dùng</label>
                                        <input type="text" class="form-control" id="Username" name="Username" value="<?php echo isset($editUser['Username']) ? $editUser['Username'] : ''; ?>">
                                        <?php echo isset($UsernameError) ? '<div style="color: orange;">' . $UsernameError . '</div>' : ''; ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Email">Email</label>
                                        <input type="email" class="form-control" id="Email" name="Email" value="<?=$editUser['Email']?>">
                                        <?php echo isset($EmailError) ? '<div style="color: orange;">' . $EmailError . '</div>' : ''; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Role">Vai trò</label>
                                        <select class="form-select" style="height: 48px; border-radius: 10px;" id="Role"
                                            name="Role" value="<?=$editUser['Role']?>">
                                            <option value="user" <?=($editUser['Role']=='user')?'selected':''?>>Khách hàng</option>
                                            <option value="admin" <?=($editUser['Role']=='admin')?'selected':''?>>Quản lý</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Coins">Số Coins</label>
                                        <input type="text" class="form-control" id="Coins" name="Coins" value="<?=$editUser['Coins']?>">
                                        <?php echo isset($CoinsError) ? '<div style="color: orange;">' . $CoinsError . '</div>' : ''; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Password">Mật khẩu</label>
                                        <input type="text" class="form-control" id="Password" name="Password" value="<?=$editUser['Password']?>">
                                        <?php echo isset($PasswordError) ? '<div style="color: orange;">' . $PasswordError . '</div>' : ''; ?>
                                        <br>
                                        <label for="Bio" class="mt-2">Tiểu sử</label>
                                        <textarea id="Bio" name="Bio" rows="12" class="w-100"
                                            style="border-radius: 10px;border:none;padding: 10px 15px;"><?php echo isset($editUser['Bio']) ? $editUser['Bio'] : ''; ?></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="AvatarImage">Ảnh đại diện</label>
                                        <!-- thông báo avatar lỗi -->
                                        <div id="error-message" class="error-message"></div>
                                        <!-- end thông báo avatar lỗi -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img id="image-preview" src="<?php echo USER_PATH; ?><?=$editUser['AvatarImage']?>"
                                                    width="103" height="103"
                                                    style="border-radius:10px; border:solid 1px #fff;" alt="Avatar" />
                                            </div>
                                            <div class="col-md-9">
                                                <p>Khuyến khích kích cỡ 300x300 pixels. Tối đa 5MB ở định dạng JPG,
                                                    JPEG, PNG hoặc GIF</p>
                                                <input type="file" name="AvatarImage" id="AvatarImage"
                                                    class="btnUploadFile btnUploadFile1"
                                                    onchange="previewImage(this)" />
                                                <label for="AvatarImage"><i class='bx bx-upload'></i> Chọn tệp</label>
                                            </div>
                                        </div>
                                        <br>
                                        <label for="CoverImage">Ảnh bìa</label>
                                        <!-- thông báo bìa lỗi -->
                                        <div id="error-message2" class="error-message2"></div>
                                        <!-- end thông báo bìa lỗi -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img id="image-preview2" src="<?php echo USER_PATH; ?><?=$editUser['CoverImage']?>"
                                                    class="w-100" height="133"
                                                    style="border-radius:10px; border:solid 1px #fff;"
                                                    alt="CoverImage" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="mt-3">Khuyến nghị tải lên hình ảnh có độ phân giải 1440x260.
                                                    Tối đa 15 MB ở định dạng JPG, JPEG hoặc PNG</p>
                                                <input type="file" name="CoverImage" id="CoverImage"
                                                    class="btnUploadFile btnUploadFile2"
                                                    onchange="previewImage2(this)" />
                                                <label for="CoverImage"><i class='bx bx-upload'></i> Chọn tệp</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-end mb-4">
                            <button type="submit" name="submit" class="btn btn-outline-light btn-lg btn-block px-5"> Lưu thay đổi</button>
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
<script>
// hàm show xem trước avatar
function previewImage(input) {
    var preview = document.getElementById('image-preview');
    var errorMessage = document.getElementById('error-message');
    errorMessage.innerHTML = '';

    var file = input.files[0];

    // Kiểm tra kích thước tệp
    if (file.size > 500000) {
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

// hàm show xem trước ảnh bìa
function previewImage2(input) {
    var preview = document.getElementById('image-preview2');
    var errorMessage = document.getElementById('error-message2');
    errorMessage.innerHTML = '';

    var file = input.files[0];

    // Kiểm tra kích thước tệp
    if (file.size > 1500000) {
        errorMessage.innerHTML =
            '<div class="alert alert-danger" role="alert">Lỗi: Kích thước tệp ảnh quá lớn. Vui lòng chọn tệp nhỏ hơn.</div>';
        return;
    }

    // Kiểm tra đuôi tệp
    var allowedExtensions = ['jpg', 'jpeg', 'png'];
    var fileExtension = file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(fileExtension)) {
        errorMessage.innerHTML =
            '<div class="alert alert-danger" role="alert">Lỗi: Chỉ chấp nhận các định dạng ảnh JPG, JPEG và PNG.</div>';
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
</script>
<!-- =============================ADD USER=========================== -->