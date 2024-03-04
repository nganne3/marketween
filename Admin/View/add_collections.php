<!-- =======================================ADD COLLECTIONS============================= -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <a href="index.php?actad=collections"><i class='bx bx-arrow-back text-white'></i></a>
                </span> Thêm bộ sưu tập
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
                    <form class="addCollection" action="index.php?actad=add_collections" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="Name">Tên hiển thị</label>
                                <input type="text" class="form-control" id="Name" name="Name"   >
                                <?php echo isset($NameError) ? '<div style="color: orange;">' . $NameError . '</div>' : ''; ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Username">Tên người sở hữu</label>
                                <input type="text" class="form-control" id="Username" name="Username" >
                                <?php echo isset($UsernameError) ? '<div style="color: orange;">' . $UsernameError . '</div>' : ''; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="LogoImage">Ảnh logo</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <img id="logoPreview" src="<?php echo USER_PATH; ?>1.jpg" width="103" height="103" style="border-radius: 10px; border: solid 1px #fff;" alt="LogoImage" />
                                    </div>
                                    <div class="col-md-9">
                                        <p>Khuyến khích kích cỡ 300x300 pixels. Tối đa 5MB, GIF, JPEG or PNG</p>
                                        <input type="file" name="LogoImage" id="LogoImage" class="btnUploadFile btnUploadFile1" onchange="previewImage('LogoImage', 'logoPreview')" />
                                        <label for="LogoImage"><i class='bx bx-upload'></i> Chọn tệp</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="FeturedImage">Ảnh nổi bật</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <img id="featuredPreview" src="<?php echo USER_PATH; ?>2.jpg" width="103" height="103" style="border-radius: 10px; border: solid 1px #fff;" alt="FeturedImage" />
                                    </div>
                                    <div class="col-md-9">
                                        <p>Khuyến khích kích cỡ 300x300 pixels. Tối đa 5MB, GIF, JPEG or PNG</p>
                                        <input type="file" name="FeturedImage" id="FeturedImage" class="btnUploadFile btnUploadFile1" onchange="previewImage('FeturedImage', 'featuredPreview')" />
                                        <label for="FeturedImage"><i class='bx bx-upload'></i> Chọn tệp</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="BannerImage">Ảnh biểu trưng</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <img id="bannerPreview" src="<?php echo USER_PATH; ?>3.jpg" width="103" height="103" style="border-radius: 10px; border: solid 1px #fff;" alt="BannerImage" />
                                    </div>
                                    <div class="col-md-9">
                                        <p>Khuyến nghị tải lên hình ảnh có độ phân giải 1440x260. Tối đa 5MB, GIF, JPEG or PNG</p>
                                        <input type="file" name="BannerImage" id="BannerImage" class="btnUploadFile btnUploadFile1" onchange="previewImage('BannerImage', 'bannerPreview')" />
                                        <label for="BannerImage"><i class='bx bx-upload'></i> Chọn tệp</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Description">Mô tả</label><br>
                                <textarea id="Description" name="Description" rows="6" class="w-100" style="border-radius: 10px; border: none; padding: 10px 15px;" ></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-end mb-5">
                            <button type="submit" name="submit" class="btn btn-outline-light btn-lg btn-block"> Thêm </button>
                            <button type="reset" class="btn btn-outline-light btn-lg btn-block px-3" onclick="resetImage()">Nhập lại</button> 
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
<!-- =======================================END ADD COLLECTIONS============================= -->
<script>
    // hàm hiển thị các ảnh
    function previewImage(inputId, imageId) {
        const input = document.getElementById(inputId);
        const image = document.getElementById(imageId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                image.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Hàm reset tất cả các trường và hình ảnh
    function resetImage() {
        // Reset trường input
        document.getElementById("Name").value = "";
        document.getElementById("Username").value = "";
        document.getElementById("LogoImage").value = "";
        document.getElementById("FeturedImage").value = "";
        document.getElementById("BannerImage").value = "";
        document.getElementById("Description").value = "";

        // Reset hình ảnh preview
        document.getElementById("logoPreview").src = "<?php echo USER_PATH; ?>1.jpg";
        document.getElementById("featuredPreview").src = "<?php echo USER_PATH; ?>2.jpg";
        document.getElementById("bannerPreview").src = "<?php echo USER_PATH; ?>3.jpg";
    }   
</script>
