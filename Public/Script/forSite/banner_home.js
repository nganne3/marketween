$(document).ready(function(){

    function changeDivColor() {
        var colorThief = new ColorThief();

        var divs = document.getElementsByClassName('banner_colorthier');
        var imgs = document.getElementsByClassName('img_cl_thier');

        for (var i = 0; i < divs.length; i++) {
            var img = imgs[i];
            var div = divs[i];

            var color = colorThief.getColor(img);
            var rgbColor = 'rgb(' + color[0] + ',' + color[1] + ',' + color[2] + ')';

            div.style.backgroundColor = rgbColor;
            
            var brightness = Math.round(((parseInt(color[0]) * 299) +
                      (parseInt(color[1]) * 587) +
                      (parseInt(color[2]) * 114)) / 1000);
            var textColor = (brightness > 125) ? 'black' : 'white';

            var elements = div.querySelectorAll('.nghichdao_text');
            for (var j = 0; j < elements.length; j++) {
                elements[j].style.color = textColor;
            }
        }
    }

    changeDivColor();


    // SCROLLING-----------------------------------
    let scrollcontainer = document.querySelector('.banner-page-home-noituyen'), 
    backbtn = document.querySelector('#btn-banner-scroll-left'), 
    nextbtn = document.querySelector('#btn-banner-scroll-right');

    $(document).on('click', '#btn-banner-scroll-right', function(){
        scrollcontainer.scrollLeft += scrollcontainer.offsetWidth;
        if (scrollcontainer.scrollLeft >= scrollcontainer.scrollWidth - scrollcontainer.offsetWidth) {
            // Nếu đã cuộn đến cuối, quay lại vị trí ban đầu
            scrollcontainer.scrollLeft = 0;
        }
    });

    $(document).on('click', '#btn-banner-scroll-left', function(){
        scrollcontainer.scrollLeft -= scrollcontainer.offsetWidth;
        if (scrollcontainer.scrollLeft < 0) {
            // Nếu đã cuộn đến đầu, quay lại vị trí cuối
            scrollcontainer.scrollLeft = scrollcontainer.scrollWidth - scrollcontainer.offsetWidth;
        }
    });

    let banners = document.querySelectorAll('.banner-page-home-noituyen .check_screence');
    let bars = document.querySelectorAll('.bar-time-at-banner');
    let currentIndex = 0;
    
    // Đặt giá trị ban đầu cho chiều dài của tất cả các thanh
    bars.forEach(bar => {
        let blackBar = bar.querySelector('.bar-time-at-banner-black');
        blackBar.style.width = '0%';
    });
    
    function fillBar() {
        let currentBar = bars[currentIndex].querySelector('.bar-time-at-banner-black');
        let currentWidth = parseFloat(currentBar.style.width.slice(0, -1));
        if (currentWidth >= 100) {
            // Nếu thanh đã đầy, cuộn banner và chuyển sang thanh tiếp theo
            banners.forEach((banner, index) => {
                banner.style.transform = `translate3d(${-100 * currentIndex}%, 0, 0)`;
            });
            currentBar.style.width = '0%';
            currentIndex = (currentIndex + 1) % bars.length;
        } else {
            // Nếu thanh chưa đầy, tăng chiều dài của thanh
            currentBar.style.width = (currentWidth + 0.33) + '%';
        }
    }
    
    // Gọi hàm fillBar sau mỗi 10ms
    setInterval(fillBar, 10);


    
})