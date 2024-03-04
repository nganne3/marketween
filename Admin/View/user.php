<!-- ===========================USER PAGE============================= -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="bx bxs-user"></i>
                </span> Tài khoản
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="index.php?actad=add_user"><button type="button"
                                class="btn btn-gradient-primary btn-lg btn-block">
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
                        <h4 class="card-title">Danh sách tài khoản</h4>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tài khoản</th>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Vai trò</th>
                                        <th>Coins</th>
                                        <th>Người theo dõi</th>
                                        <th>Lượt theo dõi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($kq)&&(count($kq)>0)): ?>
                                    <?php $i=1; foreach($kq as $user): ?>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal<?=$user['UserID']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content"
                                                style="border-radius: 20px;padding: 10px 20px; background-color: #fff;">
                                                <div class="modal-header" style="border-bottom: none;">
                                                    <h1 class="modal-title fs-5" style="font-weight: bold;"
                                                        id="exampleModalLabel">Xóa người dùng
                                                        này</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Người dùng sẽ bị xóa vĩnh viễn khỏi trang web và không thể khôi phục,
                                                    chấp nhận xóa?
                                                </div>
                                                <div class="modal-footer" style="border-top: none;">
                                                    <button type="button" class="btn btn-secondary"
                                                        style="border-radius: 10px;background-color: #fff;color: #000;"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <button type="button" class="btn btn-primary"
                                                        style="font-weight: bold; border-radius: 10px; background-color: #5E17EB;"
                                                        onclick="deleteUser(<?=$user['UserID']?>)">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td>
                                            <img src="<?php echo USER_PATH; ?><?=$user['AvatarImage']?>" class="me-2"
                                                alt="image"> <?=$user['Username']?>
                                        </td>
                                        <td>#<?=$user['UserID']?></td>
                                        <td><?=$user['Email']?></td>
                                        <td>
                                            <?php 
                            switch ($user['Role']){
                                case 'admin':
                                    echo '<label class="badge badge-warning">Quản lý</label>';
                                    break;
                                case 'user':
                                    echo '<label class="badge badge-success">Khách hàng</label>';
                                    break;
                            }
                            ?>
                                        </td>
                                        <td><?=number_format($user['Coins'])?> Coins</i></td>
                                        <td class="text-center"><?=number_format($user['Followers'])?></td>
                                        <td class="text-center"><?=number_format($user['Following'])?></td>
                                        <td>
                                            <a href="index.php?actad=edit_user&UserID=<?=$user['UserID']?>"
                                                type="button" class="btn btn-outline-secondary btn-rounded btn-icon">
                                                <i class='bx bxs-pencil' style="margin-top:12px;"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-rounded btn-icon"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal<?=$user['UserID']?>">
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
            <script>
            function deleteUser(UserID) {
                window.location = 'index.php?actad=delete_user&UserID=' + UserID;
            }
            </script>
            <!-- ===========================END PAGE============================= -->