$(document).ready(function(){

    document.getElementById('loadMoreComments').addEventListener('click', function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../../App/Model/increase_offset.php', true);
        xhr.onload = function() {
            if (this.status == 200) {
                location.reload();
            }
        }
        xhr.send();
    });

    function removecmt(cmtid){
        $.ajax({
            url: '../../App/Model/comment.php',
            type: 'POST',
            data: {
                cmt_bixoa: cmtid
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

    function enter_cmt(){

        let input = $('.enter_my_cmt');

        if (input.val().trim() === '') {
            $('.input_my_cmt').css('border-color', 'red');
            input.attr('placeholder', 'Không được để trống');
            return;      
        } else {
            $('.input_my_cmt').css('border-color', 'rgba(22, 22, 26, 0.358)');
            input.attr('placeholder', '');
        }

        const content = input.val();
        const user = $('#usernao').val();
        const spnaovay = $('#spnaovay').val();

        $.ajax({
            url: '../../App/Model/comment.php',
            type: 'POST',
            data: {
                content: content,
                user: user,
                spnaovay: spnaovay
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

    function edit_cmt(newcontent, cmtid){
        if (newcontent.val().trim() === '') {
            newcontent.parent().css('border-color', 'red');
            newcontent.attr('placeholder', 'Không được để trống');
            return;
        } else {
            newcontent.parent().css('border-color', 'rgba(22, 22, 26, 0.358)');
            newcontent.attr('placeholder', '');
        }
        const content = newcontent.val();
        // const user = $('#usernao').val();
        $.ajax({
            url: '../../App/Model/comment.php',
            type: 'POST',
            data: {
                content_new: content,
                cmtid: cmtid
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

    function demcmt(){
        let dem = $('.user-comment').length;
        $('#dembinhluan').text(dem);
        if (dem == 0) {
            $('.box_big_cmt').css('border-bottom', '0px solid white');
            const t = '<div style="width:100%; color:grey; font-size: 25px; font-weight:500; padding-bottom:20px;">Hãy là người bình luận đầu tiên!</div>'
            $('.body-comment').html(t);
        };
    };

    $('#guibinhluan').click(function() {
        enter_cmt();
    });

    $(document).on('click', '.dasuaxong', function(){
        $(this).parent().parent().hide();
        let newcontent = $(this).parent().prev().children().first();
        
        let cmtid = $(this).prev().val();
        edit_cmt(newcontent, cmtid);
    });

    $(document).on('click', '.xoa_binhluan_pd', function(){
        let cmtid = $(this).find('.id_xoacmt').val();
        console.log(cmtid);
        removecmt(cmtid);
    });
    
    $(document).on('click', '.edit_cmt', function(){
        let nextSibling = $(this).parent().next();
        nextSibling.show();
    });

    function demproduct(){
        let dem = $('.sanpham_relatedss').length;
        if (dem == 0) {
            // $('.box_big_cmt').css('border-bottom', '0px solid white');
            // const t = '<div style="width:100%; color:grey; font-size: 25px; font-weight:500; padding-bottom:20px;">Hãy là người bình luận đầu tiên!</div>'
            $('#product-related-at-product').css('display','none');
        };
        if (dem < 5) {
            $('.btn_lq').css('display','none');
        }
    };

    demcmt();
    demproduct();

})