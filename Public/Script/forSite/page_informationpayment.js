$(document).ready(function(){

    function getCart() {
        let cart = localStorage.getItem("cart");
        if (cart) {
            return JSON.parse(cart);
        } else {
            return [];
        }
    }

    function paymentokay(){
        let cart = getCart();
        if (!Array.isArray(cart) || cart.length === 0) {
            console.error('Cart is not an array');
            return; 
        }
        let login = "marketween";
        let email = $('#check_email_pm_ne').val();
        let user = $('#check_name_pm_ne').val();
        let total = cart.reduce((sum, item) => sum + Number(item.price), 0);
    
        $.ajax({
            url: '../../App/Model/payment_pro.php',
            type: 'POST',
            data: { 
                cart: cart,  
                login: login,
                total: total,
                email: email,
                user: user 
            },
            success: function(response) {
                console.log(response);
                window.location.href = '../../index.php';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    // ===================== CHECK =========================

    function blockButton(check){
        if (check === true) {
            $('#conf_payment_not_with_login').addClass('button-disabled')
        }
        else{
            $('#conf_payment_not_with_login').removeClass('button-disabled')
        }
        return check;
    }

    function checkClass() {
        let element = $('#conf_payment_not_with_login');
        if (element.hasClass('button-disabled')) {
            return true;
        } else {
            return false;
        }
    }

    let isEmailValid = false;
    let isNameValid = false;

    function validateInput(input) {
        var id = input.attr('id');
        var value = input.val();
        
        if(id === "check_email_pm_ne") {

            var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]{2,6})+$/;
            if(value.trim() === "") {
                $('#err_gmailip').show();
                $('#error_gmail_ip').text('Email không được để trống.');

                $('#box_maintain_email').removeClass('border-xam border_color_brand').addClass('border_color_error');
                $('#err_gmailip').removeClass('bx-check').addClass('bxs-error-circle');

                isEmailValid = false;

            } else if(value.length > 255) {
                $('#err_gmailip').show();
                $('#error_gmail_ip').text('Email không được dài hơn 255 ký tự.');

                $('#box_maintain_email').removeClass('border-xam border_color_brand').addClass('border_color_error');
                $('#err_gmailip').removeClass('bx-check').addClass('bxs-error-circle');

                isEmailValid = false;

            } else if(!emailRegex.test(value)) {
                $('#err_gmailip').show();
                $('#error_gmail_ip').text('Địa chỉ email không hợp lệ.');

                $('#box_maintain_email').removeClass('border-xam border_color_brand').addClass('border_color_error');
                $('#err_gmailip').removeClass('bx-check').addClass('bxs-error-circle');

                isEmailValid = false;

            } else {
                // $('#err_gmailip').hide();
                $('#error_gmail_ip').text('');

                $('#box_maintain_email').removeClass('border-xam border_color_error').addClass('border_color_brand');
                $('#err_gmailip').removeClass('bxs-error-circle').addClass('bx-check');

                isEmailValid = true;
            }

        } else if(id === "check_name_pm_ne") {
            if(value.trim() === "") {
                $('#err_nameip').show();
                $('#error_name_ip').text('Tên không được để trống.');
        
                $('#box_maintain_name').removeClass('border-xam border_color_brand').addClass('border_color_error');
                $('#err_nameip').removeClass('bx-check').addClass('bxs-error-circle');

                isNameValid = false;

            } else if(value.length < 5 || value.length > 50) {
                $('#err_nameip').show();
                $('#error_name_ip').text('Tên phải có độ dài từ 5 đến 50 ký tự.');
        
                $('#box_maintain_name').removeClass('border-xam border_color_brand').addClass('border_color_error');
                $('#err_nameip').removeClass('bx-check').addClass('bxs-error-circle');

                isNameValid = false;

            } else if(/[^a-zA-Z ]/g.test(value)) {
                $('#err_nameip').show();
                $('#error_name_ip').text('Tên chỉ được chứa các ký tự chữ, và không dấu.');
        
                $('#box_maintain_name').removeClass('border-xam border_color_brand').addClass('border_color_error');
                $('#err_nameip').removeClass('bx-check').addClass('bxs-error-circle');

                isNameValid = false;

            } else {
                // $('#err_nameip').hide();
                $('#error_name_ip').text('');
        
                $('#box_maintain_name').removeClass('border-xam border_color_error').addClass('border_color_brand');
                $('#err_nameip').removeClass('bxs-error-circle').addClass('bx-check');

                isNameValid = true;
            }
        } 
        
        if(isEmailValid && isNameValid) {
            blockButton(false);
        } else {
            blockButton(true);
        }
    }
    
    $("#check_email_pm_ne, #check_name_pm_ne").on("focus", function() {
        $(this).on("keyup", function() {
            validateInput($(this));
        });
    });

    $("#err_gmailip").hover(
        function() {
          if ($('#error_gmail_ip').text().trim() !== '') {
            $('#error_gmail_ip').stop(true, true).fadeIn(500);
          }
        }, function() {
          $('#error_gmail_ip').stop(true, true).fadeOut(500);
        }
    );
      
    $("#err_nameip").hover(
        function() {
          if ($('#error_name_ip').text().trim() !== '') {
            $('#error_name_ip').stop(true, true).fadeIn(500);
          }
        }, function() {
          $('#error_name_ip').stop(true, true).fadeOut(500);
        }
    );

    $('#conf_payment_not_with_login').click(function() {
        $class = checkClass();
        if($class === true) {
           return;
        } else {
            paymentokay();
        }        
    });

})