$(document).ready(function(){

    const notificationsx = document.getElementById('notifications');
    const closeNotifications = document.getElementById('close-notifications');
    const notiAtHeader = document.getElementById('noti-at-header');

    const bodyTag = document.getElementById('body');
    const backdoorMarketween = document.getElementById('backdoor-marketween');

    const CartHide = document.querySelector('#shopping-cart');

    notificationsx.style.display = "none";
    backdoorMarketween.style.display = "none";

    function checkSessionCart(){
        if (sessionStorage.getItem('cartshoppingClicked')){
            CartHide.style.display = 'none';
        }
    };

    function checkSessionCartandShow(){
        if (sessionStorage.getItem('cartshoppingClicked')){
            CartHide.style.display = 'block';
        }
    };

    notiAtHeader.addEventListener('click', ()=>{
        if (notificationsx.style.display == "none"){
            checkSessionCart();
            notificationsx.style.display = "block";
            bodyTag.classList.add('overflow-hidden');
            backdoorMarketween.style.display = 'block';
        }
    });

    closeNotifications.addEventListener('click', ()=>{
        if (notificationsx.style.display == "block") {
            notificationsx.style.display = "none";
            bodyTag.classList.remove('overflow-hidden');
            backdoorMarketween.style.display = 'none';
            checkSessionCartandShow();
        }

    });

    // Lấy tất cả các phần tử có class là 'example'
    let cacPhanTu = document.getElementsByClassName('class_sosanhngay');

    // Kiểm tra xem có phần tử nào không
    if (cacPhanTu.length > 0) {
        // Lấy phần tử cuối cùng trong mảng
        let phanTuCuoiCung = cacPhanTu[cacPhanTu.length - 1];

        // Lấy giá trị từ text của phần tử cuối cùng
        let thongBao = phanTuCuoiCung.textContent;

        // Sử dụng biểu thức chính quy để trích xuất ngày
        let matchResult = thongBao.match(/(\d{2}:\d{2}) ngày (\d{2}\/\d{2}\/\d{4})/);

        // Kiểm tra xem có kết quả từ biểu thức chính quy hay không
        if (matchResult) {
            let gioPhut = matchResult[1]; // Lấy giờ và phút
            let ngay = matchResult[2]; // Lấy ngày

            // Lấy ngày hiện tại
            let ngayHienTai = new Date();
            let ngayHienTaiString = ngayHienTai.toLocaleDateString();

            // Kiểm tra xem ngày từ phần tử cuối cùng có trong phạm vi ngày hôm nay không
            if (ngay === ngayHienTaiString) {
                console.log("Phần tử cuối cùng nằm trong phạm vi ngày hôm nay.");
            } else {
                console.log("Phần tử cuối cùng không nằm trong phạm vi ngày hôm nay.");
            }
        } else {
            console.log("Không tìm thấy ngày trong thông báo.");
        }
    } else {
        console.log("Không tìm thấy phần tử có class là 'example'.");
    }
})

