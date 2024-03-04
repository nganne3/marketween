$(document).ready(function(){
    const now_url = new URL(window.location.href);
    // console.log('url', now_url);
    const click_products_profile = document.getElementById('click_products_profile');
    const click_collections_profile = document.getElementById('click_collections_profile');
    const click_log_sell_profile = document.getElementById('click_log_sell_profile');
    const border_bot_run = document.querySelector('.border_bot_run');
    
    function resetColor() {
        click_products_profile.style.color = 'gray';
        click_collections_profile.style.color = 'gray';
        click_log_sell_profile.style.color = 'gray';
    }
    
    function handleClick(marginLeft, width, id, value) {
        return function(event) {
            event.preventDefault();
            resetColor();
            border_bot_run.style.marginLeft = marginLeft;
            border_bot_run.style.width = width;
            document.getElementById(id).style.color = 'black';
    
            let url = document.getElementById(id).getAttribute('href');
            
            let currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('profile_data', value);
            window.history.pushState({}, '', currentUrl);

            let xhttp = new XMLHttpRequest();
    
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                    document.getElementById('maintain_content_profile').innerHTML = this.responseText;

                    // ==================================PRODUCT=======================================
                    let divs = document.querySelectorAll('.un_or_priced_btn');

                    if(divs) {
                        divs.forEach((div) => {
                            div.addEventListener('click', function() {
                                divs.forEach((div) => {
                                    div.classList.remove('padding-den-nen');
                                    div.classList.add('padding-xamn-nen');
                                });
                
                                this.classList.remove('padding-xamn-nen');
                                this.classList.add('padding-den-nen');
                            });
                        });
                    }
                
                    let allDiv = document.querySelector('div.ctgr-btn_all');
                    let soundDiv = document.querySelector('div.ctgr-btn_1');
                    let videoDiv = document.querySelector('div.ctgr-btn_2');
                    let imageDiv = document.querySelector('div.ctgr-btn_3');
                
                    let otherDivs = [soundDiv, videoDiv, imageDiv];
                
                    if(allDiv) {
                        allDiv.addEventListener('click', function() {
                            this.classList.remove('padding-xamn-nen');
                            this.classList.add('padding-den-nen');
                
                            otherDivs.forEach((e) => {
                                if(e) {
                                    e.classList.remove('padding-den-nen');
                                    e.classList.add('padding-xamn-nen');
                                }
                            });
                        });
                    }
                
                    otherDivs.forEach((e) => {
                        if(e) {
                            e.addEventListener('click', function() {
                                this.classList.remove('padding-xamn-nen');
                                this.classList.add('padding-den-nen');
                
                                if(allDiv) {
                                    allDiv.classList.remove('padding-den-nen');
                                    allDiv.classList.add('padding-xamn-nen');
                                }
                            });
                        }
                    });

                    const checkselectexplore = document.querySelector('.dropdown-select-box145');
                    if (checkselectexplore) {
                        checkselectexplore.addEventListener('click', ()=>{
    
                            const downex = document.getElementById('myDropdownexplore');
        
                            let vanva = getComputedStyle(downex);
        
                            if (vanva.display == "none") {
                                downex.style.display = "block";
                            }
                            else{
                                downex.style.display = "none";
                            }
                        })
                    }
                    // ==================================PRODUCT=======================================
                }
            };
            console.log(url);
            xhttp.open('GET', url, true);
            xhttp.send();
        }
    }
    
    click_products_profile.addEventListener('click', handleClick('0px', '80px', 'click_products_profile', 'product'));
    click_collections_profile.addEventListener('click', handleClick('96px', '90px', 'click_collections_profile', 'collection'));
    click_log_sell_profile.addEventListener('click', handleClick('200px', '100px', 'click_log_sell_profile', 'log_sell'));  

    if (now_url.searchParams.get('act') === 'profile' && now_url.searchParams.get('profile_data') === 'product') {
        click_products_profile.addEventListener('click', function(event) {
            event.preventDefault();
            handleClick('0px', '80px', 'click_products_profile', 'product');
        });
        click_products_profile.click();
    }

    else if (now_url.searchParams.get('act') === 'profile' && now_url.searchParams.get('profile_data') === 'collection') {
        click_collections_profile.addEventListener('click', function(event) {
            event.preventDefault();
            handleClick('96px', '90px', 'click_collections_profile', 'collection');
        });
        click_collections_profile.click();
    }

    else if (now_url.searchParams.get('act') === 'profile' && now_url.searchParams.get('profile_data') === 'log_sell') {
        click_log_sell_profile.addEventListener('click', function(event) {
            event.preventDefault();
            handleClick('200px', '100px', 'click_log_sell_profile', 'log_sell');
        });
        click_log_sell_profile.click();
    }
        
})