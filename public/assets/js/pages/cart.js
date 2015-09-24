
$(function () {
    $('.touchspin').TouchSpin({
        min: 1,
        max: 100,
        step: 1,
    });

    $('#checkout-button').click( function() {
      $('#shopcart-buttons').hide();
      $('#checkout-form').fadeIn();
    });


    $('#clear-button').click( function() {
        $.shopcart.clear();
    });
});
