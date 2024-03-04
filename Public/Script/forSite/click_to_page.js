$(document).ready(function(){
    $('.click_to_page_that').on('click', function() {
        const url = $(this).data('href');
        window.location.href = url;
    });
})