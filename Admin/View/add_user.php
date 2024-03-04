<!-- =============================ADD USER=========================== -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px;padding: 10px 20px; background-color: #fff;">
            <div class="modal-header" style="border-bottom: none;">
                <h1 class="modal-title fs-5 text-warning" style="font-weight: bold;" id="exampleModalLabel"><i class='bx bx-bell'></i> Thông báo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-5" id="modal-message">
                <!-- Nội dung thông báo sẽ hiện ở đây -->
            </div>
        </div>
    </div>
</div>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <a href="index.php?actad=user"><i class='bx bx-arrow-back text-white'></i></a>
                </span> Thêm tài khoản mới
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
        <?php endif; unset($_SESSION['loi']); ?>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <form class="addUser" action="index.php?actad=add_user" method="post"
                            enctype="multipart/form-data" onsubmit="return validateForm()">
                            <form class="forms-sample">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Username">Tên người dùng</label>
                                        <input type="text" class="form-control" id="Username" name="Username" oninput="clearErrors()">
                                        <div class="error-message mt-2 text-warning" id="Username-error" style="display:none;"></div>
                                        <?php echo isset($UsernameError) ? '<div style="color: orange;">' . $UsernameError . '</div>' : ''; ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Email">Email</label>
                                        <input type="email" class="form-control" id="Email" name="Email">
                                        <?php echo isset($EmailError) ? '<div style="color: orange;">' . $EmailError . '</div>' : ''; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Role">Vai trò</label>
                                        <select class="form-select" style="height: 48px; border-radius: 10px;" id="Role"
                                            name="Role">
                                            <option value="user" selected>Khách hàng</option>
                                            <option value="admin">Quản lý</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Coins">Số Coins</label>
                                        <input type="text" class="form-control" id="Coins" name="Coins" oninput="clearErrors()">
                                        <div class="error-message mt-2 text-warning" id="Coins-error" style="display:none;"></div>
                                        <?php echo isset($CoinsError) ? '<div style="color: orange;">' . $CoinsError . '</div>' : ''; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Password">Mật khẩu</label>
                                        <input type="text" class="form-control" id="Password" name="Password">
                                        <?php echo isset($PasswordError) ? '<div style="color: orange;">' . $PasswordError . '</div>' : ''; ?>
                                        <br>
                                        <label for="Bio" class="mt-2">Tiểu sử</label>
                                        <textarea id="Bio" name="Bio" rows="12" class="w-100"
                                            style="border-radius: 10px;border:none;padding: 10px 15px;"></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="AvatarImage">Ảnh đại diện</label>
                                        <!-- thông báo avatar lỗi -->
                                        <div id="error-message" class="error-message"></div>
                                        <!-- end thông báo avatar lỗi -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img id="image-preview" src="<?php echo USER_PATH; ?>avatar_default.jpg"
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
                                                <img id="image-preview2" src="<?php echo USER_PATH; ?>hinh_bia.jpg"
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
                        <div class="col-md-12 text-end" style="margin-bottom:20px;">
                            <button type="submit" name="submit" class="btn btn-outline-light btn-lg btn-block"> Thêm
                            </button>
                            <button type="reset" class="btn btn-outline-light btn-lg btn-block px-3"
                                style="margin-right:20px;" onclick="resetImage()">Nhập lại</button>
                        </div>
                    </div>
                    </form>
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
// reset avatar
function resetImage() {
    var preview = document.getElementById('image-preview');
    var preview2 = document.getElementById('image-preview2');
    var errorMessage = document.getElementById('error-message');
    var errorMessage2 = document.getElementById('error-message2');
    var fileInput = document.getElementById('AvatarImage');
    var fileInput2 = document.getElementById('CoverImage');

    preview.src = '<?php echo USER_PATH; ?>avatar_default.jpg';
    preview2.src = '<?php echo USER_PATH; ?>hinh_bia.jpg';
    errorMessage.innerHTML = '';
    errorMessage2.innerHTML = '';
    fileInput.value = ''; // Xóa giá trị của input file để có thể chọn lại cùng một tệp
    fileInput2.value = ''; // Xóa giá trị của input file để có thể chọn lại cùng một tệp
}

function displayError(fieldId, errorMessage) {
    // Hiển thị thông báo lỗi ngay dưới trường tương ứng
    var errorDiv = document.getElementById(fieldId + '-error');
    errorDiv.innerHTML = '<p class="text-danger"><strong>' + errorMessage + '</strong></p>';
    errorDiv.style.display = 'block';
}

function clearErrors() {
    // Xóa tất cả thông báo lỗi
    var errorDivs = document.querySelectorAll('.error-message');
    errorDivs.forEach(function (div) {
        div.innerHTML = '';
        div.style.display = 'none';
    });
}


function displayPopup(message) {
    // Hiển thị thông báo trong modal
    $('#modal-message').html(message);
    $('#myModal').modal('show');
}

// function validateForm() {
//     // Xóa tất cả thông báo lỗi trước khi kiểm tra lại
//     clearErrors();

//     var username = document.getElementById('Username').value;
//     var email = document.getElementById('Email').value;
//     var coins = document.getElementById('Coins').value;
//     var password = document.getElementById('Password').value;
//     var bio = document.getElementById('Bio').value;
//     var avatarImage = document.getElementById('AvatarImage').value;
//     var coverImage = document.getElementById('CoverImage').value;

//     if (username.trim() === '' || email.trim() === '' || coins.trim() === '' || password.trim() === '') {
//         // Hiển thị thông báo trong modal
//         displayPopup('Vui lòng điền đầy đủ thông tin.');
//         return false;
//     }

//     // Kiểm tra Tên người dùng chỉ nhập chữ và số, không khoảng trắng và ký tự đặc biệt
//     var usernamePattern = /^[a-zA-Z0-9]+$/;
//     if (!usernamePattern.test(username)) {
//         displayError('Username', 'Tên người dùng chỉ được phép nhập chữ và số, không khoảng trắng và ký tự đặc biệt.');
//         // Không cần return false ở đây để kiểm tra tất cả các điều kiện lỗi
//     }

//     // Kiểm tra Coins chỉ cho nhập số
//     var coinsPattern = /^\d+$/;
//     if (!coinsPattern.test(coins)) {
//         displayError('Coins', 'Coins chỉ được phép nhập số.');
//     }

//     // Kiểm tra các điều kiện khác nếu cần

//     // Nếu có ít nhất một lỗi, không submit form
//     if (document.querySelectorAll('.error-message p').length > 0) {
//         return false;
//     }

//     return true;
// }
</script>
<!-- =============================ADD USER=========================== -->