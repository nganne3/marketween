$(document).ready(function(){
    
    let filters_collec = {
        hourly: '',
        daily: '',
        weekly: '',
        day30: ''
    };

    $(document).on('click', '#btn_collec_hour_profile', function() {
        choose_time('hourly');
        $('.peric_ft_collections').removeClass('box-input-bg-color-white');
        $('#btn_collec_hour_profile').addClass('box-input-bg-color-white');
    });
    
    $(document).on('click', '#btn_collec_day_profile', function() {
        choose_time('daily');
        $('.peric_ft_collections').removeClass('box-input-bg-color-white');
        $('#btn_collec_day_profile').addClass('box-input-bg-color-white');
    });
    
    $(document).on('click', '#btn_collec_week_profile', function() {
        choose_time('weekly');
        $('.peric_ft_collections').removeClass('box-input-bg-color-white');
        $('#btn_collec_week_profile').addClass('box-input-bg-color-white');
    });

    $(document).on('click', '#btn_collec_30days_profile', function() {
        choose_time('day30');
        $('.peric_ft_collections').removeClass('box-input-bg-color-white');
        $('#btn_collec_30days_profile').addClass('box-input-bg-color-white');
    });
    
    function choose_time(filterType) {

        console.log(filterType);
        switch(filterType) {

            case 'hourly':

                filters_collec.hourly = 'hourly';
                filters_collec.daily = '';
                filters_collec.weekly = '';
                filters_collec.day30 = '';

                break;

            case 'daily':
                filters_collec.hourly = '';
                filters_collec.daily = 'daily';
                filters_collec.weekly = '';
                filters_collec.day30 = '';
                break;

            case 'weekly':
                filters_collec.hourly = '';
                filters_collec.daily = '';
                filters_collec.weekly = 'weekly';
                filters_collec.day30 = '';
                break;

            case 'day30':
                filters_collec.hourly = '';
                filters_collec.daily = '';
                filters_collec.weekly = '';
                filters_collec.day30 = '30days';
                break;
        }

        $.ajax({
            url: '../../App/Model/your_filter_time_collection.php',
            type: 'post',
            data: filters_collec,
            success: function(response) {
            //    console.log(response);
               $('#container_collectiond_profile').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    }
});
 