<!-- =======================COLLECTIONS PAGE============================== -->
<div class="main-panel">

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="bx bxs-folder"></i>
                </span> Bộ sưu tập
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="index.php?actad=add_collections"><button type="button"
                                class="btn btn-gradient-primary btn-lg btn-block">
                                <i class="bx bx-plus"></i> Thêm mới </button></a>
                    </li>
                </ul>
            </nav>
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
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Danh sách bộ sưu tập</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Bộ sưu tập</th>
                                        <th>ID</th>
                                        <th>Giá sàn</th>
                                        <th>Chủ sở hữu</th>
                                        <th>Lượt xem</th>
                                        <th>Đã bán</th>
                                        <th>Doanh thu</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($kq)&&(count($kq)>0)): ?>
                                    <?php $i=1; foreach($kq as $collection): ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td>
                                            <img src="<?php echo COLLECTION_PATH; ?><?=$collection['LogoImage']?>"
                                                class="rounded-2 w-50 h-50" alt="image">
                                            <h6 class="mt-2"><?=$collection['Name']?></h6>
                                        </td>
                                        <td>#<?=$collection['CollectionID']?></td>
                                        <td class="text-center"><?=number_format($collection['Floor'])?> Coins</td>
                                        <td>
                                            <img src="<?php echo USER_PATH; ?><?=$collection['AvatarImage']?>" class="me-2" alt="image"> <?=$collection['Username']?>
                                        </td>
                                        <td class="text-center"><?=number_format($collection['Views'])?></td>
                                        <td class="text-center"><?=number_format($collection['Sold'])?></td>
                                        <td class="text-center"><?=number_format($collection['Volume'])?> Coins</td>
                                        <td>
                                            <a href="index.php?actad=edit_collection&CollectionID=<?=$collection['CollectionID']?>"
                                                class="btn btn-outline-secondary btn-rounded btn-icon">
                                                <i class='bx bxs-pencil' style="margin-top:12px;"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-rounded btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$collection['CollectionID']?>">
                                                <i class='bx bx-trash-alt'></i>
                                            </button>
                                        </td>

                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal<?=$collection['CollectionID']?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="border-radius: 20px;padding: 10px 20px; background-color: #fff;">
                                                <div class="modal-header" style="border-bottom: none;">
                                                    <h1 class="modal-title fs-5" style="font-weight: bold;" id="exampleModalLabel">Xóa bộ sưu
                                                        tập này</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bộ sưu tập sẽ bị xóa vĩnh viễn khỏi trang web và không thể khôi phục, chấp nhận xóa?
                                                </div>
                                                <div class="modal-footer" style="border-top: none;">
                                                    <button type="button" class="btn btn-secondary"
                                                        style="border-radius: 10px;background-color: #fff;color: #000;"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <button type="button" class="btn btn-primary"
                                                        style="font-weight: bold; border-radius: 10px; background-color: #5E17EB;"
                                                        onclick="deleteUser(<?=$collection['CollectionID']?>)">Xóa</button>
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
            function deleteUser(CollectionID) {
                window.location = 'index.php?actad=delete_collection&CollectionID=' + CollectionID;
            }
            </script>
    <!-- ====================================END COLLECTIONS================================= -->