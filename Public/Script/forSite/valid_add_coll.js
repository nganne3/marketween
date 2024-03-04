$(document).ready(function(){

    function sendData() {
        console.log('sendData');
        const input1 = document.getElementById('name_collec_add');
        const input2 = document.getElementById('des_collec_add');
        const imageInput1 = document.getElementById('image_logo_coll');
        const imageInput2 = document.getElementById('image_banner_coll');
        const imageInput3 = document.getElementById('image_featured_coll');
    
        const data = new FormData();
        data.append('input1', input1.value);
        data.append('input2', input2.value);
        data.append('image1', imageInput1.files[0]);
        data.append('image2', imageInput2.files[0]);
        data.append('image3', imageInput3.files[0]);
    
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../App/Model/add_collection.php', true);
        xhr.onload = function () {
            if (this.status == 200) {
                const response = JSON.parse(this.responseText);
                console.log(response);
                if (response.success) {
                    const lastInsertedId = response.id;
                    window.location.href = 'index.php?act=my_collection&mycollection=' + lastInsertedId;
                }
            }
        };
        xhr.send(data);
    }

    document.getElementById('addgallery-form-btn').addEventListener('click', function(e) {
       
        const input1 = document.getElementById('name_collec_add');
        const input2 = document.getElementById('des_collec_add');
        const imageInput1 = document.getElementById('image_logo_coll');
        const imageInput2 = document.getElementById('image_banner_coll');
        const imageInput3 = document.getElementById('image_featured_coll');

        const errorSpan1 = document.getElementById('errorSpan1');
        const errorSpan2 = document.getElementById('errorSpan2');
        const errorImage1 = document.getElementById('errorImage1');
        const errorImage2 = document.getElementById('errorImage2');
        const errorImage3 = document.getElementById('errorImage3');
    
        if (!input1.value || input1.value.length < 6 || input1.value.length > 100) {
            errorSpan1.parentElement.style.display = 'flex';
            errorSpan1.textContent = 'Không được để trống và phải có từ 6 đến 100 ký tự.';
        }
        else{
            errorSpan1.textContent = '';
            errorSpan1.parentElement.style.display = 'none';
        }
    
        if (input2.value.length > 2000) {
            errorSpan2.parentElement.style.display = 'flex';
            errorSpan2.textContent = 'Không được quá 2000 ký tự.';
        }
        else{
            errorSpan2.textContent = '';
            errorSpan2.parentElement.style.display = 'none';
        }
    
        checkImage(imageInput1, 5, ['gif', 'jpeg', 'png'], errorImage1);
        checkImage(imageInput2, 15, ['jpeg', 'png', 'gif'], errorImage2);
        checkImage(imageInput3, 5, ['gif', 'jpeg', 'png'], errorImage3);
        
        function checkImage(input, maxSize, allowedFormats, errorSpan) {
            if (input.files[0]) {
                const size = input.files[0].size / 1024 / 1024;
                const format = input.files[0].type.split('/')[1];
                if (size > maxSize || !allowedFormats.includes(format)) {
                    errorSpan.parentElement.style.display = 'flex';
                    errorSpan.textContent = 'Ảnh không đúng định dạng hoặc quá lớn.';
                } else {
                    errorSpan.textContent = '';
                    errorSpan.parentElement.style.display = 'none';
                }
            } else {
                errorSpan.parentElement.style.display = 'flex';
                errorSpan.textContent = 'Ảnh không được để trống.';
            }
        }
        
        const errorMessages = [errorSpan1, errorSpan2, errorImage1, errorImage2, errorImage3];
        const hasError = errorMessages.some(span => span.textContent !== '');

        console.log(errorMessages);
        console.log(hasError);
    
        if (!hasError) {
            console.log('ok goi ham');
            sendData();
        };

    });    
    
})