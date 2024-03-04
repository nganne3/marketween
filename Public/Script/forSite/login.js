$(document).ready(function(){

    let validity_array = {
        email: false,
        password: false,
    };
    
    function blockButton(check){
        if (check === true) {
            $('#btn-login').addClass('disabled_btn');
        }
        else{
            $('#btn-login').removeClass('disabled_btn');
        }
        return check;
    }
    
    function validateInput(input, conditions, column, checkAjax, validity) {
        let value = input.val();
        let parent = input.parent();
        let sibling = parent.next();
        let icon = sibling.children().last();
        let error = sibling.children().first();
    
        for (let i = 0; i < conditions.length; i++) {
            let condition = conditions[i];
            if (condition.test(value)) {
                icon.show();
                icon.removeClass('bxs-check-circle').addClass('bxs-error-circle');
                error.text(condition.errorText);
                parent.removeClass('border_ok border_not').addClass('border_err');
                validity_array[validity] = false;
                break;
            }
            else{
                error.text('');
                icon.removeClass('bxs-error-circle').addClass('bxs-check-circle');
                parent.removeClass('border_not border_err').addClass('border_ok');
                validity_array[validity] = true;
            }
        }

        let allValid = Object.values(validity_array).every(value => value === true);
            
        if (allValid) {
            blockButton(false);
        } else {
            blockButton(true);
        }

    }
    
    let emailConditions = [
        { test: (value) => value.trim() === "", errorText: 'Không được để trống.' },
    ];
    
    let passwordConditions = [
        { test: (value) => value.trim() === "", errorText: 'Không được để trống.' },
    ];

    var currentRequest = null;
    
    $("#email_dangnhap, #pass_dangnhap").on("focus", function() {
        let input = $(this);
        let conditions = input.attr('id') === 'email_dangnhap' ? emailConditions : passwordConditions;
        let column = input.attr('id') === 'email_dangnhap' ? 'Email' : 'Password';
        let validity = input.attr('id') === 'email_dangnhap' ? 'email' : 'password';

        if (currentRequest !== null) {
            currentRequest.abort();
        }

        input.on("keyup", function() {
            validateInput(input, conditions, column, true, validity);
        });
    });
    
    function hoverFade(selector, errorSelector) {
        let icon = $(selector), error = $(errorSelector);
        icon.hover(
            function() {
                error.text().trim() && error.stop(true, true).fadeIn(500);
            }, function() {
                error.stop(true, true).fadeOut(500);
            }
        );
    };
    
    hoverFade("#icon_er_emaildangnhap", "#p_er_emaildangnhap");
    hoverFade("#icon_er_passdangnhap", "#p_er_passdangnhap");

    function checkClass() {
        let element = $('#btn-signup');
        if (element.hasClass('disabled_btn')) {
            return true;
        } else {
            return false;
        }
    };

    function loginAjax(){
        let email = $('#email_dangnhap').val();
        let password = $('#pass_dangnhap').val();

        $.ajax({
            url: '../../App/Model/login.php',
            type: 'POST',
            data: { 
                email: email,
                password: password
            },
            dataType: "json",
            success: function(response) {
                console.log('cc', typeof response);
                console.log('?', response.message);
                if (response.success === true) {
                    alert("Đăng nhập thành công!");
                    window.location.href = '../../index.php';
                } else {
                    alert("Lỗi: " + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    };
    

    $('#btn-login').click(function(){
        $class = checkClass();
        if($class === true) {
           return;
        } else {
            loginAjax();
        }    
    });

})