$(document).ready(function(){

    let filters = {
        priced: '',
        unpriced: '',
        // tatcatinhtrang: '',
        sound: '',
        video: '',
        images: '',
        // tatca2: '',
        trend: '',
        price_asc: '',
        price_desc: '',
        
        minPrice: '',
        maxPrice: '',

        userid: ''
    };

    $(document).on('click', '.fter_priced', function() {
        updateLink('dangban');
    });
    
    $(document).on('click', '.fter_unpriced', function() {
        updateLink('chuaban');
    });
    
    $(document).on('click', '.fter_all_ced', function() {
        updateLink('tatcatinhtrang');
    });
    
    $(document).on('click', '.fter_sound', function() {
        updateLink('1');
    });
    
    $(document).on('click', '.fter_video', function() {
        updateLink('2');
    });
    
    $(document).on('click', '.fter_img', function() {
        updateLink('3');
    });
    
    $(document).on('click', '.fter_all_cate', function() {
        updateLink('tatcatheloai');
    });
    
    $(document).on('click', '.fter_trend', function() {
        updateLink('trend');
    });
    
    $(document).on('click', '.fter_ascprice', function() {
        updateLink('price_asc_expro');
    });
    
    $(document).on('click', '.fter_descprice', function() {
        updateLink('price_desc_expro');
    });
    
    $(document).on('click', '.fter_checkprice', function() {
        updateLink('checkprice');
    });

    function updateLink(filterType) {

        console.log(filterType);
        
        const johan = $('.user_id_your').val();

        filters.userid = johan;

        switch(filterType) {

            case 'dangban':

                filters.priced = 'true';
                filters.unpriced = '';
                break;

            case 'chuaban':
                filters.unpriced = 'true';
                filters.priced = '';
                // filters.price_desc = "";
                // filters.price_asc = "";
                break;

            case 'tatcatinhtrang':
                filters.unpriced = '';
                filters.priced = '';
                break;

            case '1':
                filters.sound = $('#explo-ctgory-1').find('input[type="hidden"]').val();
                break;
        
            case '2':
                filters.video = $('#explo-ctgory-2').find('input[type="hidden"]').val();
                break;
        
            case '3':
                filters.images = $('#explo-ctgory-3').find('input[type="hidden"]').val();
                break;

            case 'tatcatheloai':
                filters.sound = '';
                filters.video = '';
                filters.images = '';
                break;

            case 'trend':
                filters.price_desc = "";
                filters.price_asc = "";
                filters.trend = "true";
                break;

            case 'price_desc_expro':
                filters.price_desc = "true";
                filters.price_asc = "";
                filters.trend = "";
                // filters.unpriced = '';
                // filters.priced = '';
                break;

            case 'price_asc_expro':
                filters.price_desc = "";
                filters.price_asc = "true";
                filters.trend = "";
                // filters.unpriced = '';
                // filters.priced = '';
                break;

            case 'checkprice':
                filters.minPrice = document.getElementById('min_pric_expro').value;
                filters.maxPrice = document.getElementById('max_price_expro').value;
                break;
        }

        if (filters.trend === 'true') {
            document.querySelector('#order_expro').textContent = 'Xu hướng';
        } else if (filters.price_asc === 'true') {
            document.querySelector('#order_expro').textContent = 'Giá từ thấp đến cao';
        } else if (filters.price_desc === 'true') {
            document.querySelector('#order_expro').textContent = 'Giá từ cao đến thấp';
        }

        // window.history.pushState({}, '', newURL);

        sessionStorage.setItem('filters', JSON.stringify(filters));

        const shoppingCart = document.getElementById('shopping-cart');
        
        function formatPrice(){
            let priceElements = document.querySelectorAll('.result_format');
            priceElements.forEach((element) => {
                let price = Number(element.innerText);
                let formattedPrice = price.toLocaleString('vi-VN');
                element.innerText = formattedPrice;
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

        $.ajax({
            url: '../../App/Model/your_product_filter.php',
            type: 'post',
            data: filters,
            success: function(response) {
            //    console.log(response);
               $('#expro_show_list').html(response);
               formatPrice();
               formatCurrentcy();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    }
});
 