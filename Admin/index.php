<?php 
    session_start();
    ob_start();

    include "../Config/database_admin.php";
    include "../Config/path_admin.php";

    include_once '../Admin/Model/m_user.php';
    include_once '../Admin/Model/m_categories.php';
    include_once '../Admin/Model/m_comment.php';
    include_once '../Admin/Model/m_product.php';
    include_once '../Admin/Model/m_collection.php';
    include_once '../Admin/Model/m_attendance.php';
    
    connectdata();

    include "../Admin/View/header.php";
    include "../Admin/View/siderbar.php";

    if (isset($_GET['actad'])){
        $ngan1m5Click = $_GET['actad'];
        switch($ngan1m5Click)
        {
            case 'home':
                $AmountUser = user_Amount();
                $AmountProduct = product_Amount();
                $AmountCollection = collection_Amount();
                $AmountComment = comment_Amount();
    
                $topCoins = user_getUserMaxCoins(5);
                $topVolume = user_getUserMaxVolume(5);
                $topSold = user_getUserMaxSold(5);
                $topFollowers = user_getUserMaxFollowers(5);
                include_once "../Admin/View/home.php";
                break;

            case 'products':
                $kq = product_getAll();
                include_once "../Admin/View/products.php";
                break;

            case 'collections':
                $kq = collection_getAll();
                include_once "../Admin/View/collections.php";
                break;

            case 'user':
                $kq = user_getAll();
                include_once "../Admin/View/user.php";
                break;

            case 'comments':
                $kq = comment_getAll();
                include_once "../Admin/View/comments.php";
                break;
            
            case 'update_comment':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $commentID = $_POST['commentID'];
                    $currentStatus = $_POST['currentStatus'];
                
                    if ($currentStatus == 'show') {
                        $newStatus = 'hide';
                    } else {
                        $newStatus = 'show';
                    }
                
                    if (comment_toggleStatus($commentID, $newStatus)) {

                        header('location: index.php?actad=comments');
                    }
                }
                break;

            case 'delete_comment':
                if (isset($_GET['CommentID'])) {
                    $commentID = $_GET['CommentID'];
            
                    $result = delete_comment($commentID);
            
                    if ($result) {
                        $_SESSION['thongbao'] = 'Đã xóa comment!';
                    } else {
                        $_SESSION['loi'] = 'Có lỗi xảy ra! Vui lòng thử lại sau.';
                    }
            
                    header('location: index.php?actad=comments');
                }
                break;
                
            case 'categories':
                $kq = categories_getAll();
                include_once "../Admin/View/categories.php";
                break;

            case 'attendance':
                $kq = attendance_getAll();
                $attendance = attendance_control();
                include_once "../Admin/View/attendance.php";
                break;

            case 'add-attendance':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $title = isset($_POST['titleTask']) ? trim($_POST['titleTask']) : '';
                    $description = isset($_POST['desTask']) ? trim($_POST['desTask']) : '';
                    $periodicTime = isset($_POST['periodicTime']) ? trim($_POST['periodicTime']) : '';
                    $amountCoins = isset($_POST['amountCoins']) ? trim($_POST['amountCoins']) : '';
                    $status = isset($_POST['statusAttendance']) ? trim($_POST['statusAttendance']) : '';
                
                    $titleError = $descriptionError = $amountCoinsError = '';
                
                    // Kiểm tra Tiêu đề nhiệm vụ
                    if (empty($title)) {
                        $titleError = 'Tiêu đề nhiệm vụ không được để trống.';
                    } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $title)) {
                        $titleError = 'Tiêu đề nhiệm vụ chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                    }
                
                    // Kiểm tra Mô tả
                    if (empty($description)) {
                        $descriptionError = 'Mô tả không được để trống.';
                    } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $description)) {
                        $descriptionError = 'Mô tả chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                    }

                    // kiểm tra lổi thời gian định kì
                    if (empty($periodicTime)) {
                        $periodicTimeError = '<div style="color: red;">Thời gian định kỳ không được để trống.</div>';
                    }
                
                    // Kiểm tra Số Coins
                    if (empty($amountCoins)) {
                        $amountCoinsError = 'Số Coins không được để trống.';
                    } elseif (!ctype_digit($amountCoins) || $amountCoins < 0) {
                        $amountCoinsError = 'Số Coins không hợp lệ.';
                    } else {
                        $amountCoins = (int)$amountCoins;
                    }
                
                    // Kiểm tra không được để trống trạng thái
                    if (empty($status)) {
                        $statusError = '<div style="color: red;">Trạng thái không được để trống.</div>';
                    }

                    // Nếu không có lỗi, thực hiện thêm mới
                    if (empty($titleError) && empty($descriptionError) && empty($amountCoinsError)) {
                
                        $result = addNewAttendance($title, $description, $periodicTime, $amountCoins, $status);
                
                        if ($result) {
                            $_SESSION['thongbao'] = 'Thêm mới thành công!';
                            header('location: index.php?actad=attendance');
                            exit();
                        } else {
                            $_SESSION['loi'] = 'Không thể thêm mới. Vui lòng kiểm tra lại!';
                            header('location: index.php?actad=attendance');
                            exit;
                        }
                    }
                }
                include_once "../Admin/View/attendance.php";
                break;
            case 'add_user':
                if(isset($_POST['submit'])){
                    $Username = $_POST['Username'];
                    $Email = $_POST['Email'];
                    $Role = $_POST['Role'];
                    $Coins = $_POST['Coins'];
                    $Password = $_POST['Password'];
                    $Bio = $_POST['Bio'];
                    $AvatarImage = basename($_FILES["AvatarImage"]["name"]);
                    $CoverImage = basename($_FILES["CoverImage"]["name"]);
                    
                    // Upload avatar
                $target_dir = USER_PATH;
                $newFileName = uniqid() . "_" . $AvatarImage;
                $target_file = $target_dir . $newFileName;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Kiểm tra Username
                if (empty($Username)) {
                    $UsernameError = 'Tên người dùng không được để trống.';
                } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Username)) {
                    $UsernameError = 'Tên người dùng chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                }

                // Kiểm tra Email
                if (empty($Email)) {
                    $EmailError = 'Email không được để trống.';
                } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                    $EmailError = 'Email không đúng định dạng.';
                }

                // Kiểm tra Coins
                if (empty($Coins)) {
                    $CoinsError = 'Coins không được để trống.';
                } elseif (!ctype_digit($Coins) || $Coins < 0) {
                    $CoinsError = 'Coins không hợp lệ.';
                } else {
                    $Coins = (int)$Coins;
                }

                // Kiểm tra Password
                if (empty($Password)) {
                    $PasswordError = 'Mật khẩu không được để trống.';
                } elseif (strlen($Password) < 6) {                      // Tự thay đổi điều kiện pass 
                    $PasswordError = 'Mật khẩu phải có ít nhất 6 kí tự.';
                }

                // Kiểm tra Bio
                // if (empty($Bio)) {
                //     $BioError = 'Tiểu sử không được để trống.';
                // } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Bio)) {
                //     $BioError = 'Tiểu sử chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                // }


                // Kiểm tra xem có phải $uploadOk được đặt thành 0 do lỗi không
                if ($uploadOk == 0) {
                    echo "Không thể tải ảnh đại diện. Vui lòng thử lại sau!";
                // nếu mọi thứ đều ổn, hãy thử tải tập tin lên
                } else {
                    // Kiểm tra lỗi
                    if ($_FILES["AvatarImage"]["error"] != 0) {
                        // Không có ảnh đại diện, sử dụng ảnh đại diện mặc định
                        $newFileName = 'avatar_default.jpg';
                    } else {
                        if (move_uploaded_file($_FILES["AvatarImage"]["tmp_name"], $target_file)) {
                            echo "";
                        } else {
                            echo "Không thể tải ảnh đại diện. Vui lòng thử lại sau!";
                        }
                    }
                }

                // Upload bìa
                $target_dir2 = USER_PATH;
                $newFileName2 = uniqid() . "_" . $CoverImage;
                $target_file2 = $target_dir2 . $newFileName2;
                $uploadOk2 = 1;
                $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));

                // Kiểm tra xem có phải $uploadOk được đặt thành 0 do lỗi không
                if ($uploadOk2 == 0) {
                    echo "Không thể tải ảnh bìa. Vui lòng thử lại sau!";
                // nếu mọi thứ đều ổn, hãy thử tải tập tin lên
                } else {
                    // Kiểm tra lỗi
                    if ($_FILES["CoverImage"]["error"] != 0) {
                        // Không có ảnh bìa, sử dụng ảnh bìa mặc định
                        $newFileName2 = 'hinh_bia.jpg';
                    } else {
                        if (move_uploaded_file($_FILES["CoverImage"]["tmp_name"], $target_file2)) {
                            echo "";
                        } else {
                            echo "Không thể tải ảnh bìa. Vui lòng thử lại sau!";
                        }
                    }
                }

                if (isset($UsernameError) || isset($EmailError) || isset($CoinsError) || isset($PasswordError)) {
                    include_once "../Admin/View/add_user.php";
                } else {
                    $kq = user_checkEmail($Email);
                    if($kq){
                        // đúng, bị trùng, không thêm
                        $_SESSION['loi'] = 'Địa chỉ email <strong>'.$Email.'</strong> đã được đăng ký!';
                    }else{
                        // sai, ko trùng, thêm người dùng
                        user_add($Username, $Email, $Role, $Coins, $Password, $Bio, $newFileName, $newFileName2);
                        $_SESSION['thongbao'] = 'Thêm người dùng mới thành công!';
                    }
                }
                    
                }
                include_once "../Admin/View/add_user.php";
                break;
                case 'edit_user':
                    $UserID = '';
                
                    if (isset($_GET['UserID']) && !empty($_GET['UserID'])) {
                        $UserID = intval($_GET['UserID']);
                    }
                    $editUser = [];
                    if (!empty($UserID)) {
                        $editUser = user_getById($UserID);
                    }
                
                    if (isset($_POST['submit'])) {
                        $UserID = $_POST['UserID'];
                        $Username = $_POST['Username'];
                        $Email = $_POST['Email'];
                        $Role = $_POST['Role'];
                        $Coins = $_POST['Coins'];
                        $Password = $_POST['Password'];
                        $Bio = $_POST['Bio'];
                        $AvatarImage = basename($_FILES["AvatarImage"]["name"]);
                        $CoverImage = basename($_FILES["CoverImage"]["name"]);
                    
                    // Kiểm tra Username
                    if (empty($Username)) {
                        $UsernameError = 'Tên người dùng không được để trống.';
                    } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Username)) {
                        $UsernameError = 'Tên người dùng chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                    }

                    // Kiểm tra Email
                    if (empty($Email)) {
                        $EmailError = 'Email không được để trống.';
                    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                        $EmailError = 'Email không đúng định dạng.';
                    }

                    // Kiểm tra Coins
                    if (empty($Coins)) {
                        $CoinsError = 'Coins không được để trống.';
                    } elseif (!ctype_digit($Coins) || $Coins < 0) {
                        $CoinsError = 'Coins không hợp lệ.';
                    } else {
                        $Coins = (int)$Coins;
                    }

                    // Kiểm tra Password
                    if (empty($Password)) {
                        $PasswordError = 'Mật khẩu không được để trống.';
                    } elseif (strlen($Password) < 6) {                      // Tự thay đổi điều kiện pass 
                        $PasswordError = 'Mật khẩu phải có ít nhất 6 kí tự.';
                    }

                    // Kiểm tra Bio
                    // if (empty($Bio)) {
                    //     $BioError = 'Tiểu sử không được để trống.';
                    // } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Bio)) {
                    //     $BioError = 'Tiểu sử chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                    // }
                    $target_dir = USER_PATH;
                    $newFileName = uniqid() . "_" . $AvatarImage;
                    $target_file = $target_dir . $newFileName;
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
                    if ($uploadOk == 0) {
                        echo "Không thể tải ảnh đại diện. Vui lòng thử lại sau!";
                    } else {
                        if ($_FILES["AvatarImage"]["error"] != 0) {
                            $newFileName = $editUser['AvatarImage'];
                        } else {
                            if (move_uploaded_file($_FILES["AvatarImage"]["tmp_name"], $target_file)) {
                                echo "";
                            } else {
                                echo "Không thể tải ảnh đại diện. Vui lòng thử lại sau!";
                            }
                        }
                    }
    
                    $target_dir2 = USER_PATH;
                    $newFileName2 = uniqid() . "_" . $CoverImage;
                    $target_file2 = $target_dir2 . $newFileName2;
                    $uploadOk2 = 1;
                    $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
    
                    if ($uploadOk2 == 0) {
                        echo "Không thể tải ảnh bìa. Vui lòng thử lại sau!";
                    } else {
                        if ($_FILES["CoverImage"]["error"] != 0) {
                            $newFileName2 = $editUser['CoverImage'];
                        } else {
                            if (move_uploaded_file($_FILES["CoverImage"]["tmp_name"], $target_file2)) {
                                echo "";
                            } else {
                                echo "Không thể tải ảnh bìa. Vui lòng thử lại sau!";
                            }
                        }
                    }
                    
                    if (isset($UsernameError) || isset($EmailError) || isset($CoinsError) || isset($PasswordError) ) {
                        $editUser = user_getById($UserID);
                        include_once "../Admin/View/edit_user.php";
                    } else {
                        if (!empty($UserID)) {
                            $kq = user_checkEmail($Email);
                            if ($kq) {
                                user_edit($Username, $Email, $Role, $Coins, $Password, $Bio, $newFileName, $newFileName2, $UserID);
                                $_SESSION['thongbao'] = 'Thông tin thay đổi đã được lưu lại!';
                            }
                        }
                
                    }
                    $editUser = user_getById($UserID);

                    }
                
                    include_once "../Admin/View/edit_user.php";
                    break;
                case 'delete_user':
                    if (isset($_GET['UserID'])) {
                        $userID = $_GET['UserID'];
                        $kq = user_delete($userID);
                        var_dump($userID);
                        if ($kq) {
                            $_SESSION['thongbao'] = 'Đã xóa người dùng!';
                        } else {
                            $_SESSION['loi'] = 'Có lỗi xảy ra! Vui lòng thử lại sau!';
                        }
                
                        header('Location: index.php?actad=user');
                        exit();
                    }
                    break;

            case 'add_collections':
                if(isset($_POST['submit'])){
                    $CollectionID = isset($_POST['CollectionID']) ? $_POST['CollectionID'] : null;
                    $Name = $_POST['Name'];
                    $Username = $_POST['Username'];
                    $Description = $_POST['Description'];
                    $LogoImage = basename($_FILES["LogoImage"]["name"]);
                    $FeturedImage = basename($_FILES["FeturedImage"]["name"]);
                    $BannerImage = basename($_FILES["BannerImage"]["name"]);
                    
                $target_dir = COLLECTION_PATH;
                $newFileName = uniqid() . "_" . $LogoImage;
                $target_file = $target_dir . $newFileName;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Kiểm tra Name
                if (empty($Name)) {
                    $NameError = 'Tên hiển thị không được để trống.';
                } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Name)) {
                    $NameError = 'Tên hiển thị chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                }

                // Kiểm tra Username
                if (empty($Username)) {
                    $UsernameError = 'Tên người sở hữu không được để trống.';
                } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Username)) {
                    $UsernameError = 'Tên người sở hữu chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                }

                // Kiểm tra Description
                // if (empty($Description)) {
                //     $DescriptionError = 'Mô tả không được để trống.';
                // } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Description)) {
                //     $DescriptionError = 'Mo tả chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                // }

                if ($uploadOk == 0) {
                    echo "Không thể tải ảnh logo. Vui lòng thử lại sau!";
                } else {
                    if ($_FILES["LogoImage"]["error"] != 0) {
                        $tbloi = 'Không thể tải ảnh. Vui lòng thử lại sau!';
                    } else {
                        if (move_uploaded_file($_FILES["LogoImage"]["tmp_name"], $target_file)) {
                            echo "";
                        } else {
                            echo "Không thể tải ảnh logo. Vui lòng thử lại sau!";
                        }
                    }
                }

                $target_dir2 = COLLECTION_PATH;
                $newFileName2 = uniqid() . "_" . $FeturedImage;
                $target_file2 = $target_dir2 . $newFileName2;
                $uploadOk2 = 1;
                $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));

                if ($uploadOk2 == 0) {
                    echo "Không thể tải ảnh fetured. Vui lòng thử lại sau!";
                } else {
                    if ($_FILES["FeturedImage"]["error"] != 0) {
                        $tbloi2 = 'Không thể tải ảnh. Vui lòng thử lại sau!';
                    } else {
                        if (move_uploaded_file($_FILES["FeturedImage"]["tmp_name"], $target_file2)) {
                            echo "";
                        } else {
                            echo "Không thể tải ảnh Fetured. Vui lòng thử lại sau!";
                        }
                    }
                }

                $target_dir3 = COLLECTION_PATH;
                $newFileName3 = uniqid() . "_" . $BannerImage;
                $target_file3 = $target_dir3 . $newFileName3;
                $uploadOk3 = 1;
                $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));

                if ($uploadOk3 == 0) {
                    echo "Không thể tải ảnh logo. Vui lòng thử lại sau!";
                } else {
                    if ($_FILES["BannerImage"]["error"] != 0) {
                        $tbloi3 = 'Không thể tải ảnh. Vui lòng thử lại sau!';
                    } else {
                        if (move_uploaded_file($_FILES["BannerImage"]["tmp_name"], $target_file3)) {
                            echo "";
                        } else {
                            echo "Không thể tải ảnh Banner. Vui lòng thử lại sau!";
                        }
                    }
                }
                 include_once '../Admin/Model/m_collection.php';
                // Không có lổi thêm bộ sưu tập mới
                if( isset($NameError) || isset($UserameError)){
                    include_once "../Admin/View/add_collections.php";
                }else{
                    $kq =  collection_checkName($Name);

                    if($kq){
                        $_SESSION['loi'] = 'Tên bộ sưu tập <strong>'.$Name.'</strong> đã được đăng ký!';
                    }else{
                        collection_add($Name, $Username, $Description, $LogoImage, $FeturedImage, $BannerImage);
                        $_SESSION['thongbao'] = 'Thêm bộ sưu tập mới thành công!';
                    }
                }
                }
                include_once "../Admin/View/add_collections.php";
                break;
                
                case 'edit_collection':
                    $CollectionID = '';
                
                    if (isset($_GET['CollectionID']) && !empty($_GET['CollectionID'])) {
                        $CollectionID = intval($_GET['CollectionID']);
                    }
                
                    $editCollection = [];
                
                    if (!empty($CollectionID)) {
                        $editCollection = getCollectionById($CollectionID);
                    }
                
                    if (isset($_POST['submit'])) {
                        $CollectionID = $_POST['CollectionID'];
                        $Name = $_POST['Name'];
                        $Username = $_POST['Username'];

                        $Description = $_POST['Description'];

                        // Kiểm tra Name
                        if (empty($Name)) {
                            $NameError = 'Tên hiển thị không được để trống.';
                        } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Name)) {
                            $NameError = 'Tên hiển thị chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                        }

                        // Kiểm tra Username
                        if (empty($Username)) {
                            $UsernameError = 'Tên người sở hữu không được để trống.';
                        } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Username)) {
                            $UsernameError = 'Tên người sở hữu chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                        }

                        // Kiểm tra Description
                        // if (empty($Description)) {
                        //     $DescriptionError = 'Mô tả không được để trống.';
                        // } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Description)) {
                        //     $DescriptionError = 'Mo tả chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                        // }

                        $target_dir = COLLECTION_PATH;
                        $LogoImage = basename($_FILES["LogoImage"]["name"]);
                        $newFileName = uniqid() . "_" . $LogoImage;
                        $target_file = $target_dir . $newFileName;
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                
                        if ($uploadOk == 0) {
                            echo "Không thể tải ảnh logo. Vui lòng thử lại sau!";
                        } else {
                            if ($_FILES["LogoImage"]["error"] != 0) {
                                $newFileName = '1b.jpg';
                            } else {
                                if (move_uploaded_file($_FILES["LogoImage"]["tmp_name"], $target_file)) {
                                    echo "";
                                } else {
                                    echo "Không thể tải ảnh logo. Vui lòng thử lại sau!";
                                }
                            }
                        }
                        
                        $BannerImage = basename($_FILES["BannerImage"]["name"]);
                        $newFileName2 = uniqid() . "_" . $BannerImage;
                        $target_file2 = $target_dir . $newFileName2;
                        $uploadOk2 = 1;
                        $imageFileType2 = strtolower(pathinfo($target_file2, PATHINFO_EXTENSION));
                
                        if ($uploadOk2 == 0) {
                            echo "Không thể tải ảnh banner. Vui lòng thử lại sau!";
                        } else {
                            if ($_FILES["BannerImage"]["error"] != 0) {
                                $newFileName2 = '1.jpg';
                            } else {
                                if (move_uploaded_file($_FILES["BannerImage"]["tmp_name"], $target_file2)) {
                                    echo "";
                                } else {
                                    echo "Không thể tải ảnh banner. Vui lòng thử lại sau!";
                                }
                            }
                        }
                        
                        $FeaturedImage = basename($_FILES["FeaturedImage"]["name"]);
                        $newFileName3 = uniqid() . "_" . $FeaturedImage;
                        $target_file3 = $target_dir . $newFileName3;
                        $uploadOk3 = 1;
                        $imageFileType3 = strtolower(pathinfo($target_file3, PATHINFO_EXTENSION));

                        if ($uploadOk3 == 0) {
                            echo "Không thể tải ảnh nổi bật. Vui lòng thử lại sau!";
                        } else {
                            if ($_FILES["FeaturedImage"]["error"] != 0) {
                                $newFileName3 = '1v.jpg';
                            } else {
                                if (move_uploaded_file($_FILES["FeaturedImage"]["tmp_name"], $target_file3)) {
                                    echo "";
                                } else {
                                    echo "Không thể tải ảnh nổi bật. Vui lòng thử lại sau!";
                                }
                            }
                        }
                        if( isset($NameError) || isset($UserameError)){
                            $editCollection = getCollectionById($CollectionID);
                            include_once "../Admin/View/edit_collections.php";
                        }else{
                        editCollection($Name, $Description, $newFileName, $newFileName3, $newFileName2, $CollectionID);
                        $_SESSION['thongbao'] = 'Thông tin thay đổi đã được lưu lại!';
                        }

                    }
                    $editCollection = getCollectionById($CollectionID);

                    include_once "../Admin/View/edit_collections.php";
                    break;
                

                case 'delete_collection':
                    if (isset($_GET['CollectionID'])) {
                        $collectionID = $_GET['CollectionID'];
                
                        $kq = collection_delete($collectionID);
                
                        if ($kq) {
                            $_SESSION['thongbao'] = 'Đã xóa bộ sưu tập!';
                        } else {
                            $_SESSION['loi'] = "Có lỗi xảy ra! Vui lòng thử lại sau!";
                        }
                
                        header('location: index.php?actad=collections');
                    }
                    break;
                
                
                    case 'add_products':
                        if (isset($_POST['submit'])) {
                            $Name = $_POST['Name'];
                            $ListedPrice = $_POST['ListedPrice'];
                            $Description = $_POST['Description'];
                            $Category = $_POST['Category'];
                            $CollectionID = $_POST['CollectionID'];
                            $ImageURL = basename($_FILES["ImageURL"]["name"]);
                    
                            $target_dir = PRODUCT_PATH;
                            $newFileName = uniqid() . "_" . $ImageURL;
                            $target_file = $target_dir . $newFileName;
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    
                            // Kiểm tra Name
                            if (empty($Name)) {
                                $NameError = 'Tên sản phẩm không được để trống.';
                            } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Name)) {
                                $NameError = 'Tên sản phẩm chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                            }

                            // Kiểm tra ListedPrice
                            if (empty($ListedPrice)) {
                                $ListedPriceError = 'Giá không được để trống.';
                            } elseif (!is_numeric($ListedPrice) || $ListedPrice < 0) {
                                $ListedPriceError = 'Giá không hợp lệ. Giá phải là số và phải lớn hơn 0.';
                            } else {
                                $ListedPrice = (float)$ListedPrice;
                            }

                            // Kiểm tra Description
                            if (empty($Description)) {
                                $DescriptionError = 'Mô tả không được để trống.';
                            } elseif (strlen($Description) > 200) {
                                $DescriptionError = 'Mô tả phải ngắn hơn 200 ký tự.';
                            }

                            // không có lổi thêm sản phẩm
                            if(isset($NameError) || isset($ListedPriceError) || isset($DescriptionError) ){
                                include_once "../Admin/View/add_products.php";
                            }else{
                            if ($uploadOk == 0) {
                                $_SESSION['loi'] = "Không thể tải ảnh sản phẩm. Vui lòng thử lại sau!";
                            } else {
                                if ($_FILES["ImageURL"]["error"] != 0) {
                                    $_SESSION['loi'] = 'Vui lòng chọn ảnh sản phẩm!';
                                } else {
                                    if (move_uploaded_file($_FILES["ImageURL"]["tmp_name"], $target_file)) {
                                        $kq = product_checkName($Name);
                                        if ($kq) {
                                            $_SESSION['loi'] = 'Tên sản phẩm <strong>' . $Name . '</strong> đã được đăng ký bán!';
                                        } else {
                                            $newProduct = addProduct($Name, $ListedPrice, $Description, $Category, $CollectionID, $newFileName);
                    
                                            if ($newProduct) {
                                                $_SESSION['thongbao'] = 'Thêm sản phẩm mới thành công!';
                                                $kq = product_getAll();  
                                                include_once "../Admin/View/products.php";
                                                exit();
                                            } else {
                                                $_SESSION['loi'] = 'Không thể thêm sản phẩm. Vui lòng kiểm tra lại!';
                                            }
                                        }
                                    } else {
                                        $_SESSION['loi'] = "Không thể tải ảnh sản phẩm. Vui lòng thử lại sau!";
                                    }
                                }
                            }
                        }
                        }
                    
                        include_once "../Admin/View/add_products.php";
                        break;
                    
                    case 'edit_product':
                        if (isset($_GET['ProductID'])) {
                            $productID = $_GET['ProductID'];
                    
                            $product = getProductDetails($productID);
                    
                            if (!$product) {
                                $_SESSION['loi'] = 'Sản phẩm không tồn tại.';
                                header('location: index.php?actad=collections');
                                exit;
                            }
                    
                            if (isset($_POST['submit'])) {
                                $Name = $_POST['Name'];
                                $ListedPrice = $_POST['ListedPrice'];
                                $Description = $_POST['Description'];
                                $Category = $_POST['Category'];
                                $CollectionID = $_POST['CollectionID'];
                    
                                // Kiểm tra Name
                                if (empty($Name)) {
                                    $NameError = 'Tên sản phẩm không được để trống.';
                                } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $Name)) {
                                    $NameError = 'Tên sản phẩm chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                                }

                                // Kiểm tra ListedPrice
                                if (empty($ListedPrice)) {
                                    $ListedPriceError = 'Giá không được để trống.';
                                } elseif (!is_numeric($ListedPrice) || $ListedPrice < 0) {
                                    $ListedPriceError = 'Giá không hợp lệ. Giá phải là số và phải lớn hơn 0.';
                                } else {
                                    $ListedPrice = (float)$ListedPrice;
                                }

                                // Kiểm tra Description
                                if (empty($Description)) {
                                    $DescriptionError = 'Mô tả không được để trống.';
                                } elseif (strlen($Description) > 200) {
                                    $DescriptionError = 'Mô tả phải ngắn hơn 200 ký tự.';
                                }

                                if ($_FILES["ImageURL"]["error"] == 0) {
                                    $ImageURL = basename($_FILES["ImageURL"]["name"]);
                    
                                    $target_dir = PRODUCT_PATH;
                                    $newFileName = uniqid() . "_" . $ImageURL;
                                    $target_file = $target_dir . $newFileName;
                    
                                    if (move_uploaded_file($_FILES["ImageURL"]["tmp_name"], $target_file)) {
                                        if (file_exists($target_dir . $product['ImageURL'])) {
                                            unlink($target_dir . $product['ImageURL']);
                                        }
                                    } else {
                                        $_SESSION['loi'] = "Không thể tải ảnh sản phẩm. Vui lòng thử lại sau!";
                                        header('location: index.php?actad=edit_product&ProductID=' . $productID);
                                        exit;
                                    }
                                } else {
                                    $ImageURL = $product['ImageURL'];
                                }
                                if(isset($NameError) || isset($ListedPriceError) || isset($DescriptionError) ){
                                    $editproduct = getProductDetails($productID);
                                    include_once "../Admin/View/edit_products.php";
                                }else{
                                $result = edit_Product($productID, $Name, $ListedPrice, $Description, $Category, $CollectionID, $ImageURL);
                    
                                if ($result) {
                                    $_SESSION['thongbao'] = 'Cập nhật sản phẩm thành công!';
                                    $kq = product_getAll();  
                                    $editproduct = getProductDetails($productID);

                                    include_once "../Admin/View/edit_products.php";
                                    exit();
                                } else {
                                    $_SESSION['loi'] = 'Không thể cập nhật sản phẩm. Vui lòng kiểm tra lại!';
                                    header('location: index.php?actad=edit_product&ProductID=' . $productID);
                                    exit;
                                }
                                }
                            }
                            $editproduct = getProductDetails($productID);

                            include_once "../Admin/View/edit_products.php";
                        } else {
                            $_SESSION['loi'] = 'Vui lòng chọn sản phẩm cần chỉnh sửa.';
                            header('location: index.php?actad=edit_products');
                        }

                        break;
                       
                    case 'delete_product':
                        if (isset($_GET['ProductID'])) {
                            $productID = $_GET['ProductID'];
                    
                            $kq = delete_Product($productID);
                    
                            if ($kq) {
                                $_SESSION['thongbao'] = 'Đã xóa sản phẩm!';
                            } else {
                                $_SESSION['loi'] = 'Có lỗi xảy ra! Vui lòng thử lại sau.';
                            }
                    
                            header('location: index.php?actad=products');
                        }
                        break;
                        
                    case 'add_categories':
                        if(isset($_POST['submit'])){
                            $nameCategory = $_POST['nameCategory'];
                            $statusCategory = $_POST['statusCategory'];
                            $kq = categories_checkName($nameCategory);

                            // Kiểm tra tên danh mục
                            if (empty($nameCategory)) {
                                $nameCategoryError = 'Tên danh mục không được để trống.';
                            } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $nameCategory)) {
                                $nameCategoryError = 'ên danh mục chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                            }

                            // Không có lổi thêm danh mục 
                            if( isset($nameCategoryError) ){
                                include_once "../Admin/View/add_categories.php";
                            }else{
                            if($kq){
                                // đúng, bị trùng, không thêm
                                $_SESSION['loi'] = 'Đã tồn tại tên danh mục <strong>'.$nameCategory.'</strong>!';
                            }else{
                                // sai, ko trùng, thêm danh mục
                                categories_add($nameCategory, $statusCategory);
                                $_SESSION['thongbao'] = 'Thêm danh mục <strong>'.$nameCategory.'</strong> thành công!';
                            }
                        }
                        }
                        include_once "../Admin/View/add_categories.php";
                        break;

                        case 'edit_categories':
                            $CategoryID = $_GET['CategoryID'];
                        
                            if (isset($_POST['submit'])) {
                                $nameCategory = $_POST['nameCategory'];
                                $statusCategory = $_POST['statusCategory'];
                                $kq = categories_checkName($nameCategory);

                                // Kiểm tra tên danh mục
                                if (empty($nameCategory)) {
                                    $nameCategoryError = 'Tên danh mục không được để trống.';
                                } elseif (!preg_match('/^[A-Za-z0-9\s\-_\p{L}]+$/u', $nameCategory)) {
                                    $nameCategoryError = 'Tên danh mục chỉ được chứa kí tự chữ cái, chữ số, khoảng trắng, gạch dưới, gạch ngang.';
                                }

                                if( isset($nameCategoryError) ){
                                    $editCategory = categories_getById($CategoryID);
                                    include_once "../Admin/View/edit_categories.php";

                                }else{
                                    if ($kq) {
                                        // Sai, không trùng, sửa danh mục
                                        categories_edit($nameCategory, $statusCategory, $CategoryID);
                                        $_SESSION['thongbao'] = 'Thông tin thay đổi đã được lưu lại!';
                                    }
                                }
                            }
                            $editCategory = categories_getById($CategoryID);

                        
                            include_once "../Admin/View/edit_categories.php";
                            break;
                        case 'delete_categories':
                            if(isset($_GET['CategoryID'])){
                                $kq = categories_delete($_GET['CategoryID']);
                                if($kq){
                                    // KQ đúng, xóa thành công
                                    $_SESSION['thongbao'] = 'Đã xóa danh mục!';  
                                }else{
                                    // KQ sai
                                    $_SESSION['loi'] = "Có lỗi xảy ra! Vui lòng thử lại sau!";
                                }
                                    header('location: index.php?actad=categories');

                            }
                            break;

                    default:
                        $AmountUser = user_Amount();
                        $AmountProduct = product_Amount();
                        $AmountCollection = collection_Amount();
                        $AmountComment = comment_Amount();
            
                        $topCoins = user_getUserMaxCoins(5);
                        $topVolume = user_getUserMaxVolume(5);
                        $topSold = user_getUserMaxSold(5);
                        $topFollowers = user_getUserMaxFollowers(5);
                        include "../Admin/View/home.php";
                        break;
                }
            }
            else{
                $AmountUser = user_Amount();
                $AmountProduct = product_Amount();
                $AmountCollection = collection_Amount();
                $AmountComment = comment_Amount();
    
                $topCoins = user_getUserMaxCoins(5);
                $topVolume = user_getUserMaxVolume(5);
                $topSold = user_getUserMaxSold(5);
                $topFollowers = user_getUserMaxFollowers(5);
                include "../Admin/View/home.php";
            }
            include "../Admin/View/footer.php";