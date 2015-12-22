var b = false;
var orderid = 0;
jQuery('#eltrekaediitem').live("keyup", function (e) {
    if (e.keyCode == 13) {
        asdf(this);
        var t = $(this).val();
        jQuery('#productfreesearch').val("");
        jQuery(".brand-select").val(0);
        jQuery(".brand-select").change();
        $(this).val(t);
        jQuery(".brand-select").trigger("chosen:updated")
        jQuery(".brand_model-select").trigger("chosen:updated");
        jQuery(".brand_model_type-select").trigger("chosen:updated");
    }
});

jQuery(".EltrekaediSendOrder").live('click', function (e) {
        var data = {}
        data.id = jQuery(this).attr('data-id');

        $.post("/edi/eltreka/order/sendorder/", data, function (result) {
            
        })    
})

jQuery(".EdiBundleEltrekaediOrderItemQty").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.qty = jQuery(this).val();
        $.post("/edi/eltreka/order/editorderitem/", data, function (result) {
            var json = angular.fromJson(result);
            if (json.error) {
                alert(json.message)
            }
            var table = dt_tables["ctrlgettabs"];
            //$(".offcanvas-search").click();
            table.fnFilter();
        })
    }
})


jQuery(".EdiBundleEltrekaediOrderItemDiscount").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.discount = jQuery(this).val();
        $.post("/edi/eltreka/order/editorderitem/", data, function (result) {
            var json = angular.fromJson(result);
            if (json.error) {
                alert(json.message)
            }
            var table = dt_tables["ctrlgettabs"];
            //$(".offcanvas-search").click();
            table.fnFilter();
        })
    }
})

jQuery(".EdiBundleEltrekaediOrderItemPrice").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.price = jQuery(this).val();
        $.post("/edi/eltreka/order/editorderitem/", data, function (result) {
            var json = angular.fromJson(result);
            if (json.error) {
                alert(json.message)
            }
            var table = dt_tables["ctrlgettabs"];
            table.fnFilter();
        })
    }
})



jQuery(".EdiBundleEltrekaediRetailprice").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.order = orderid;
        data.item = jQuery(this).attr('data-id');
        data.price = jQuery(this).val();
        data.qty = 1;
        $.post("/edi/eltreka/order/addorderitem/", data, function (result) {

            var json = angular.fromJson(result);
            if (json.error) {
                alert(json.message)
            }
            var table = dt_tables["ctrlgettabs"];
            $(".offcanvas-search").click();
            table.fnFilter();
        })
    }
})
function asdf(obj, filter, freesearch) {

    var data = {}
    var title = 'Αναζήτηση για "' + $(obj).val() + '"';
    data.terms = $(obj).val();

    //$.post("/edi/eltreka/order/fororder", data, function (result) {
    b = true;
    $("#offcanvas-search .offcanvas-head .text-primary").html(title);
    var table = dt_tables["ctrlgetoffcanvases"];
    table.fnFilter(jQuery('#eltrekaediitem').val());
    //})
}

function fororder(order) {
    if (jQuery('#eltrekaediitem').val() && b == true) {
        orderid = order;
        $(".offcanvas-search").click();
        b = false;
    }
}