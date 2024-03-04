<!-- ==========================================CREATE COLLECTIONS================================ -->
<div id="container-add-collec">
    <div id="container-child">
        <div id="addproduct-title"><span style="font-size: 40px; font-weight: bold;">Thêm bộ sưu tập</span></div>
        <div id="addproduct-des">Thêm 1 sản phẩm mới vào bộ sưu tập tuyệt vời của bạn</div>

        <div id="addgallery-form" style="margin-bottom: 50px;">

            <div class="addgallery-form-child" id="name" style="margin-bottom: 40px;">
                <div class="margin-bottom-10px"><span class="margin-bottom-10px font-weight-500 font-size-24px">Tên hiển thị</span></div>
                <input id="name_collec_add" type="text" placeholder="Nhập tên bộ sưu tập">
                <div class="margintop_span">  
                    <i class='bx bx-error-circle'></i>
                    <span id="errorSpan1" class="red_text" style="font-size: 14px;">Sai vcl ra</span>
                </div>
            </div>

            <div class="addgallery-form-child" id="des" style="margin-bottom: 40px;">
                <div class="margin-bottom-10px"><span class="margin-bottom-10px font-weight-500 font-size-24px">Mô tả</span> <span style="font-size: 18px; color: #969696;">(Không bắt buộc)</span></div>
                <input id="des_collec_add" type="text" placeholder="Gợi ý 'Bộ sưu tập các khoảnh khắc tại lễ hội ma quái vừa qua' ">
                <div class="margintop_span">  
                    <i class='bx bx-error-circle'></i>
                    <span id="errorSpan2" class="red_text" style="font-size: 14px;">Sai vcl ra</span>
                </div>
            </div>

            <div class="addgallery-form-child-2" id="img-iconic" style="margin-bottom: 40px;">
                <div class="margin-bottom-10px font-weight-500 font-size-24px">Ảnh biểu trưng</div>

                <div class="action">
                    <div class="img-iconic-image">
                        <i id="icon_photos_logo" class='bx bx-photo-album'></i>
                        <img id="preview_logo" src="" alt="" style="display: none;">
                    </div>
                    <div class="img-iconic-form">
                        <div class="img-iconic-form-title"><span>Khuyến khích kích cỡ 300x300 pixels. Tối đa 5MB, GIF, JPEG or PNG</span></div>
                        <div id="uploadButton_logo" class="img-iconic-form-btn"><button><span>Chọn tệp</span></button></div>
                        <input id="image_logo_coll" type="file" style="display: none;">
                    </div>
                </div>

                <div class="margintop_span">  
                    <i class='bx bx-error-circle'></i>
                    <span id="errorImage1" class="red_text" style="font-size: 14px;">Sai vcl ra</span>
                </div>
            </div>

            <div id="img-bieungu" style="margin-bottom: 40px;">
                
                <div class="margin-bottom-10px font-weight-500 font-size-24px">Ảnh biểu ngữ</div>

                <div class="overflow-hidden border-radius-12px margin-bottom-20px" id="img-bieungu-image" >
                    <i id="icon_photos_banner" class='bx bx-photo-album'></i>
                    <img id="preview_banner" src="" style="width: 100%; height:100%; display:none;" class="anh_bieu_ngu"  alt="">
                </div>

                <div id="img-bieungu-title" class="margin-bottom-20px">
                    Tải lên ảnh bìa mới. Chúng tôi khuyến nghị tải lên hình ảnh có độ phân giải 1440x260. Tối đa 15 MB ở định dạng JPEG hoặc PNG
                </div>

                <div id="img-bieungu-btn">
                    <input id="image_banner_coll" type="file" style="display: none;">
                    <button id="uploadButton_banner"><span>Chọn tệp</span></button>
                </div>

                <div class="margintop_span">  
                    <i class='bx bx-error-circle'></i>
                    <span id="errorImage2" class="red_text" style="font-size: 14px;">Sai vcl ra</span>
                </div>
                
            </div>

            <div class="addgallery-form-child-2" id="img-highlight">
                <div class="margin-bottom-10px font-weight-500 font-size-24px">Ảnh nổi bật</div>
                <div class="action">
                    <div class="img-iconic-image">
                        <i id='icon_photos_featured' class='bx bx-photo-album'></i>
                        <img id="preview_featured" src="" alt="" style="display: none;">
                    </div>
                    <div class="img-iconic-form">
                        <input id="image_featured_coll" type="file" style="display: none;">
                        <div class="img-iconic-form-title"><span>Khuyến khích kích cỡ 300x300 pixels. Tối đa 5MB, GIF, JPEG or PNG</span></div>
                        <div id="uploadButton_featured" class="img-iconic-form-btn"><button><span>Chọn tệp</span></button></div>
                    </div>
                </div>
                <div class="margintop_span">  
                    <i class='bx bx-error-circle'></i>
                    <span id="errorImage3" class="red_text" style="font-size: 14px;">Sai vcl ra</span>
                </div>
            </div>
        </div>

            <div id="addgallery-form-btn"><button><span>Thêm bộ sưu tập</span></button></div>

        </div>
    </div>
</div>

<script>

    document.getElementById('uploadButton_logo').addEventListener('click', function() {
        document.getElementById('image_logo_coll').click();
    });

    document.getElementById('image_logo_coll').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('icon_photos_logo').style.display = 'none';
                document.getElementById('preview_logo').src = e.target.result;
                document.getElementById('preview_logo').parentElement.style.border = '1px solid grey';
                document.getElementById('preview_logo').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('uploadButton_banner').addEventListener('click', function() {
        document.getElementById('image_banner_coll').click();
    });

    document.getElementById('image_banner_coll').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('icon_photos_banner').style.display = 'none';
                document.getElementById('preview_banner').src = e.target.result;
                document.getElementById('preview_banner').parentElement.style.border = '1px solid grey';
                document.getElementById('preview_banner').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('uploadButton_featured').addEventListener('click', function() {
        document.getElementById('image_featured_coll').click();
    });

    document.getElementById('image_featured_coll').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('icon_photos_featured').style.display = 'none';
                document.getElementById('preview_featured').src = e.target.result;
                document.getElementById('preview_featured').parentElement.style.border = '1px solid grey';
                document.getElementById('preview_featured').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

</script>

<script src="<?php echo SITE_SCRIPT_PATH; ?>valid_add_coll.js"></script>

<!-- ==========================================END CREATE COLLECTIONS================================ -->
