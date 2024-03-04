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
        maxPrice: ''
    };

    $(document).on('click', '#dangban-expro-pri', function() {
        updateLink('dangban');
    });
    
    $(document).on('click', '#chuaban-expro-pri', function() {
        updateLink('chuaban');
    });
    
    $(document).on('click', '#tatca-expro-pri', function() {
        updateLink('tatcatinhtrang');
    });
    
    $(document).on('click', '#explo-ctgory-1', function() {
        updateLink('1');
    });
    
    $(document).on('click', '#explo-ctgory-2', function() {
        updateLink('2');
    });
    
    $(document).on('click', '#explo-ctgory-3', function() {
        updateLink('3');
    });
    
    $(document).on('click', '#explo-tatcadanhmuc', function() {
        updateLink('tatcatheloai');
    });
    
    $(document).on('click', '#trend_expro', function() {
        updateLink('trend');
    });
    
    $(document).on('click', '#price_asc_expro', function() {
        updateLink('price_asc_expro');
    });
    
    $(document).on('click', '#price_desc_expro', function() {
        updateLink('price_desc_expro');
    });
    
    $(document).on('click', '.btn-tim-price', function() {
        updateLink('checkprice');
    });

    function updateLink(filterType) {

        console.log(filterType);

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

        let newURL = 'index.php?act=explore&explorepage=exploreProducts' 
        + '&priced=' + filters.priced + '&unpriced=' + filters.unpriced 
        + '&sound=' + filters.sound + '&video=' + filters.video + '&images=' + filters.images 
        + '&trend=' + filters.trend + '&price_asc=' + filters.price_asc + '&price_desc=' + filters.price_desc 
        + '&minprice=' + filters.minPrice + '&maxprice=' + filters.maxPrice ;

        if (filters.trend === 'true') {
            document.querySelector('#order_expro').textContent = 'Xu hướng';
        } else if (filters.price_asc === 'true') {
            document.querySelector('#order_expro').textContent = 'Giá từ thấp đến cao';
        } else if (filters.price_desc === 'true') {
            document.querySelector('#order_expro').textContent = 'Giá từ cao đến thấp';
        }

        window.history.pushState({}, '', newURL);

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
            url: '../../App/Model/expro_url.php',
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
 