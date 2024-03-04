$(document).ready(function(){

    // ===================SET SALE CLICK==========================/

    $(document).on('click', '#sale_mydetail', function(event) {
        $('#backdoor-marketween').css('display', 'block');
        $('#sell_my_products_at_profile').css('display', 'flex');

        const idpro_ex_value = $('#chitiet_idpro').val();
        $('#value_product_jeu').val(idpro_ex_value);   

        const driver = $('#chitiet_driver').val();
        $('#set_driver_myproduct_profile_this').val(driver);   

        const img = $('#chitiet_imgsp').val();
        $('#src_sale_mypr').attr('src', img);   
        
        const namepr = $('#chitiet_namesp').val();
        $('#tensanpham_biban').text(namepr); 
        
        const collection = $('#chitiet_collection').val(); 
        $('#tenbosuutap_banchung').text(collection);          
    });

    $(document).on('click', '#not_sales_okay', function(event) {
        $('#sell_my_products_at_profile').css('display', 'none');
        $('#backdoor-marketween').css('display', 'none');
    });

    // ===================EDIT CLICK==========================/

    $(document).on('click', '#edit_sl_mydetail', function(event) {
        event.preventDefault();
        $('#backdoor-marketween').css('display', 'block');
        $('#sell_my_products_at_profile').css('display', 'flex');

        const idpro_ex_value = $('#chitiet_idpro').val();
        $('#value_product_jeu').val(idpro_ex_value);   

        const driver = $('#chitiet_driver').val();
        $('#set_driver_myproduct_profile_this').val(driver);   

        const img = $('#chitiet_imgsp').val();
        $('#src_sale_mypr').attr('src', img);   
        
        const namepr = $('#chitiet_namesp').val();
        $('#tensanpham_biban').text(namepr); 
        
        const collection = $('#chitiet_collection').val(); 
        $('#tenbosuutap_banchung').text(collection);     

        const price = $('#chitiet_price').val(); 
        $('#set_sales_myproduct_profile_this').val(price);
          
    });

    $('#set_sales_myproduct_profile_this').on('keyup', function(e) {
        var value = $(this).val();
        if (value === '') {
            showError('er_google_price_mysell', 'Cần một mức giá', 'thang12_1');
        } else if (isNaN(value)) {
            showError('er_google_price_mysell', 'Chỉ chấp nhận giá trị số.', 'thang12_1');
        } else if (value < 1) {
            showError('er_google_price_mysell', 'Mức giá tối thiểu chấp nhận là 1.', 'thang12_1');
        } else if (value === '+') {
            showError('er_google_price_mysell', 'Không chấp nhận dấu +.', 'thang12_1');
        } else {
            showSuccess('er_google_price_mysell', 'thang12_1');
        }
    });
    
    $('#set_driver_myproduct_profile_this').on('keyup', function() {
        var value = $(this).val();
        var googleDriveRegex = /^https:\/\/drive\.google\.com\/.+/;
        if (!value || value === '') {
            showError('er_google_driver_mysell', 'Không được để trống.', 'thang12_2');
        } else if (value.length > 255) {
            showError('er_google_driver_mysell', 'Link dài quá 255 ký tự.', 'thang12_2');
        } else if (!googleDriveRegex.test(value)) {
            showError('er_google_driver_mysell', 'Chỉ chấp nhận link driver.', 'thang12_2');
        } else {
            showSuccess('er_google_driver_mysell', 'thang12_2');
        }
    });
    
    function showError(id, message, border) {
        $('#' + id).css('display', 'flex');
        $('#' + border).css('border', '1px solid red');
        $('#' + id).children().eq(0).removeClass('bxs-check-circle');
        $('#' + id).children().eq(0).addClass('bx-error-circle');
        $('#' + id).children().eq(1).text(message);
    }
    
    function showSuccess(id, border) {
        $('#' + id).css('display', 'flex');
        $('#' + border).css('border', '1px solid #5E17EB');
        $('#' + id).children().eq(0).removeClass('bx-error-circle');
        // $('#' + id).children().eq(0).addClass('bxs-check-circle');
        $('#' + id).children().eq(1).text('');
    }

    function checkValidity() {
        var value1 = $('#set_sales_myproduct_profile_this').val();
        var value2 = $('#set_driver_myproduct_profile_this').val();
        var googleDriveRegex = /^https:\/\/drive\.google\.com\/.+/;
    
        if (value1 === '' || isNaN(value1) || value1 < 1 || value1 === '+' || value2 === '' || value2.length > 255 || !googleDriveRegex.test(value2)) {
            $('#ban_luon_em_nay').addClass('disabled');
        } else {
            $('#ban_luon_em_nay').removeClass('disabled');
        }
    }
    
    $('#set_sales_myproduct_profile_this, #set_driver_myproduct_profile_this').on('keyup', function() {
        checkValidity();
    });
    
    function sen_nana() {

        if ($('#ban_luon_em_nay').hasClass('disabled')) {
            return;
        };

        $('#sell_my_products_at_profile').css('display', 'none');
        $('#backdoor-marketween').css('display', 'none');

        const value1 = $('#set_sales_myproduct_profile_this').val();
        const value2 = $('#set_driver_myproduct_profile_this').val();
        const my_productid = $('#value_product_jeu').val(); 

        $.ajax({
            url: '../../App/Model/set_a_price.php',
            type: 'POST',
            data: {
                input1: value1,
                input2: value2,
                idpr: my_productid,
            },
            success: function(response) {
                console.log(response);
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
    
    $('#ban_luon_em_nay').on('click', function() {
        sen_nana();
    });

    // ===================================HUY BAN SAN PHAM================================================

    function huy_niemyet(){

        const my_productid = $('#huy_id_prices').val(); 
        console.log(my_productid);
        if (!my_productid) {
            return;
        }

        $('#destroy_sales').css('display', 'none');
        $('#backdoor-marketween').css('display', 'none');

        $.ajax({
            url: '../../App/Model/set_a_price.php',
            type: 'POST',
            data: {
                id_huyban: my_productid,
            },
            success: function(response) {
                console.log(response);
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }

    $(document).on('click', '#huyban_choroi', function(event) {
        $('#backdoor-marketween').css('display', 'block');
        $('#destroy_sales').css('display', 'flex');

        const idpro_ex_value = $('#chitiet_idpro').val();
        $('#huy_id_prices').val(idpro_ex_value);

        const img = $('#chitiet_imgsp').val();
        $('#src_sale_mypr').eq(1).attr('src', img);   
        
        const namepr = $('#chitiet_namesp').val();
        $('#tensanpham_biban').eq(1).text(namepr); 
        
        const collection = $('#chitiet_collection').val(); 
        $('#tenbosuutap_banchung').eq(1).text(collection);  

    });

    $(document).on('click', '#debantiep', function(event) {
        $('#destroy_sales').css('display', 'none');
        $('#backdoor-marketween').css('display', 'none');
    });

    $(document).on('click', '#huyban_okay', function(event) {
        huy_niemyet();
    });
    
})
