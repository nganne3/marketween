<!-- ==============================PRODUCT PAGE==================================== -->

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="bx bxs-image-alt"></i>
                </span> Sản phẩm
            </h3>
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
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="index.php?actad=add_products"><button type="button"
                                class="btn btn-gradient-primary btn-lg btn-block">
                                <i class="bx bx-plus"></i> Thêm mới </button></a>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Danh sách sản phẩm</h4>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Sản phẩm</th>
                                        <th>ID</th>
                                        <th>Chủ sở hữu</th>
                                        <th>Thể loại</th>
                                        <th>Bộ sưu tập</th>
                                        <th class="text-center">Giá</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($kq)&&(count($kq)>0)): ?>
                                    <?php $i=1; foreach($kq as $product): ?>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal<?=$product['ProductID']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content"
                                                style="border-radius: 20px;padding: 10px 20px; background-color: #fff;">
                                                <div class="modal-header" style="border-bottom: none;">
                                                    <h1 class="modal-title fs-5" style="font-weight: bold;"
                                                        id="exampleModalLabel">Xóa sản phẩm
                                                        này</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Sản phẩm sẽ bị xóa vĩnh viễn khỏi trang web và không thể khôi phục,
                                                    chấp nhận xóa?
                                                </div>
                                                <div class="modal-footer" style="border-top: none;">
                                                    <button type="button" class="btn btn-secondary"
                                                        style="border-radius: 10px;background-color: #fff;color: #000;"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <a href="index.php?actad=delete_product&ProductID=<?=$product['ProductID']?>" type="button" class="btn btn-primary"
                                                        style="font-weight: bold; border-radius: 10px; background-color: #5E17EB;"
                                                        >Xóa</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td>
                                            <img src="<?php echo PRODUCT_PATH; ?><?=$product['ImageURL']?>"
                                                class="rounded-2 w-50 h-50" alt="image">
                                            <h6 class="mt-2"><?=$product['NameProduct']?></h6>
                                        </td>
                                        <td>#<?=$product['ProductID']?></td>
                                        <td>
                                            <img src="<?php echo USER_PATH; ?><?=$product['AvatarImage']?>" class="me-2"
                                                alt="image"> <?=$product['Username']?>
                                        </td>
                                        <td><?=$product['NameCategory']?></td>
                                        <td class="fw-bold"><?=$product['NameCollection']?></td>
                                        <td class="text-center">
                                            <?php if($product['ListedPrice']==null){
                                            echo '<button type="button" class="btn btn-gradient-danger btn-sm">Chưa có giá</button>';
                                         }else{
                                            echo number_format($product['ListedPrice']).' Coins';
                                        }?>
                                        </td>
                                        <td>
                                            <a href="index.php?actad=edit_product&ProductID=<?=$product['ProductID']?>"
                                                type="button" class="btn btn-outline-secondary btn-rounded btn-icon">
                                                <i class='bx bxs-pencil' style="margin-top:12px;"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-rounded btn-icon"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal<?=$product['ProductID']?>">
                                                <i class='bx bx-trash-alt'></i>
                                            </button>
                                        </td>
                                    </tr>
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
    function delete_products(ProductID) {
        window.location.href = 'index.php?actad=products&ProductID=' + ProductID;
    }
    </script>
    <!-- ==============================END PAGE==================================== -->