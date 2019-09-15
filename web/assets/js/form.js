$(function () {
    $('.btn').on('click', function () {
        $('#category-summary').text($('input[name="categories[]"]:checked').parent().children('.description').text());
            $('#quantity-summary').text($('input[name="quantity"]').val());
            $('#institution-summary')
                .text($('input[name="institution"]:checked')
                    .parent()
                    .children('.description')
                    .children('.title')
                    .text());
            $('#street-summary').text($('input[name="street"]').val());
            $('#city-summary').text($('input[name="city"]').val());
            $('#zipCode-summary').text($('input[name="zipCode"]').val());
            $('#phone-summary').text($('input[name="phone"]').val());
            $('#date-summary').text($('input[name="pickUpDate"]').val());
            $('#time-summary').text($('input[name="pickUpTime"]').val());
            $('#comments-summary').text($('textarea[name="pickUpComment"]').val());

    });

    jQuery.strength = function( element, password ) {
        var desc = [{'width':'0px'}, {'width':'20%'}, {'width':'40%'}, {'width':'60%'}, {'width':'80%'}, {'width':'100%'}];
        var descClass = ['', 'progress-bar-danger', 'progress-bar-danger', 'progress-bar-warning', 'progress-bar-success', 'progress-bar-success'];
        var score = 0;

        if(password.length > 6){
            score++;
        }

        if ((password.match(/[a-z]/)) && (password.match(/[A-Z]/))){
            score++;
        }

        if(password.match(/\d+/)){
            score++;
        }

        if(password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)){
            score++;
        }

        if (password.length > 10){
            score++;
        }

        element.removeClass( descClass[score-1] ).addClass( descClass[score] ).css( desc[score] );
    };

    jQuery(function() {
        jQuery("#fos_user_registration_form_plainPassword_first").keyup(function() {
            jQuery.strength(jQuery("#progress-bar"), jQuery(this).val());
        });
    });
})