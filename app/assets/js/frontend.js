function Shopcart() {
    this.update_top_view = function (html) {
        $('#shopcart_button').html(html);
    };

    this.add_item = function ( catalog_id, amount ) {
        $.ajax({
            url: "/cart/add",
            method: "POST",
            cache: false,
            dataType: 'json',
            data: {
                catalog_id: catalog_id,
                amount: amount
            },
            success: function (data) {
                $.shopcart.update_top_view(data.top_view);
            }
        });
    };

    this.delete_item = function (catalog_id) {
        bootbox.confirm( "Удалить позицию?", function(result) {
            if (result) {

                $.ajax({
                    url: "/cart/delete",
                    method: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        catalog_id: catalog_id
                    },
                    success: function (data) {
                        window.location.replace("/cart");
                    }
                });

            }
        });
    };

    this.clear = function () {
        bootbox.confirm( "Вы действительно желаете очистить корзину?", function(result) {
            if (result) {

                $.ajax({
                    url: "/cart/clear",
                    method: "POST",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        window.location.replace("/cart");
                    }
                });

            }
        });
    };
}

$(function () {
    $.shopcart = new Shopcart();
});

