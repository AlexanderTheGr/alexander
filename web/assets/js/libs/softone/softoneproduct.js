jQuery('.synafiacode input').live("keyup", function (e) {
    if (e.keyCode == 13) {
        alert($(this).val());
    }
});


var $elem = jQuery(".synafiacode input").autocomplete({
    source: "/customer/autocompletesearch",
    method: "POST",
    minLength: 2,
    select: function (event, ui) {
        var data = {}
        $.post("/product/seachProduct", data, function (result) {
            if (result.returnurl) {
                //location.href = result.returnurl;
            }
        })
    }
})



var $elem = jQuery(".synafiacode input").autocomplete({
    source: "/product/autocompletesearch",
    method: "POST",
    minLength: 2,
    select: function (event, ui) {
        var data = {}
        data.id = customerNameArr[3];
        data.customer = ui.item.id;
        data.customerName = ui.item.label;
        $.post("/order/saveCustomer", data, function (result) {
            if (result.returnurl) {
                location.href = result.returnurl;
            }
        })
    }
})