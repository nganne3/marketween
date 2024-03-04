<!-- ======================EDIT CATEGORIE PAGE==================== -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <a href="index.php?actad=categories"><i class='bx bx-arrow-back text-white'></i></a>
                </span> Sửa danh mục
            </h3>
        </div>
        <!-- sửa thành công -->
        <?php if(isset($_SESSION['thongbao']) ):?>
        <div class="alert alert-success" role="alert">
            <?=$_SESSION['thongbao']?>
        </div>
        <?php endif; unset($_SESSION['thongbao']); ?>

        <!-- sửa thất bại -->
        <?php if(isset($_SESSION['loi']) ):?>
        <div class="alert alert-danger" role="alert">
            <?=$_SESSION['loi']?>
        </div>
        <?php endif; unset($_SESSION['loi']); ?>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <form class="editCategories" action="" method="POST">
                            <form class="forms-sample">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="nameCategory">Tên danh mục</label>
                                        <input type="text" class="form-control" id="nameCategory" name="nameCategory" value="<?=$editCategory['Name']?>">
                                        <?php echo isset($nameCategoryError) ? '<div style="color: orange;">' . $nameCategoryError . '</div>' : ''; ?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="statusCategory">Trạng thái xuất hiện</label>
                                        <div class="row">
                                        <?php if($editCategory['Status']=='show'):?>
                                            <div class="col-6">
                                                <div class="form-check form-check-primary">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                            name="statusCategory" id="optionsRadios1" value="show"
                                                            checked> Hiển thị </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check form-check-primary">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                            name="statusCategory" id="optionsRadios2" value="hide"> Ẩn
                                                        đi</label>
                                                </div>
                                            </div>
                                        <?php else:?>
                                            <div class="col-6">
                                                <div class="form-check form-check-primary">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                            name="statusCategory" id="optionsRadios1" value="show"
                                                            > Hiển thị </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check form-check-primary">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                            name="statusCategory" id="optionsRadios2" value="hide" checked> Ẩn
                                                        đi</label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <div class="row justify-content-end mb-4">
                        <div class="col-md-3">
                            <button type="submit" name="submit" class="btn btn-outline-light btn-lg btn-block px-5"> Lưu thay đổi</button>
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
<!-- ======================END EDIT CATEGORIE PAGE==================== -->