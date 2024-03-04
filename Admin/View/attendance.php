<!-- ===========================ATTENDANCE PAGE================================ -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="bx bx-history"></i>
                </span> Điểm danh
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
                    <form class="addAttendance" action="index.php?actad=add-attendance" method="POST">
                    <?php
                    $latestAttendance = attendance_getlastnew();

                    if ($latestAttendance) {
                        $latestTitle = $latestAttendance['Title'];
                        $latestDescription = $latestAttendance['Description'];
                        $latestPeriodicTime = $latestAttendance['PeriodicTime'];
                        $latestAmountCoins = $latestAttendance['Coins'];
                        $latestStatus = $latestAttendance['Status'];
                    } else {
                        echo "Không thể lấy thông tin mới nhất!";
                    }
                    ?>
                            <div class="row">
                            <div class="form-group col-md-6">
                                <label for="titleTask">Tiêu đề nhiệm vụ</label>
                                <input type="text" class="form-control" id="titleTask" name="titleTask" value="<?php echo htmlspecialchars($latestTitle); ?>">
                                <?php echo isset($titleError) ? '<div style="color: red;">' . $titleError . '</div>' : ''; ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="desTask">Mô tả</label>
                                <input type="text" class="form-control" id="desTask" name="desTask" value="<?php echo htmlspecialchars($latestDescription); ?>" >
                                <?php echo isset($descriptionError) ? '<div style="color: red;">' . $descriptionError . '</div>' : ''; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="periodicTime">Thời gian định kỳ</label>
                                <input type="time" class="form-control" id="periodicTime" name="periodicTime" value="<?php echo htmlspecialchars($latestPeriodicTime); ?>">
                                <?php echo isset($periodicTimeError) ? '<div style="color: red;">' . $periodicTimeError . '</div>' : ''; ?>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="amountCoins">Số Coins</label>
                                <input type="text" class="form-control" id="amountCoins" name="amountCoins" value="<?php echo htmlspecialchars($latestAmountCoins); ?>" pattern="\d*">
                                <?php echo isset($amountCoinsError) ? '<div style="color: red;">' . $amountCoinsError . '</div>' : ''; ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="statusAttendance">Trạng thái xuất hiện</label>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="statusAttendance" value="show" <?php echo ($latestStatus == 'show') ? 'checked' : ''; ?>> Hiển thị
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="statusAttendance" value="hide" <?php echo ($latestStatus == 'hide') ? 'checked' : ''; ?>> Ẩn đi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <?php echo isset($statusError) ? '<div style="color: red;">' . $statusError . '</div>' : ''; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" name="submit" class="btn btn-outline-light btn-lg btn-block"> Lưu thay đổi </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Nhật ký điểm danh</h4>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:10px;"></th>
                                        <th>Tài khoản</th>
                                        <th>ID</th>
                                        <th class="text-center">Thời gian điểm danh</th>
                                        <th>Nhiệm vụ</th>
                                        <th class="text-end">Đã nhận</th>
                                    </tr>
                                </thead>
                                <tbody style="height: 300px; overflow-y: auto; ">
                                    <?php if (isset($kq)&&(count($kq)>0)): ?>
                                    <?php $i=1; foreach($kq as $attendance): ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td>
                                            <img src="<?php echo USER_PATH; ?><?=$attendance['AvatarImage']?>"
                                                class="me-2" alt="image"> <?=$attendance['Username']?>
                                        </td>
                                        <td>#<?=$attendance['UserID']?></td>
                                        <td class="text-center"><?=$attendance['CreatedAt']?></td>
                                        <td class="text-start"><?=$attendance['Title']?></td>
                                        <td class="text-end"><?=number_format($attendance['Coins'])?> Coins</td>
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
    <!-- ===========================END ATTENDANCE PAGE================================ -->