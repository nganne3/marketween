$(document).ready(function(){

    $('.muc_url').each(function() {
        $(this).on('click', function(e) {
            e.preventDefault();
            let href = $(this).attr('href');
            history.pushState({}, '', href);
            location.reload();
        });
    });

})

