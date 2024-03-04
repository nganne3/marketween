<?php
    $idlg = '';
    $warning = 'Vui lòng chọn một giá trị';
    $warningcate = 'Vui lòng chọn một giá trị';
    $ite = '';
    $it_cate = '';
    if (isset($_SESSION['iduser'])) {
        $idlg = $_SESSION['iduser'];                          
        $collections = show_tatca_collec($pdoConnection, $idlg);
        if (empty($collections)) {
            $warning = 'Bạn chưa có bộ sưu tập nào';
        } else {
            foreach($collections as $c){
                $ite .= '<option value="'.$c['CollectionID'].'" >'.$c['Name'].'</option>';
            }
        }
    }

    $duyetcate = cate_show($pdoConnection);

    if (empty($duyetcate)) {
        $warningcate = 'Nhà quản trị chưa thiết lập danh mục!';
    } else {
        foreach($duyetcate as $d){
            $it_cate .= '<option value="'.$d['CategoryID'].'" >'.$d['Name'].'</option>';
        }
    }
?>

<!-- ============================CREATE PRODUCT===================================== -->
    <div id="containerp-add-product">
        <div id="container-child">

            <div id="addproduct-title"><span style="font-size: 40px; font-weight: bold;">Thêm sản phẩm</span></div>
            <div id="addproduct-des">Thêm 1 sản phẩm mới vào bộ sưu tập tuyệt vời của bạn</div>

            <div id="addproduct-form">
                <div id="addproduct-form-file" >
                    <div class="form-text-1" style="padding-bottom: 20px; max-height:max-content">
                       Bản xem trước
                    </div>

                    <div id="add-form-file-box">

                        <div id="add-form-file-box-text" style="margin-bottom: 10px;"><span style="font-size: 20px; color: #333333;">Chấp nhận JPG, PNG, GIF, WEBP, MP4 hoặc MP3 tối đa 100mb.</span></div>
                        <div class="click-btn-file-box-addpro" id="add-form-file-box-btn"><button id="uploadButton_pr"><span>Chọn tệp</span></button></div>

                        <div id="box_bx_x_add_product" class="box-x-right" style="display: none;">
                            <i class="bx bx-x height-width-40px display-flex align-items-center justify-content-center background-color-hover-xam border-radius-12px font-size-22px"></i>
                        </div>

                        <div class="m-pto-box-featu" style="overflow: hidden; display:none;">
                            <input type="file" id="myfile-addpro" name="myfile" style="display: none;">
                            <img id="preview_featu_pr" src="" alt="" style="width:100%; height:100%; display:none;">
                            <video autoplay loop style="width: 100%; height:100%;">
                                <source id="preview_video" src="" type="video/mp4" style="display: none; width: 100%; height:100%">
                            </video>
                        </div>

                    </div>

                    <div class="margintop_span" style="display: none;">  
                        <i class='bx bx-error-circle'></i>
                        <span id="errorImgFeatured_Pro" class="red_text error-message" style="font-size: 14px;"></span>
                    </div>

                    <script>
                        document.getElementById('uploadButton_pr').addEventListener('click', function() {
                            document.getElementById('myfile-addpro').click();
                        });

                        document.getElementById('myfile-addpro').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    document.getElementById('add-form-file-box-text').style.display = 'none';
                                    document.getElementById('add-form-file-box-btn').style.display = 'none';
                                    document.querySelector('.m-pto-box-featu').style.display = 'flex';
                                    const fileURL = e.target.result;

                                    if (file.type.startsWith('image/')){
                                        document.getElementById('preview_featu_pr').src = fileURL;
                                        document.getElementById('preview_featu_pr').style.display = 'block';
                                        document.getElementById('preview_video').style.display = 'none';

                                    } else if (file.type.startsWith('video/')) {
                                        document.getElementById('preview_video').src = fileURL;
                                        document.getElementById('preview_video').style.display = 'flex';
                                        document.getElementById('preview_featu_pr').style.display = 'none';
                                    }

                                    document.getElementById('box_bx_x_add_product').style.display = 'flex';
                                };
                                reader.readAsDataURL(file);
                            }
                        });

                        document.getElementById('box_bx_x_add_product').addEventListener('click', ()=>{
                            
                            document.getElementById('preview_featu_pr').src = '';
                            document.getElementById('preview_featu_pr').parentElement.style.display = 'none';
                            document.getElementById('box_bx_x_add_product').style.display = 'none';

                            document.getElementById('add-form-file-box-text').style.display = 'block';
                            document.getElementById('add-form-file-box-btn').style.display = 'block';
                        })
                    </script>

                </div>

                <div class="addproduct-form-input">
                    <div class="margin-bottom-10px" for=""><span class="form-text-1">Đường dẫn đến Google Drive</span><span class="form-text-2">(Không bắt buộc ngay)</span></div>
                    <input name="drive_link" id="driver_link" type="text" placeholder="Đường dẫn nơi lưu trữ tệp của bạn">

                    <div class="margintop_span" style="display: none;">  
                        <i class='bx bx-error-circle'></i>
                        <span id="errordriver_link_Pro" class="red_text error-message" style="font-size: 14px;"></span>
                    </div>
                </div>

                <div class="addproduct-form-input">
                    <div class="margin-bottom-10px" for=""><span class="form-text-1">Tên sản phẩm</span></div>
                    <input name="text1" type="text" placeholder="Gợi ý 'Johan Libert #1475'">
             
                    <div class="margintop_span" style="display: none;">  
                        <i class='bx bx-error-circle'></i>
                        <span id="errornamedisplay_Pro" class="red_text error-message" style="font-size: 14px;"></span>
                    </div>
                </div>

                <div class="addproduct-form-input">
                    <div class="margin-bottom-10px" for=""><span class="form-text-1">Mô tả</span><span class="form-text-2">(Không bắt buộc ngay)</span></div>
                    <input name="text2" type="text" placeholder="Gợi ý 'Ảnh dã ngoại thứ 6 ngày 13'">

                    <div class="margintop_span" style="display: none;">  
                        <i class='bx bx-error-circle'></i>
                        <span id="errordescription_Pro" class="red_text error-message" style="font-size: 14px;"></span>
                    </div>
                </div>

                <div class="addproduct-form-select">
                    <div class="margin-bottom-10px" for=""><span class="form-text-1">Chọn bộ sưu tập hiện có của bạn</span></div>
                    <i class='bx bx-chevron-down'></i>
                    <select name="select1">
                        <option value="" selected><?php echo $warning; ?></option>
                        <?php echo $ite; ?>
                    </select>

                    <div class="margintop_span" style="display: none; position:absolute; bottom:-30px; left:0;">  
                        <i class='bx bx-error-circle'></i>
                        <span id="select1_error" class="red_text error-message" style="font-size: 14px;"></span>
                    </div>
                </div>
                        <br>
                <div class="addproduct-form-select">
                    <div class="margin-bottom-10px" for=""><span class="form-text-1">Chọn thể loại</span></div>
                    <i class='bx bx-chevron-down'></i>
                    <select name="select2">
                        <option value="" selected><?php echo $warningcate; ?></option>
                        <?php echo $it_cate; ?>
                    </select>

                    <div class="margintop_span" style="display: none; position:absolute; bottom: -30px;; left:0;">  
                        <i class='bx bx-error-circle'></i>
                        <span id="select2_error" class="red_text error-message" style="font-size: 14px;"></span>
                    </div>
                </div>
            </div>
            <br>
            <div id="addproduct-form-btn"><button><span>Thêm sản phẩm</span></button></div>
        </div>
    </div>
<!-- ============================END CREATE PRODUCT===================================== -->

<script src="<?php echo SITE_SCRIPT_PATH; ?>valid_add_product.js"></script>