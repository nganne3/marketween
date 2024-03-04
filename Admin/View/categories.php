<!-- ==============================CATEGORIES PAGE=============================== -->
<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="bx bxs-category"></i>
                </span> Danh mục
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php?actad=add_categories"><button type="button" class="btn btn-gradient-primary btn-lg btn-block">
                        <i class="bx bx-plus"></i> Thêm mới </button></a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- xóa thành công -->
        <?php if(isset($_SESSION['thongbao']) ):?>
        <div class="alert alert-success" role="alert">
            <?=$_SESSION['thongbao']?>
        </div>
        <?php endif; unset($_SESSION['thongbao']); ?>

        <!-- có lỗi -->
        <?php if(isset($_SESSION['loi']) ):?>
        <div class="alert alert-danger" role="alert">
            <?=$_SESSION['loi']?>
        </div>
        <?php endif; unset($_SESSION['loi']); ?>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Danh sách danh mục</h4>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Tên</th>
                                    <th>ID</th>
                                    <th>Số sản phẩm</th>
                                    <th>Ẩn/Hiện</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($kq)&&(count($kq)>0)): ?>
                                    <?php $i=1; foreach($kq as $category): ?>
                                    <tr>
                                    <td><?=$i?></td>
                                    <td><?=$category['Name']?></td>
                                    <td>#<?=$category['CategoryID']?></td>
                                    <td><?=number_format($category['AmountProduct'])?></td>
                                    <td>
                                    <?php 
                                        switch ($category['Status']){
                                        case 'show':
                                            echo '<button type="button" class="btn btn-outline-secondary btn-rounded btn-icon">
                                            <i class="bx bx-show text-success"></i>
                                            </button>';
                                            break;
                                        case 'hide':
                                            echo '<button type="button" class="btn btn-outline-secondary btn-rounded btn-icon">
                                            <i class="bx bx-low-vision text-success"></i>
                                            </button>';
                                            break;
                                        }
                                    ?>
                                    </td>
                                    <td>
                                        <a href="index.php?actad=edit_categories&CategoryID=<?=$category['CategoryID']?>" type="button" class="btn btn-outline-secondary btn-rounded btn-icon">
                                        <i class='bx bxs-pencil' style="margin-top:12px;"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-rounded btn-icon" onclick="getCategory(<?=$category['CategoryID']?>)" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$category['CategoryID']?>">
                                        <i class='bx bx-trash-alt'></i>
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal<?=$category['CategoryID']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius: 20px;padding: 10px 20px; background-color: #fff;">
                                        <div class="modal-header" style="border-bottom: none;">
                                        <h1 class="modal-title fs-5" style="font-weight: bold;" id="exampleModalLabel">Xóa danh mục này</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        Danh mục sẽ bị xóa vĩnh viễn khỏi trang web và không thể khôi phục, chấp nhận xóa?
                                        </div>
                                        <div class="modal-footer" style="border-top: none;">
                                        <button type="button" class="btn btn-secondary" style="border-radius: 10px;background-color: #fff;color: #000;" data-bs-dismiss="modal">Hủy</button>
                                        <button type="button" class="btn btn-primary"
                                                        style="font-weight: bold; border-radius: 10px; background-color: #5E17EB;"
                                                        onclick=" deleteCategory(<?=$category['CategoryID']?>)">Xóa</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <?php $i++;endforeach; ?> 
                                <?php endif; ?>                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>     
   
<script>
    function deleteCategory(CategoryID){
        window.location = 'index.php?actad=delete_categories&CategoryID='+CategoryID;
    }
</script>
<!-- ==============================CATEGORIES PAGE=============================== -->
