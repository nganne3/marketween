$(document).ready(function(){

    function sendData(data) {
        const formData = new FormData();
        formData.append('file', data.file);
        formData.append('drive_link', data.drive_link);
        formData.append('text1', data.text1);
        formData.append('text2', data.text2);
        formData.append('select1', data.select1);
        formData.append('select2', data.select2);
    
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../App/Model/add_product.php', true);
        xhr.onload = function () {
            if (this.status == 200) {
                const response = JSON.parse(this.responseText);
                console.log(response);
                if (response.success) {
                    const lastInsertedId = response.id;
                    window.location.href = 'index.php?act=product_detail&products_detail_id=' + lastInsertedId;
                }
            }
        };
        xhr.send(formData);
    }    

    function validateInput(data) {
        let errors = [];
        document.querySelectorAll('.error-message').forEach(function(span) {
            span.parentElement.style.display = 'none';
            span.textContent = '';
        });
    
        // Validate file input
        if (!data.file) {
            errors.push('File không được để trống.');
            document.getElementById('errorImgFeatured_Pro').textContent = 'File không được để trống.';
            document.getElementById('errorImgFeatured_Pro').parentElement.style.display = 'flex';
        } else {
            let file = data.file;
            let fileSize = file.size / 1024 / 1024; // to get the size in MB
            let allowedExtensions = ['png', 'gif', 'webp', 'mp4', 'mp3', 'jpg'];
            let extension = file.name.split('.').pop().toLowerCase();
        
            if (!allowedExtensions.includes(extension)) {
                errors.push('Chỉ chấp nhận JPG, PNG, GIF, WEBP, MP4 hoặc MP3.');
                document.getElementById('errorImgFeatured_Pro').textContent = 'Chỉ chấp nhận JPG, PNG, GIF, WEBP, MP4 hoặc MP3.';
                document.getElementById('errorImgFeatured_Pro').parentElement.style.display = 'flex';
            } else if (fileSize > 100) {
                errors.push('File tối đa 100MB.');
                document.getElementById('errorImgFeatured_Pro').textContent = 'File tối đa 100MB.';
                document.getElementById('errorImgFeatured_Pro').parentElement.style.display = 'flex';
            } else {
                // If no errors, hide the error message
                document.getElementById('errorImgFeatured_Pro').parentElement.style.display = 'none';
            }
        }

        // Validate Google Drive link
        if (data.drive_link && data.drive_link.length > 255) {
            errors.push('Link Google Drive tối đa 255 ký tự.');
            document.getElementById('errordriver_link_Pro').textContent = 'Link Google Drive tối đa 255 ký tự.';
            document.getElementById('errordriver_link_Pro').parentElement.style.display = 'flex';
        } else if (data.drive_link && !data.drive_link.includes('drive.google.com')) {
            errors.push('Chỉ chấp nhận đường dẫn từ Google Drive.');
            document.getElementById('errordriver_link_Pro').textContent = 'Chỉ chấp nhận đường dẫn từ Google Drive.';
            document.getElementById('errordriver_link_Pro').parentElement.style.display = 'flex';
        } else {
            // If no errors, hide the error message
            document.getElementById('errordriver_link_Pro').parentElement.style.display = 'none';
        }        

        // Validate text inputs
        let textInputs = [
            {key: 'text1', min: 6, max: 100, required: true, errorElementId: 'errornamedisplay_Pro'},
            {key: 'text2', min: 6, max: 2000, required: false, errorElementId: 'errordescription_Pro'}
        ];
    
        textInputs.forEach(function(textInput) {
            if (textInput.required && !data[textInput.key]) {
                errors.push(textInput.key.charAt(0).toUpperCase() + textInput.key.slice(1) + ' không được để trống.');
                document.getElementById(textInput.errorElementId).textContent = textInput.key.charAt(0).toUpperCase() + textInput.key.slice(1) + ' không được để trống.';
                document.getElementById(textInput.errorElementId).parentElement.style.display = 'flex';
            } else if (data[textInput.key] && data[textInput.key].length > 0) {
                let length = data[textInput.key].length;
        
                if (length < textInput.min || length > textInput.max) {
                    errors.push(textInput.key.charAt(0).toUpperCase() + textInput.key.slice(1) + " tối thiểu " + textInput.min + " ký tự và tối đa " + textInput.max + " ký tự.");
                    document.getElementById(textInput.errorElementId).textContent = textInput.key.charAt(0).toUpperCase() + textInput.key.slice(1) + " tối thiểu " + textInput.min + " ký tự và tối đa " + textInput.max + " ký tự.";
                    document.getElementById(textInput.errorElementId).parentElement.style.display = 'flex';
                } else {
                    // If no errors, hide the error message
                    document.getElementById(textInput.errorElementId).parentElement.style.display = 'none';
                }
            }
        });                   
    
        let selectInputs = ['select1', 'select2'];
    
        selectInputs.forEach(function(selectInput) {
            if (!data[selectInput]) {
                errors.push('Vui lòng chọn một giá trị cho ' + selectInput.charAt(0).toUpperCase() + selectInput.slice(1) + '.');
                document.getElementById(selectInput + '_error').textContent = 'Vui lòng chọn một giá trị cho ' + selectInput.charAt(0).toUpperCase() + selectInput.slice(1) + '.';
                document.getElementById(selectInput + '_error').parentElement.style.display = 'flex';
            } else {
                document.getElementById(selectInput + '_error').parentElement.style.display = 'none';
            }
        });

        return errors;
    }     
    
    const button = document.querySelector('#addproduct-form-btn');
    button.addEventListener('click', function() {
        const data = {
            file: document.querySelector('input[type="file"]').files[0],
            drive_link: document.querySelector('input[name="drive_link"]').value,
            text1: document.querySelector('input[name="text1"]').value,
            text2: document.querySelector('input[name="text2"]').value,
            select1: document.querySelector('select[name="select1"]').value,
            select2: document.querySelector('select[name="select2"]').value
        };

        const errors = validateInput(data);

        if (errors.length === 0) {
            sendData(data);
        } else {
            console.log('conloilamemei');
            return;
        }
    });

    
})