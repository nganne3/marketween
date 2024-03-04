$(document).ready(function(){

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
})
