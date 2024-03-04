$(document).ready(function(){
    const usermenu = $('#menu-user');
    const closeUserMenu = $('#close-menu-user');
    const userAtHeader = $('#userlogined-at-header');
    const bodyatuser = $('#body');
    const backdoorMarketweenx = $('#backdoor-marketween');
    const CartHide12 = $('#shopping-cart');

    usermenu.css('display', 'none');
    backdoorMarketweenx.css('display', 'none');

    function checkSessionCart12(){
        if (sessionStorage.getItem('cartshoppingClicked')){
            CartHide12.css('display', 'none');
        }
    }

    function checkSessionCartandShow12(){
        if (sessionStorage.getItem('cartshoppingClicked')){
            CartHide12.css('display', 'block');
        }
    }

    userAtHeader.on('click', ()=>{
        if (usermenu.css('display') == "none"){
            checkSessionCart12();
            usermenu.css('display', 'block');
            bodyatuser.addClass('overflow-hidden');
            backdoorMarketweenx.css('display', 'block');
        }
    })

    closeUserMenu.on('click', ()=>{
        if (usermenu.css('display') == "block") {
            usermenu.css('display', 'none');
            bodyatuser.removeClass('overflow-hidden');
            backdoorMarketweenx.css('display', 'none');
            checkSessionCartandShow12();
        }
    })
})