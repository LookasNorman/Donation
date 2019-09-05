$(function () {
    $('.btn').on('click', function () {
        let step = $('div .active').attr('data-step');

        if (step == 5) {
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
        }

    })

})