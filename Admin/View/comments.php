<!-- =======================COMMENT PAGE======================== -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="bx bxs-comment"></i>
                </span> Bình luận
            </h3>
        </div>
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
                        <h4 class="card-title">Danh sách bình luận</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tài khoản</th>
                                        <th>Nội dung</th>
                                        <th>Thời gian gửi</th>
                                        <th>Cập nhật cuối cùng</th>
                                        <th>Sản phẩm</th>
                                        <th>Ẩn/Hiện</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($kq)&&(count($kq)>0)): ?>
                                    <?php $i=1; foreach($kq as $comment): ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td>
                                            <img src="<?php echo USER_PATH; ?><?=$comment['AvatarImage']?>"
                                                class="me-2" alt="image">
                                            <h6 class="mt-2"><?=$comment['Username']?></h6>
                                        </td>
                                        <td><?=$comment['Content']?></td>
                                        <td class="text-center"><?=$comment['CreatedAt']?>
                                        </td>
                                        <td class="text-center"><?=$comment['UpdatedAt']?>
                                        </td>
                                        <td>
                                            <img src="<?php echo PRODUCT_PATH; ?><?=$comment['ImageURL']?>"
                                                class="rounded-2 w-50 h-50" alt="image">
                                            <h6 class="mt-2"><?=$comment['Name']?></h6>
                                        </td>
                                        <form method="post" action="index.php?actad=update_comment">
                                            <input type="hidden" name="commentID" value="<?php echo $comment['CommentID']; ?>">
                                            <input type="hidden" name="currentStatus" value="<?php echo $comment['Status']; ?>">

                                            <td class="text-center">
                                                <button type="submit" class="btn btn-outline-secondary btn-rounded btn-icon">
                                                    <?php 
                                                    switch ($comment['Status']){
                                                        case 'show':
                                                            echo '<i class="bx bx-show text-success"></i>';
                                                            break;
                                                        case 'hide':
                                                            echo '<i class="bx bx-low-vision text-success"></i>';
                                                            break;
                                                    }
                                                    ?>
                                                </button>
                                            </td>
                                        </form>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-rounded btn-icon"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal<?=$comment['CommentID']?>">
                                                <i class='bx bx-trash-alt'></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal<?=$comment['CommentID']?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="border-radius: 20px;padding: 10px 20px; background-color: #fff;">
                                                <div class="modal-header" style="border-bottom: none;">
                                                    <h1 class="modal-title fs-5" style="font-weight: bold;" id="exampleModalLabel">Xóa bình luận
                                                        này</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bình luận sẽ bị xóa vĩnh viễn khỏi trang web và không thể khôi phục, chấp nhận xóa?
                                                </div>
                                                <div class="modal-footer" style="border-top: none;">
                                                    <button type="button" class="btn btn-secondary"
                                                        style="border-radius: 10px;background-color: #fff;color: #000;"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                        <button type="button" class="btn btn-primary"
                                                        style="font-weight: bold; border-radius: 10px; background-color: #5E17EB;"
                                                        onclick="deletecmt(<?=$comment['CommentID']?>)">Xóa</button>
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
            function deletecmt(CommentID) {
                window.location = 'index.php?actad=delete_comment&CommentID=' + CommentID;
            }
            </script>
    <!-- =======================END COMMENT PAGE======================== -->
<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        var updateCommentForms = document.querySelectorAll('.update-comment-form');

        updateCommentForms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                // console.log(1);
                event.preventDefault();

                var formData = new FormData(form);

                fetch('index.php?actad=update_comments', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    var button = form.querySelector('button');
                    var newStatus = data.newStatus;

                    if (newStatus === 'show') {
                        button.innerHTML = '<i class="bx bx-show text-success"></i>';
                    } else {
                        button.innerHTML = '<i class="bx bx-low-vision text-success"></i>';
                    }
                })
                // .catch(error => {
                //     console.error('Lỗi khi cập nhật trạng thái:', error);
                // });
            });
        });
    });

    function updateCommentStatus(form) {
    var formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Dữ liệu trả về:', data);

        var button = form.querySelector('button');
        console.log('Button:', button);

        var newStatus = data.newStatus;
        console.log('New Status:', newStatus);

        if (newStatus === 'show') {
            button.innerHTML = '<i class="bx bx-show text-success"></i>';
        } else {
            button.innerHTML = '<i class="bx bx-low-vision text-success"></i>';
        }
    })
    // .catch(error => {
    //     console.error('Lỗi khi cập nhật trạng thái:', error);
    // });

    return false;
} -->




</script>
