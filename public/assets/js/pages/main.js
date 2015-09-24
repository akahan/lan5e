$('#marking-tab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});

$(function () {
    $('.touchspin').TouchSpin({
        min: 1,
        max: 100,
        step: 1,
    });

    $('.prices-popover').popover({
        html : true,
        placement: 'auto',
        content: function() {
            return $(this).next().html();
        }
    });

    $('div.to_cart a').click( function() {
        var catalog_id = $(this).data('catalog_id');
        var amount = $(this).next().find('input.touchspin').val();

        $.shopcart.add_item( catalog_id, amount );
    });
});
