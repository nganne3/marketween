$(document).ready(function(){

    let validity_array = {
        name: false,
        email: false,
        password: false,
        again: false
    };
    
    function blockButton(check){
        if (check === true) {
            $('#btn-signup').addClass('disabled_btn');
        }
        else{
            $('#btn-signup').removeClass('disabled_btn');
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
            else
            {   
                icon.show();
                icon.removeClass('bxs-check-circle').addClass('bxs-error-circle');
                error.text(condition.errorText);
                parent.removeClass('border_ok border_not').addClass('border_err');
                validity_array[validity] = true;
            }
        }
    
        if (validity_array[validity] === true && checkAjax) {
            console.log('dangcheck', value, column);
            $.ajax({
                url: '../../App/Model/sign_up.php', 
                type: 'POST',
                data: { 
                    value: value, 
                    column: column 
                },
                success: function(data) {
                    data = JSON.parse(data);
                    console.log('kq',data);
                    console.log(typeof data);
                    if (data.exists >= 1) {
                        icon.show();
                        icon.removeClass('bxs-check-circle').addClass('bxs-error-circle');
                        input.attr('id') === 'ten_account_sn' ?  error.text('Tên đăng nhập đã tồn tại')  :  error.text('Địa chỉ gmail đã tồn tại'); ;
                        parent.removeClass('border_ok border_not').addClass('border_err');
                        validity_array[validity] = false;
                        return;
                    } else {
                        error.text('');
                        icon.removeClass('bxs-error-circle').addClass('bxs-check-circle');
                        parent.removeClass('border_not border_err').addClass('border_ok');
                        validity_array[validity] = true;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });            

        } else if (validity_array[validity] === true) {
            error.text('');
            icon.removeClass('bxs-error-circle').addClass('bxs-check-circle');
            parent.removeClass('border_not border_err').addClass('border_ok');
            validity_array[validity] = true;
        }

        let allValid = Object.values(validity_array).every(value => value === true);

        if (allValid) {
            blockButton(false);
        } else {
            blockButton(true);
        }

    }
    
    let nameConditions = [
        { test: (value) => value.trim() === "", errorText: 'Tên không được để trống.' },
        { test: (value) => value.length < 5 || value.length > 50, errorText: 'Độ dài tối thiểu chấp nhận là 5 ký tự và tối đa là 50 ký tự.' },
        { test: (value) => !/^[a-zA-Z0-9._]+$/.test(value), errorText: 'Tên không hợp lệ' }
    ];
    
    let emailConditions = [
        { test: (value) => value.trim() === "", errorText: 'Không được để trống.' },
        { test: (value) => value.length > 255, errorText: 'Không được quá 255 ký tự.' },
        { test: (value) => !/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]{2,6})+$/.test(value), errorText: 'Địa chỉ email không hợp lệ.' }
    ];
    
    let passwordConditions = [
        { test: (value) => value.trim() === "", errorText: 'Không được để trống.' },
        { test: (value) => value.length < 6 || value.length > 100, errorText: 'Mật khẩu phải từ 6 đến 100 ký tự.' },
        { test: (value) => !/[a-z]/.test(value), errorText: 'Mật khẩu phải chứa ít nhất một chữ cái viết thường.' },
        { test: (value) => !/[A-Z]/.test(value), errorText: 'Mật khẩu phải chứa ít nhất một chữ cái viết hoa.' },
        { test: (value) => !/[0-9]/.test(value), errorText: 'Mật khẩu phải chứa ít nhất một chữ số.' },
        { test: (value) => !/[^a-zA-Z0-9]/.test(value), errorText: 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt.' }
    ];
    
    let againConditions = [
        { test: (value) => value.trim() === "", errorText: 'Không được để trống.' },
        { test: (value) => $("#nhappass_sn").val() !== value, errorText: 'Mật khẩu không khớp.' }
    ];
    
    $("#ten_account_sn, #email_sn_sn").on("focus", function() {
        let input = $(this);
        let conditions = input.attr('id') === 'ten_account_sn' ? nameConditions : emailConditions;
        let column = input.attr('id') === 'ten_account_sn' ? 'Username' : 'Email';
        let validity = input.attr('id') === 'ten_account_sn' ? 'name' : 'email';
    
        input.on("keyup", function() {
            validateInput(input, conditions, column, true, validity);
        });
    });
    
    $("#nhappass_sn, #nhaplaipass_sn").on("focus", function() {
        let input = $(this);
        let conditions = input.attr('id') === 'nhappass_sn' ? passwordConditions : againConditions;
        let validity = input.attr('id') === 'nhappass_sn' ? 'password' : 'again';
        input.on("input", function() {
            validateInput(input, conditions,  null, false, validity);
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
    
    hoverFade("#icon_er_sn_name", "#er_sn_name");
    hoverFade("#icon_er_sn_email", "#er_sn_email");

    hoverFade("#icon_er_sn_pass", "#er_sn_pass");
    hoverFade("#icon_er_sn_again_pass", "#er_sn_again_pass");


    function checkClass() {
        let element = $('#btn-signup');
        if (element.hasClass('disabled_btn')) {
            return true;
        } else {
            return false;
        }
    };

    function signupAjax(){
        let user = $('#ten_account_sn').val();
        let email = $('#email_sn_sn').val();
        let pass = $('#nhaplaipass_sn').val();
        console.log(user, email, pass);
        $.ajax({
            url: '../../App/Model/sign_up.php',
            type: 'POST',
            data: { 
                user: user,
                email: email,
                pass: pass
            },
            success: function(response) {
                console.log(response);
                let result = JSON.parse(response);
                if (result.success) {
                    alert("Tài khoản đã được thêm mới thành công!");
                    window.location.href = '../../index.php';
                } else {
                    alert("Lỗi: " + result.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    };
    

    $('#btn-signup').click(function(){
        $class = checkClass();
        if($class === true) {
           return;
        } else {
            signupAjax();
        }    
    });

})