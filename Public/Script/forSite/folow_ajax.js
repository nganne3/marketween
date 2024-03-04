$(document).ready(function(){
    
    function folow_user(flwer, flwing, ed_why){

        if (ed_why === 'false') {
            console.log('sss')
            $.ajax({
                url: '../../App/Model/follow.php',
                type: 'post',
                data:{
                    flwer: flwer,
                    flwing: flwing
                },
                success: function(response) {
                   console.log(response);
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
            return;
        }
        if (ed_why === 'true') {
            $.ajax({
                url: '../../App/Model/follow.php',
                type: 'post',
                data:{
                    flwer_huy: flwer,
                    flwing_huy: flwing
                },
                success: function(response) {
                   console.log(response);
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
            return;
        }
    }

    $(document).on('click', '.folow_ajax', function(e){
        e.preventDefault();
        const flwer = $(this).children().eq(1).val();
        const flwing = $(this).children().eq(2).val();
        const ed_why = $(this).children().eq(3).val();
        if (flwer == '0') {
            window.location.href = 'index.php?act=login';
            return;
        };
        folow_user(flwer, flwing, ed_why);
    });    
    
})