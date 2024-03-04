$(document).ready(function(){

    var bagAtHeader = document.getElementById('bag-at-header');
    var shoppingCart = document.getElementById('shopping-cart');
    var closeShoppingCart = document.getElementById('close-shopping-cart');

    function toggleCart() {
        if (sessionStorage.getItem('cartshoppingClicked')) {
            shoppingCart.style.display = "block";
            shoppingCart.classList.add('nguoclaidkvTDH');
        } else {
            shoppingCart.style.display = "none";
        }
    }

    function handleOpenCart() {
        if (!sessionStorage.getItem('cartshoppingClicked')) {
            sessionStorage.setItem('cartshoppingClicked', 'true');
            // console.log('Đây là lần click đầu tiên, một session đã được tạo!');
        }
        toggleCart();
    }

    function handleCloseCart() {
        if (sessionStorage.getItem('cartshoppingClicked')) {
            sessionStorage.removeItem('cartshoppingClicked');
            // console.log('Session đã bị xóa!');
        }
        toggleCart();
    }

    toggleCart();
    bagAtHeader.addEventListener('click', handleOpenCart);
    closeShoppingCart.addEventListener('click', handleCloseCart);

    // ========================================UPDATE CART=========================================

    function updateCartinf(){
        
        let cartDiv = document.querySelector('div#quantity-all-cart');
        let products = document.querySelectorAll('div.this_cart_bag');
        let btn_pm_from_bag = document.getElementById('btn_pm_from_bag');
        let ppp = document.querySelector('div#have_or_not_pr_in_bag');
        let index_qtt_bag = document.querySelector('.index_qtt_bag');
        
        if (products.length == 0) {
            cartDiv.style.display = 'none';
            index_qtt_bag.style.display = 'none';
            btn_pm_from_bag.classList.remove('background-color-brand');
            btn_pm_from_bag.classList.add('disabled');
            btn_pm_from_bag.textContent = 'Thanh toán';

            if (ppp) {
                ppp.style.display = 'flex';
            }
        }

        let gioihan = 9;
        
        if (products.length > 0) {
            cartDiv.textContent = products.length;
            index_qtt_bag.textContent = products.length;
            cartDiv.style.display = 'flex';
            if (products.length >= gioihan) {
                index_qtt_bag.textContent = "9" + "+";
            }
            index_qtt_bag.style.display = 'flex';
            btn_pm_from_bag.classList.add('background-color-brand');
            btn_pm_from_bag.classList.remove('disabled');

            btn_pm_from_bag.innerHTML = `
            <span>Mua với</span>
            &nbsp;
            <span class="total_price_at_bag result_format"></span>
            <span class="vo_K_curn"> </span>
            &nbsp;
            <span class="who_curn" style="font-size:16px;"> </span>`;
            
            if (ppp) {
                ppp.style.display = 'none';
            }
        }        
    }

    function formatPrice(){
        let priceElements = document.querySelectorAll('.result_format');
        priceElements.forEach((element) => {
            let price = Number(element.innerText.replace(/\./g,''));
            let formattedPrice = price.toLocaleString('vi-VN');
            element.innerText = formattedPrice;
            // console.log(price,formattedPrice, element);
        });        
    }

    function formatCurrentcy(){
        let coins = "coins";
        let vnd = "₫";
        let K = "K";
        let voK = "";

        let who;
        let k_null;

        if (shoppingCart.dataset.nm === 'marketween') {
            who = vnd;
            k_null = K;
        }
        else{
            who = coins;
            k_null = voK;
        }

        let K_or_not = document.querySelectorAll('.vo_K_curn');
        let who_c = document.querySelectorAll('.who_curn');

        K_or_not.forEach((element) => {
            element.innerText = k_null;
        });

        who_c.forEach((element) => {
            element.innerText = who;
        });
    }

    // ========================================ADD TO CART============================================

    let cart = [];
   // ===========CREATE CART

    function createCart(){
        if (localStorage.getItem("cart")) {
            cart = JSON.parse(localStorage.getItem("cart"));
        }
    }

    createCart();
     // ===========GET CART

    function getCart() {
        let cart = localStorage.getItem("cart");
        if (cart) {
            return JSON.parse(cart);
        } else {
            return [];
        }
    }    

    // ===========SHOW CART

    function showpro_Cart(){
        let cart = getCart();
        if (!Array.isArray(cart)) {
            console.error('Cart is not an array');
            return; 
        }
        let container = document.getElementById('container-all-product-at-cart');
        if (cart.length === 0) {
            container.innerHTML = `   
            <div id="have_or_not_pr_in_bag" style="margin:auto; font-size:18px; display:flex; align-items:center; justify-content:center; height:100%;">
                Chưa có sản phẩm nào
            </div>`;
            return;
        }
        let html = '';
        for (const product of cart) {
            let price = Number(product.price);       
            
            html += `
            <div data-id="${product.id}" class="margin-bot-20px display-flex align-items-center justify-content-space-between hide-cart-from-parent-product product-at-shoppingcart this_cart_bag">
                <div class="display-flex align-items-center margin-right-10px">
                    <div class="overflow-hidden height-width-56px border-radius-12px margin-right-20px">
                        <img class="width-100-height-100" src="${product.img}" alt="">
                    </div>
                    <div class="width-for-in4-product-at-shoppingcart"> 
                        <div class="font-size-18px font-weight-600 hide-text-after-3cham">
                            ${product.name}
                        </div>
                        <div class="display-flex align-items-center width-100phantram">
                            <div class="display-flex align-items-center margin-right-20px width-50phantram">
                                <span>Bởi</span>
                                &nbsp;
                                <a class="hide-text-after-3cham width-100phantram">${product.seller}</a>
                            </div>
                            <div class="font-size-10px padding-5px-10px background-color-input border-radius-8px ">
                                ${product.category}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100phantram">
                    <div class="display-flex align-items-center width-100phantram flex-end price-at-shoppingcart">
                        <input type="hidden" class="price_basic_at_bag" value="${product.price}">
                        <span class="product_price_in_bag result_format">${price}</span>
                        <span class="vo_K_curn"> </span>
                        &nbsp;
                        <span class="who_curn"> </span>
                    </div>
                    <div class="width-100phantram display-flex align-items-center flex-end trash-at-shoppingcart sotrac_at_cart">
                        <i class='bx bxs-trash-alt font-size-22px height-width-40px display-flex align-items-center justify-content-center background-color-hover-xam border-radius-12px'></i>
                    </div>
                </div>
            </div>
            `;
        }
        container.innerHTML = html;
        updateCartinf();
        updateCartTotal();
        formatPrice();
        formatCurrentcy();
    }

    // ================TOTAL PRICE

    function updateCartTotal() {
        let prices = document.querySelectorAll('.price_basic_at_bag');
        let total = 0;
        for (let i = 0; i < prices.length; i++) {
            let price = Number(prices[i].value);
            if (!isNaN(price)) {
                total += price;
            }
        }
        let element = document.querySelector('.total_price_at_bag');
        if (element !== null) {
            element.textContent = total;
        }
    }    

    // ===========ADD CART

    function addToCart(product, button, detail_page) {
        if (detail_page === true) {
            let jan = cart.findIndex(p => p.id === product.khach_idpro);
            if (jan !== -1) {
                cart.splice(jan, 1);
                button.children[0].style.transform = 'rotate(0deg)';
            } else {
                cart.push({
                    id: product.khach_idpro,
                    name: product.khach_namepr,
                    price: product.khach_price,
                    category: product.khach_namecate,
                    seller: product.khach_username,
                    img: product.khach_img,
                });
                button.children[0].style.transform = 'rotate(45deg)';
            }
        }
        else{
            let productIndex = cart.findIndex(p => p.id === product.idpro_ex);

            if (productIndex !== -1) {
                cart.splice(productIndex, 1);
                button.style.transform = 'rotate(0deg)';
            } else {
                cart.push({
                    id: product.idpro_ex,
                    name: product.name_ex,
                    price: product.price_ex,
                    category: product.category_ex,
                    seller: product.username_ex,
                    img: product.img_ex,
                });
                button.style.transform = 'rotate(45deg)';
            }
        }
        localStorage.setItem("cart", JSON.stringify(cart));
        showpro_Cart();
        updateCartinf();
        updateCartTotal();
        formatPrice();
        formatCurrentcy();
    }
    
    // ==============GET VALUE PRODUCT

    let products_at_expro = document.querySelectorAll('.products_at_expro');
    let classes = ['idpro_ex', 'name_ex', 'username_ex', 'category_ex', 'price_ex', 'img_ex'];
    
    products_at_expro.forEach((product) => {
        product.addEventListener('click', function(event) {
            event.preventDefault();
            let parentElement = this.parentElement;
            let button = this.children[0];
            let productInfo = { };
            classes.forEach((className) => {
                let element = parentElement.querySelector('.' + className);
                if (element) {
                    productInfo[className] = element.value;
                }
            });
            addToCart(productInfo, button, false);
        });
    });

    $(document).on('click', '#add_cart_details', function(){
        let ckass = ['khach_idpro', 'khach_namepr', 'khach_username', 'khach_namecate', 'khach_price', 'khach_img'];
        let productInfo = { };
        ckass.forEach((className) => {
            let element = document.querySelector('.' + className);
            if (element) {
                productInfo[className] = element.value;
            }
        });
        addToCart(productInfo, this, true);
        console.log(productInfo);
    });

    // ==================XOAY BUTTON===================

    function updateButton(product, button) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let productIndex = cart.findIndex(p => p.id === product);
        if (productIndex !== -1) {
            button.style.transform = 'rotate(45deg)';
        } else {
            button.style.transform = 'rotate(0deg)';
        }
    }
    
    function updateAllButtons() {
        products_at_expro.forEach(function(product) {
            let button = product.children[0];
            let parentElement = product.parentElement; 
            let value = parentElement.querySelector('.idpro_ex').value;
            if (value) {
                updateButton(value, button);
            }
        });
    }

    function updateAllButtonsSigle() {
        let button = document.getElementById('add_cart_details').children[0];
        if (button) {
            let value = document.querySelector('.khach_idpro').value;
            if (value) {
                updateButton(value, button);
            }
        }
    }
    
    updateAllButtons();

    let xxxx = document.getElementById('add_cart_details');

    if (xxxx) {
        updateAllButtonsSigle();
    }

    // ===========SET CART

    function setCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
        showpro_Cart();
        updateCartinf();
        updateCartTotal();
        formatPrice();
        formatCurrentcy();
    }

    // ==============REMOVE

    showpro_Cart();
    updateCartinf();
    updateCartTotal();
    formatPrice();
    formatCurrentcy();

    $(document).on('click', 'div.sotrac_at_cart', function(event){
        event.preventDefault();
        let parentElement = event.currentTarget.parentElement.parentElement;
        let productId = parentElement.dataset.id;

        let cart = getCart();

        if (!Array.isArray(cart)) {
            console.error('Cart is not an array');
            return;
        }

        let productIndex = cart.findIndex(p => p.id === productId);

        if (productIndex !== -1) {
            cart.splice(productIndex, 1);
            setCart(cart);
            if (parentElement) {
                parentElement.remove();
                showpro_Cart();
                updateCartinf();   
                updateCartTotal();
                formatPrice();
                updateAllButtonsSigle();
            }
        } else {
            console.error('Product not found in cart');
            return;
        }
    })
   
    // =================REMOVE ALL

    const clear_all_pro_in_bag = document.querySelector('#clear_all_pro_in_bag');

    function clearAllpr(){
        cart = [];
        localStorage.setItem('cart', JSON.stringify(cart));
        showpro_Cart();
        updateCartinf();
        updateCartTotal();
        formatPrice();
        formatCurrentcy();

        let products_at_expro = document.querySelectorAll('.products_at_expro .bx-plus');

        products_at_expro.forEach((e) =>{
            e.style.transform = 'rotate(0deg)';
        });
    }

    clear_all_pro_in_bag.addEventListener('click', ()=>{
        clearAllpr();
    });

    // ==============================================PAGE CONFIG PAYMENT========================================================

    function check_coins(){
        let total = $('.total_price_at_bag').text();
        total = total.replace(/,/g, ''); 
        total = total.replace(/\./g, '');
        total = Number(total);
        let login = shoppingCart.dataset.nm;
        
        $.ajax({
            url: '../../App/Model/check_coins.php',
            type: 'POST',
            data: { 
                total: total, 
                login: login
            },
            success: function(response) {
                console.log(response);
                //'disabled_btn'
                $('#accp_bought').addClass(response);
                if ($('#accp_bought').hasClass('disabled_btn')) {
                    $('#accp_bought').text('Không đủ coins để mua');
                };
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function hiddenBodyShowBackdoor(){
        $('#body').addClass('overflow-hidden');
        $('#backdoor-marketween').css('display', 'block');
    };

    function conf_pm_show(){
        let cart = getCart();
        if (!Array.isArray(cart)) {
            console.error('Cart is not an array');
            return;
        }
        let container = document.getElementById('container_pr_config');
        if (cart.length === 0) {
            return;
        }
        let html = '';
        
        for (const product of cart) {
            let price = Number(product.price);       
            html += `
            <div class="pr-conf">
                <a class="display-flex align-items-center justify-content-space-between pr-conf-padd ">
                    <div class="display-flex align-items-center khu-in4-pr-conf">
                        <div class="overflow-hidden img-pr-config">
                            <img class="width-100-height-100" src="${product.img}" alt="">
                        </div>
                        <div class="khu-in4-pr-conf">
                            <p class="font-size-18px font-weight-500">Sengaku #2020</p>
                            <div class="display-flex align-items-center">
                                <p class="margin-right-10px display-block">Bởi <span>${product.seller}</span></p>
                                <div class="sound-pad">${product.category}</div>
                            </div>
                        </div>
                    </div>
                    <div class="display-flex align-items-center">
                        <input type="hidden" class="price_basic_at_bag" value="${product.price}">
                        <span class="product_price_in_bag result_format">${price}</span>
                        <span class="vo_K_curn"> </span>
                        &nbsp;
                        <span class="who_curn"> </span>
                    </div>
                </a>
            </div>
            `;
        }
        container.innerHTML = html;
        formatPrice();
        formatCurrentcy();
        check_coins();
    };
    
    function False_hiddenBodyShowBackdoor(){
        $('#body').removeClass('overflow-hidden');
        $('#backdoor-marketween').css('display', 'none');
    };
    
    $(document).on('click', '#btn_pm_from_bag', ()=>{
        let cart = getCart();
        if (!Array.isArray(cart) || cart.length === 0) {
            console.error('Cart is not an array');
            return; 
        }
        $('#shopping-cart').css('display', 'none');
        hiddenBodyShowBackdoor();
        $('#config-payment-window').css('display', 'block');
        conf_pm_show();

        if (shoppingCart.dataset.nm !== 'marketween') {
            check_coins();
        }
    });
    
    $(document).on('click', '#not_payment', ()=>{
        $('#config-payment-window').css('display', 'none');
        False_hiddenBodyShowBackdoor();
        $('#shopping-cart').css('display', 'block');
    });
    
    $(document).on('click', '#close-conf-pm-window', ()=>{
        $('#config-payment-window').css('display', 'none');
        False_hiddenBodyShowBackdoor();
        $('#shopping-cart').css('display', 'block');
    });

    // ==============================PAYMENT SUCCESS

    function paymentokay(){
        let cart = getCart();
        if (!Array.isArray(cart) || cart.length === 0) {
            console.error('Cart is not an array');
            return; 
        }
        let total = $('.total_price_at_bag').text();
        total = total.replace(/,/g, ''); 
        total = total.replace(/\./g, '');
        total = Number(total);
        let login = shoppingCart.dataset.nm;
        
        $.ajax({
            url: '../../App/Model/payment_pro.php',
            type: 'POST',
            data: { 
                cart: cart, 
                total: total, 
                login: login
            },
            success: function(response) {
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    };

    $(document).on('click', '#accp_bought', ()=>{
        if (shoppingCart.dataset.nm !== 'marketween') {
            if ($('#accp_bought').hasClass('disabled_btn')) {
                return;
            };
            paymentokay();
            clearAllpr();
            $('#config-payment-window').css('display', 'none');
            $('#success-payment').css('display', 'flex');
        }else{          
            $('#config-payment-window').css('display', 'none');
            False_hiddenBodyShowBackdoor();
            window.location.href = "index.php?act=informationPayment";
        }
    });

    $(document).on('click', '#i_understand', ()=>{
        $('#success-payment').css('display', 'none');
        False_hiddenBodyShowBackdoor();
        location.reload();
    });


})

