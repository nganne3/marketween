<!-- =======================================EDIT COLLECTIONS============================= -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <a href="index.php?actad=collections"><i class='bx bx-arrow-back text-white'></i></a>
                </span> Sửa bộ sưu tập
            </h3>
        </div>
        <!-- Hiển thị thông báo khi sửa thành công -->
        <?php if(isset($_SESSION['thongbao'])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['thongbao'] ?>
        </div>
        <?php endif; unset($_SESSION['thongbao']); ?>

        <!-- Hiển thị thông báo khi sửa thất bại -->
        <?php if(isset($_SESSION['loi'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['loi'] ?>
        </div>
        <?php endif; unset($_SESSION['loi']); ?>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <form class="editCollection"
                            action="index.php?actad=edit_collection&CollectionID=<?php echo htmlspecialchars($_GET['CollectionID']); ?>"
                            method="post" enctype="multipart/form-data">
                            <input type="hidden" name="CollectionID"
                                value="<?php echo isset($_GET['CollectionID']) ? htmlspecialchars($_GET['CollectionID']) : ''; ?>">
                            <div class="forms-sample">

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Name">Tên hiển thị</label>
                                        <input type="text" class="form-control" id="Name" name="Name"
                                            value="<?= isset($editCollection['Name']) ? $editCollection['Name'] : '' ?>">
                                        <?php echo isset($NameError) ? '<div style="color: orange;">' . $NameError . '</div>' : ''; ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Username">Tên người sở hữu</label>
                                        <input type="text" class="form-control" id="Username" name="Username"
                                            value="<?= isset($editCollection['Username']) ? $editCollection['Username'] : '' ?>">
                                        <?php echo isset($UsernameError) ? '<div style="color: orange;">' . $UsernameError . '</div>' : ''; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="LogoImage">Ảnh logo</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img id="logoPreview"
                                                    src="<?php echo COLLECTION_PATH . $editCollection['LogoImage']; ?>"
                                                    width="103" height="103"
                                                    style="border-radius: 10px; border: solid 1px #fff;"
                                                    alt="LogoImage" />
                                            </div>
                                            <div class="col-md-9">
                                                <p>Khuyến khích kích cỡ 300x300 pixels. Tối đa 5MB, GIF, JPEG hoặc PNG
                                                </p>
                                                <input type="file" name="LogoImage" id="LogoImage"
                                                    class="btnUploadFile btnUploadFile1"
                                                    onchange="previewImage('LogoImage', 'logoPreview')" />
                                                <label for="LogoImage"><i class='bx bx-upload'></i> Chọn tệp</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="FeaturedImage">Ảnh nổi bật</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <?php
                                            if (!empty($editCollection['FeaturedImage'])) {
                                                echo '<img id="featuredPreview" src="' . COLLECTION_PATH . $editCollection['FeaturedImage'] . '" width="103" height="103" style="border-radius: 10px; border: solid 1px #fff;" alt="FeaturedImage" />';
                                            } else {
                                                echo '<img id="featuredPreview" width="103" height="103" style="border-radius: 10px; border: solid 1px #fff;" alt="FeaturedImage" />';
                                            }
                                            ?>
                                            </div>
                                            <div class="col-md-9">
                                                <p>Khuyến khích kích cỡ 300x300 pixels. Tối đa 5MB, GIF, JPEG hoặc PNG
                                                </p>
                                                <input type="file" name="FeaturedImage" id="FeaturedImage"
                                                    class="btnUploadFile btnUploadFile1"
                                                    onchange="previewImage('FeaturedImage', 'featuredPreview')" />
                                                <label for="FeaturedImage"><i class='bx bx-upload'></i> Chọn tệp</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="BannerImage">Ảnh biểu trưng</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img id="bannerPreview"
                                                    src="<?php echo COLLECTION_PATH; ?><?=$editCollection['BannerImage']?>"
                                                    width="103" height="103"
                                                    style="border-radius: 10px; border: solid 1px #fff;"
                                                    alt="BannerImage" />
                                            </div>
                                            <div class="col-md-9">
                                                <p>Khuyến nghị tải lên hình ảnh có độ phân giải 1440x260. Tối đa 5MB,
                                                    GIF, JPEG or PNG</p>
                                                <input type="file" name="BannerImage" id="BannerImage"
                                                    class="btnUploadFile btnUploadFile1"
                                                    onchange="previewImage('BannerImage', 'bannerPreview')" />
                                                <label for="BannerImage"><i class='bx bx-upload'></i> Chọn tệp</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Description">Mô tả</label>
                                        <textarea id="Description" name="Description" rows="6" class="w-100"
                                            style="border-radius: 10px; border: none; padding: 10px 15px;"><?= isset($editCollection['Description']) ? $editCollection['Description'] : '' ?></textarea>
                                        <?php echo isset($DescriptionError) ? '<div style="color: orange;">' . $DescriptionError . '</div>' : ''; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-end mb-5">
                                        <button type="submit" name="submit"
                                            class="btn btn-outline-light btn-lg btn-block px-5"> Lưu thay đổi</button>
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
<!-- =======================================END EDIT COLLECTIONS============================= -->

<script>
// hàm hiển thị các ảnh
function previewImage(inputId, imageId) {
    const input = document.getElementById(inputId);
    const image = document.getElementById(imageId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
            image.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>