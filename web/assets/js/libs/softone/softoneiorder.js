var b = false;
var orderid = 0;
jQuery('#productfreesearch').live("keyup", function (e) {
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

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-full-width",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}


jQuery(".EltrekaediSendOrder").live('click', function (e) {
    var data = {}
    data.id = jQuery(this).attr('data-id');

    $.post("order/sendorder/", data, function (result) {
        var json = angular.fromJson(result);
        if (json.ErrorCode) {
            toastr.error(json.ErrorDescription, "Error");
        } else {
            
        }
    })
})

jQuery(".EdiBundleEltrekaediOrderItemQty").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.qty = jQuery(this).val();
        $.post("/order/editorderitem/", data, function (result) {
            var json = angular.fromJson(result);
            if (json.error) {
                toastr.error(json.message, "Error");
            }
            var table = dt_tables["ctrlgettabs"];
            //$(".offcanvas-search").click();
            table.fnFilter();
        })
    }
})


jQuery(".SoftoneBundleOrderitemDisc1prc").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.discount = jQuery(this).val();
        $.post("/order/editorderitem/", data, function (result) {
            var json = angular.fromJson(result);
            if (json.error) {
                toastr.error(json.message, "Error");
            }
            var table = dt_tables["ctrlgettabs"];
            //$(".offcanvas-search").click();
            table.fnFilter();
        })
    }
})

jQuery(".SoftoneBundleOrderitemPrice").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.price = jQuery(this).val();
        $.post("/order/editorderitem/", data, function (result) {
            var json = angular.fromJson(result);
            if (json.error) {
                toastr.error(json.message, "Error");
            }
            var table = dt_tables["ctrlgettabs"];
            table.fnFilter();
        })
    }
})



jQuery(".SoftoneBundleProductItemPricew01").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.order = orderid;
        data.item = jQuery(this).attr('data-id');
        data.price = jQuery(this).val();
        data.qty = 1;
        $.post("/order/addorderitem/", data, function (result) {
            var json = angular.fromJson(result);
            if (json.error) {
                toastr.error(json.message, "Error");
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
    table.fnFilter(jQuery('#productfreesearch').val());
    //})
}

function fororder(order) {
    if (jQuery('#productfreesearch').val() && b == true) {
        orderid = order;
        $(".offcanvas-search").click();
        b = false;
    }
}