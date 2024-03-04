$(document).ready(function(){

    function clearAllpr(){
        cart = [];
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    function getCart() {
        let cart;
        if (sessionStorage.getItem('savedCart')) {
            cart = JSON.parse(sessionStorage.getItem('savedCart'));
        } else {
            cart = localStorage.getItem("cart");
            if (cart) {
                cart = JSON.parse(cart);
            } else {
                cart = [];
            }
        }
        return cart;
    }

    function showcart(){
        let cart = getCart();
        if (!Array.isArray(cart)) {
            console.error('Cart is not an array');
            return; 
        }
        let container = document.getElementById('list-product-at-order');
        let ctn2 = document.getElementById('all_pr_name');
        if (cart.length === 0) {
            return;
        }
        let html = '';
        for (const product of cart) {
            let price = product.price * 1000;
            let formattedPrice = price.toLocaleString('vi-VN') + ' VND';            
            html += `
            <div class="pr-order display-flex align-items-center justify-content-space-between margin-bottom-20px">
    
                <div class="display-flex align-items-center">
                    <div class="pr-order-img overflow-hidden border-radius-12px margin-right-10px">
                        <img class="width-100-height-100" src=" ${product.img}" alt="">
                    </div>
                    <div>
                        <div class="font-size-18px font-weight-600">
                            ${product.name}
                        </div>
                        <div class="color-text-xam">
                            Bởi ${product.seller}
                        </div>
                    </div>
                </div>
                
                <div class="display-flex align-items-center font-weight-600">
                    <p style="margin-right: 5px; font-weight: 400;">${formattedPrice}</p>
                </div>
    
            </div> 
            `;
        }
        container.innerHTML = html;
    
        let html2 = '';
        for (const iterator of cart) {
            html2 +=`
                <div style="text-align:right;">${iterator.name}</div>
            `;
        }
        ctn2.innerHTML = html2;
    
        sessionStorage.setItem('savedCart', JSON.stringify(cart));
    
        clearAllpr();
    };
    
    showcart();

    window.addEventListener('beforeunload', function (e) {
        sessionStorage.removeItem('savedCart');
        e.preventDefault();
        e.returnValue = '';
    });
    
    if (!sessionStorage.getItem('savedCart')) {
        alert('Đã hoàn tất mua hàng, bạn sẽ được chuyển trở về trang chủ');
        window.location.href = '../../index.php';
    }
   
})