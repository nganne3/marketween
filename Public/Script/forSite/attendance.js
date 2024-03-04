$(document).ready(function(){

  window.onload = function() {
    document.getElementById('attendance-everyday').classList.add('shake');
  };
  
  // ================KHAI BAO============================
  
  const bodyCheck = document.getElementById('body');
  const bdMatketween = document.getElementById('backdoor-marketween');
  const cartanhien = document.querySelector('#shopping-cart');
  const clickAtten = document.getElementById('attendance-everyday');
  const checkQuestion = document.getElementById('atttendance-windowns-check-question');
  const btnTubo = document.getElementById('btn-tubo');
  const btnChecknow = document.getElementById('btn-checknow');
  const checkDone = document.getElementById('atttendance-windowns-check-done');
  const btnThanks = document.getElementById('btn-checkdone');
  
  function checkSessionCartne(){
    if (sessionStorage.getItem('cartshoppingClicked')){
        cartanhien.style.display = 'none';
    }
  }
  
  function checkSessionCartandShowne(){
    if (sessionStorage.getItem('cartshoppingClicked')){
        cartanhien.style.display = 'block';
    }
  }

  // ================================================================================================================
    
  // ========================RUN=======================
  
    function checkatt_const(){
      let element = document.getElementById('check_att_thoima').value;
      if (element === 'okay') {
        console.log('Người dùng đã điểm danh.');
        document.getElementById('attendance-everyday').classList.remove('shake');
        document.querySelector('.noti-not-check-red').style.display = "none";
        document.getElementById('change-bx-i-time-att').classList.remove('bxs-calendar-check');
        document.getElementById('change-bx-i-time-att').classList.add('bx-history');
        document.querySelector('.time-unlock-att').style.width = "190px";
        document.getElementById('timer-unlock-att').style.display = "block";
      }else{
        console.log('Người dùng chưa điểm danh.');
        document.getElementById('attendance-everyday').classList.add('shake');
        document.querySelector('.noti-not-check-red').style.display = "block";
        document.getElementById('change-bx-i-time-att').classList.remove('bx-history');
        document.getElementById('change-bx-i-time-att').classList.add('bxs-calendar-check');
        document.getElementById('timer-unlock-att').style.display = "none";
        document.querySelector('.time-unlock-att').style.width = "50px";
      }
    }

  checkatt_const();

  function ajax_att(){

    const coins_diemdanh = $('#click_take_coins').val();
    console.log(coins_diemdanh);

    $('#destroy_sales').css('display', 'none');
    $('#backdoor-marketween').css('display', 'none');

    $.ajax({
        url: '../../App/Model/atten_now.php',
        type: 'POST',
        data: {
            coins: coins_diemdanh,
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

  clickAtten.addEventListener('click', ()=>{

    let element = document.getElementById('check_att_thoima').value;
    if (element === 'okay') {
      console.log('Điểm danh rồi, cút');
      return;
    }
    else{
      console.log('Okay cho điểm danh');
      checkSessionCartne();
      checkQuestion.style.display = "block";
      bodyCheck.classList.add('overflow-hidden');
      bdMatketween.style.display = 'block';
    }

  })
  
  btnTubo.addEventListener('click', ()=>{
    checkQuestion.style.display = "none";
    bodyCheck.classList.remove('overflow-hidden');
    bdMatketween.style.display = 'none';
    checkSessionCartandShowne();
  })
  
  btnChecknow.addEventListener('click', ()=>{
    console.log('Điểm danh ok');
    checkQuestion.style.display = "none";
    checkDone.style.display = "block";
    document.getElementById('attendance-everyday').classList.remove('shake');
    document.querySelector('.noti-not-check-red').style.display = "none";
    document.getElementById('change-bx-i-time-att').classList.remove('bxs-calendar-check');
    document.getElementById('change-bx-i-time-att').classList.add('bx-history');
    document.querySelector('.time-unlock-att').style.width = "190px";
    document.getElementById('timer-unlock-att').style.display = "block";

  })
  
  btnThanks.addEventListener('click', ()=>{
    checkDone.style.display = "none";
    bodyCheck.classList.remove('overflow-hidden');
    bdMatketween.style.display = 'none';
    checkSessionCartandShowne();
    ajax_att();
  })
  
  // =================================TIME======================

const countdownElement = document.getElementById('timer-unlock-att');
const inputTimeElement = document.getElementById('time_un_att');

function getTargetTime() {
    var inputTime = inputTimeElement.value;
    var targetDate = new Date();
    targetDate.setHours(inputTime.split(':')[0], inputTime.split(':')[1], inputTime.split(':')[2] || 0, 0);
    if (targetDate.getTime() < Date.now()) {
        targetDate.setTime(targetDate.getTime() + 24 * 60 * 60 * 1000);
    }
    return targetDate.getTime();
}

function updateCountdown() {
    var targetTime = getTargetTime();
    var now = new Date().getTime();
    var distance = targetTime - now;

    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    countdownElement.textContent = 
        (hours < 10 ? '0' + hours : hours) + ' : ' +
        (minutes < 10 ? '0' + minutes : minutes) + ' : ' +
        (seconds < 10 ? '0' + seconds : seconds);

    if (distance <= 0) {
        console.log('Chu trình đã kết thúc!');
        document.getElementById('attendance-everyday').classList.add('shake');
        document.querySelector('.noti-not-check-red').style.display = "block";
        document.getElementById('change-bx-i-time-att').classList.remove('bx-history');
        document.getElementById('change-bx-i-time-att').classList.add('bxs-calendar-check');
        document.getElementById('timer-unlock-att').style.display = "none";
        document.querySelector('.time-unlock-att').style.width = "50px";

        clearInterval(countdownInterval);
        startNewCycle();
    }
}

function startNewCycle() {
    updateCountdown();
    countdownInterval = setInterval(updateCountdown, 1000);
}

updateCountdown();
var countdownInterval = setInterval(updateCountdown, 1000);
  
})

