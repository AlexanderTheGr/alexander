var b = false;
var orderid = 0;
var productsearch = ''
jQuery('#productfreesearch').live("keyup", function (e) {
    if (e.keyCode == 13) {
        b = true
        //table.fnFilter("",2);
        //table.fnFilter("",3);
        $("#loaderer").show();
        productsearch = "productfreesearch:" + jQuery('#productfreesearch').val();
        asdf(this, productsearch);
        var t = $(this).val();
        jQuery('#productfreesearch').val("");
        jQuery('#productitem').val("");
        jQuery(".brand-select").val(0);
        jQuery(".brand-select").change();
        $(this).val(t);
        jQuery(".brand-select").trigger("chosen:updated")
        jQuery(".brand_model-select").trigger("chosen:updated");
        jQuery(".brand_model_type-select").trigger("chosen:updated");

    }
});
jQuery('#productitem').live("keyup", function (e) {
    if (e.keyCode == 13) {
        //table.fnFilter("",2);
        //table.fnFilter("",3);
        b = true
        $("#loaderer").show();
        productsearch = "productitem:" + jQuery('#productitem').val() + ":supplier:1";
        asdf(this, productsearch);
        var t = $(this).val();
        jQuery('#productfreesearch').val("");
        jQuery('#productitem').val("");
        jQuery(".brand-select").val(0);
        jQuery(".brand-select").change();
        $(this).val(t);
        jQuery(".brand-select").trigger("chosen:updated")
        jQuery(".brand_model-select").trigger("chosen:updated");
        jQuery(".brand_model_type-select").trigger("chosen:updated");
    }
});
jQuery('#classtitem').live("change", function (e) {
    //productsearch = "productitem:" + jQuery('#productitem').val() + ":supplier:" + jQuery('#classtitem').val();
    //asdf(this, productsearch);
    b = false;
    var table = dt_tables["ctrlgetoffcanvases"];
    table.fnFilter(jQuery('#classtitem').val(), 3);


})
jQuery('.rtecdocArticleName').live("click", function (e) {
    b = false;
    var table = dt_tables["ctrlgetoffcanvases"];
    table.fnFilter(jQuery(this).val(), 2);

})


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

setTimeout(function () {

    jQuery("input").each(function () {
        var customerName = jQuery(this).attr("id");
        if (customerName != undefined) {
            var customerNameArr = customerName.split(":");
            var SoftoneBundleOrdercustomerName = customerNameArr[0] + customerNameArr[1] + customerNameArr[2];
            orderid = customerNameArr[3];
            if (SoftoneBundleOrdercustomerName == 'SoftoneBundleOrdercustomerName') {
                customerName = this;
                var $elem = jQuery(customerName).autocomplete({
                    source: "/customer/autocompletesearch",
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
            }
        }
    })

}, 1000)



jQuery(".savesoftone").live('click', function (e) {
    var data = {}
    data.id = jQuery(this).attr('data-id');
    $("#loaderer").show();
    $.post("/order/saveSoftone", data, function (result) {
        $("#loaderer").hide();
        var json = angular.fromJson(result);
        if (json.error) {
            toastr.error(json.error, "Error");
        } else {
            toastr.success(json.error, "Success");
            $(".apestaleni").show();
        }
    })
})
jQuery(".saveinvoicesoftone").live('click', function (e) {
    var data = {}
    data.id = jQuery(this).attr('data-id');
    $("#loaderer").show();
    $.post("/invoice/saveSoftone", data, function (result) {
        $("#loaderer").hide();
        var json = angular.fromJson(result);
        if (json.error) {
            toastr.error(json.error, "Error");
        } else {
            toastr.success(json.error, "Success");
            $(".apestaleni").show();
        }
    })
})


jQuery(".EdiSendOrder").live('click', function (e) {
    var data = {}
    data.id = jQuery(this).attr('data-id');
    $("#loaderer").show();
    $.post("order/sendorder/", data, function (result) {
        $("#loaderer").hide();
        var json = angular.fromJson(result);
        if (json.ErrorCode) {
            toastr.error(json.ErrorDescription, "Error");
        } else {

        }
    })
})

jQuery(".SoftoneBundleOrderitemQty").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.qty = jQuery(this).val();
        $("#loaderer").show();
        $.post("/order/editorderitem/", data, function (result) {
            $("#loaderer").hide();
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
//SoftoneBundleInvoiceItemPrice 
jQuery(".SoftoneBundleInvoiceItemPrice").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.price = jQuery(this).val();
        $("#loaderer").show();
        $.post("/invoice/editinvoiceitem/", data, function (result) {
            $("#loaderer").hide();
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
jQuery(".SoftoneBundleInvoiceItemQty").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.qty = jQuery(this).val();
        $("#loaderer").show();
        $.post("/invoice/editinvoiceitem/", data, function (result) {
            $("#loaderer").hide();
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



jQuery(".deleteinvoiceitem").live('click', function (e) {

    var data = {}
    data.id = jQuery(this).attr('data-id');
    data.qty = 0;
    $("#loaderer").show();
    $.post("/invoice/editinvoiceitem/", data, function (result) {
        $("#loaderer").hide();
        var json = angular.fromJson(result);
        if (json.error) {
            toastr.error(json.message, "Error");
        }
        var table = dt_tables["ctrlgettabs"];
        //$(".offcanvas-search").click();
        table.fnFilter();
    })

})

jQuery(".deleteitem").live('click', function (e) {

    var data = {}
    data.id = jQuery(this).attr('data-id');
    data.qty = 0;
    $("#loaderer").show();
    $.post("/order/editorderitem/", data, function (result) {
        $("#loaderer").hide();
        var json = angular.fromJson(result);
        if (json.error) {
            toastr.error(json.message, "Error");
        }
        var table = dt_tables["ctrlgettabs"];
        //$(".offcanvas-search").click();
        table.fnFilter();
    })

})

jQuery(".SoftoneBundleOrderitemQty").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.qty = jQuery(this).val();
        $("#loaderer").show();
        $.post("/order/editorderitem/", data, function (result) {
            $("#loaderer").hide();
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
        $("#loaderer").show();
        $.post("/order/editorderitem/", data, function (result) {
            $("#loaderer").hide();
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
        $("#loaderer").show();
        $.post("/order/editorderitem/", data, function (result) {
            $("#loaderer").hide();
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
jQuery(".SoftoneBundleOrderitemLineval").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.liveval = jQuery(this).val();
        $("#loaderer").show();
        $.post("/order/editorderitem/", data, function (result) {
            $("#loaderer").hide();
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
        $("#loaderer").show();
        $.post("/order/editorderitem/", data, function (result) {
            $("#loaderer").hide();
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

jQuery(".livevalqty").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.id = jQuery(this).attr('data-id');
        data.livevalqty = jQuery(this).val();
        $("#loaderer").show();
        $.post("/order/editorderitem/", data, function (result) {
            $("#loaderer").hide();
            var json = angular.fromJson(result);
            if (json.error) {
                toastr.error(json.message, "Error");
            }
            var table = dt_tables["ctrlgettabs"];
            table.fnFilter();
        })
    }
})


jQuery(".SoftoneBundleProductAdd").live('click', function (e) {
    var data = {}
    data.order = orderid;
    data.item = jQuery(this).attr('data-id');
    //data.price = jQuery("#SoftoneBundleProductItemPricew01_" + data.item).val();
    data.price = jQuery("#SoftoneBundleProducPrice_" + data.item).val();
    data.qty = 1;
    $("#loaderer").show();
    $.post("/order/addorderitem/", data, function (result) {
        $(".tick_" + data.item).show();
        $("#loaderer").hide();
        var json = angular.fromJson(result);
        if (json.error) {
            toastr.error(json.message, "Error");
        }
        var table = dt_tables["ctrlgettabs"];
        //$(".offcanvas-search").click();
        table.fnFilter();
    })

})
jQuery(".SoftoneBundleProductQty").live('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = {}
        data.order = orderid;
        data.item = jQuery(this).attr('data-id');
        data.price = jQuery("#SoftoneBundleProducPrice_" + data.item).val();
        data.qty = jQuery(this).val();
        $("#loaderer").show();
        $.post("/order/addorderitem/", data, function (result) {
            $(".tick_" + data.item).show();
            $("#loaderer").hide();
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


function asdf(obj, search) {

    var data = {}
    var title = 'Αναζήτηση για "' + $(obj).val() + '"';
    data.terms = $(obj).val();

    //$.post("/edi/eltreka/order/fororder", data, function (result) {
    $("#offcanvas-search .offcanvas-head .text-primary").html(title);

    /*
     var table = dt_tables["ctrlgetoffcanvases2"];
     table.fnFilter(2,1);
     table.fnFilter(jQuery('#productfreesearch').val(),4);    
     */
    jQuery("#DataTables_Table_2_wrapper").hide();
    jQuery("#DataTables_Table_1_wrapper").show();
    data.value = $("#DataTables_Table_1_filter input").val();
    //$("#loaderer").show();
    $.post("/edi/ediitem/getorderedis", data, function (result) {
        //$("#loaderer").hide();
        $("#extracanvascontent").html(result.html);
    })


    var table = dt_tables["ctrlgetoffcanvases"];
    table.fnFilter(search);

    var table2 = dt_tables["ctrlgetoffcanvases2"];
    table2.fnFilter('');
    setTimeout(function () {
        jQuery(".SoftoneBundleProductQty").val(1);

    }, 1000)
    //})
}


function asdf2(obj) {

    //var data = {}
    //var title = 'Αναζήτηση για "' + $(obj).val() + '"';
    //data.terms = $(obj).val()
    //$.post("/edi/eltreka/order/fororder", data, function (result) {

    //$("#offcanvas-search .offcanvas-head .text-primary").html(title);
    var table = dt_tables["ctrlgetoffcanvases"];
    var table2 = dt_tables["ctrlgetoffcanvases2"];
    table.fnFilter(obj.all);
    table2.fnFilter(obj.all);
    //$(".offcanvas-search").click();
    setTimeout(function () {
        jQuery(".SoftoneBundleProductQty").val(1);
    }, 1000)
    //})
}
function fororder2(order) {


}
var offcanvassearch = false;
$(document).keydown(function (e) {
    // ESCAPE key pressed
    if (e.keyCode == 27) {
        if (offcanvassearch) {
            $(".offcanvas-search").click();
            offcanvassearch = !offcanvassearch;
        }
    }
});

function fororder(order) {
    if (b == true) {
        orderid = order;
        $(".offcanvas-search").click();
        offcanvassearch = !offcanvassearch;
        var data = {}
        data.value = $("#DataTables_Table_1_filter input").val();
        $("#loaderer").show();
        $.post("/edi/ediitem/getorderedis", data, function (result) {
            $("#loaderer").hide();
            $("#extracanvascontent").html(result.html);
        })
        jQuery("#DataTables_Table_2_wrapper").hide();
        jQuery("#DataTables_Table_1_wrapper").show();
        jQuery("#classtitem").chosen({width: "300px"});
        b = false;
    }


    var tecdocArticleName = [];
    $("span.tecdocArticleName").each(function () {
        tecdocArticleName[$(this).text()] = $(this).text();
    })
    var as = "<div style='float:left width:600px;'>";
    as = as + "<div style='float:left; margin-left:5px;'><input type='radio' class='rtecdocArticleName' name='tecdocArticleName' value = ''><label>Καθαρισμός</label></div>";
    for (var i in tecdocArticleName) {
        if (i != '') {
            as = as + "<div style='float:left; margin-left:5px;'><input type='radio' class='rtecdocArticleName' name='tecdocArticleName' value = '" + i + "'><label>" + i + "</label></div>";
        }
    }
    $("#tecdocArticleName").html(as);

}


jQuery('.ediiteqty1, .ediiteqty2, EdiBundleEdiOrderItemQty, .SoftoneBundleProductEdi').live("keyup", function (e) {
    if (e.keyCode == 13) {
        var data = {};
        if (jQuery(this).attr('class') == 'SoftoneBundleProductEdi') {
            data.product = jQuery(this).attr('data-id');
            var store = data.product;
        } else {
            data.id = jQuery(this).attr('data-id');
            var store = data.id;
        }
        data.qty = jQuery(this).val();
        data.price = jQuery(this).attr('data-price');
        data.order = jQuery(this).attr('data-order');
        data.store = jQuery("#store_" + store).val();
        $("#loaderer").show();
        $.post("/edi/order/addorderitem/", data, function (result) {
            $("#loaderer").hide();
            if (result.error) {
                toastr.error(result.message, result.message);
            } else {
                toastr.success(result.error, result.message);

                if (result.product > 0) {

                    data.order = orderid;
                    data.item = result.product;//jQuery(this).attr('data-id');
                    data.price = result.price;//jQuery("#SoftoneBundleProductItemPricew01_" + data.item).val();
                    //data.qty = jQuery(this).val();
                    $("#loaderer").show();
                    $.post("/order/addorderitem/", data, function (result) {
                        $(".tick_" + data.item).show();
                        $("#loaderer").hide();
                        var json = angular.fromJson(result);
                        if (json.error) {
                            toastr.error(json.message, "Error");
                        }
                        var table = dt_tables["ctrlgettabs"];
                        //$(".offcanvas-search").click();
                        table.fnFilter();
                    })

                }
            }
        })

    }
});

jQuery('.create_edi_product').live("click", function (e) {

    var data = {};
    if (jQuery(this).attr('class') == 'SoftoneBundleProductEdi') {
        data.product = jQuery(this).attr('data-id');
        var store = data.product;
    } else {
        data.id = jQuery(this).attr('data-id');
        var store = data.id;
    }
    data.qty = 0;
    data.store = 0;
    $("#loaderer").show();
    $.post("/edi/order/addorderitem/", data, function (result) {
        $("#loaderer").hide();
        if (result.error) {
            toastr.error(result.message, result.message);
        } else {
            toastr.success(result.error, result.message);
        }
    })

});


jQuery('.SoftoneBundleGBGProductAdd').live("click", function (e) {
    //if (e.keyCode == 13) {
    var data = {};
    data.product = jQuery(this).attr('data-id');
    var store = data.product;
    data.qty = 1;
    data.price = jQuery(this).attr('data-price');
    data.porder = order;//jQuery(this).attr('data-order');
    data.store = jQuery(this).attr('data-qty')//jQuery("#store_" + store).val();
    $("#loaderer").show();
    $.post("/edi/order/addorderitem/", data, function (result) {
        $("#loaderer").hide();
        if (result.error) {
            toastr.error(result.message, result.message);
        } else {
            toastr.success(result.error, result.message);
        }
    })
    //}
});

jQuery(".create_product").live('click', function () {
    var ref = jQuery(this).attr("data-ref");
    var data = {};
    data.ref = ref;
    $("#loaderer").show();
    $.post("/product/createProduct", data, function (result) {
        $("#loaderer").hide();
        if (result.returnurl) {
            var win = window.open(result.returnurl);
        }
    })
})
var $dialog = {};
$dialog.productInfo = $("<div style='z-index:100000' class='card'></div>")
        .dialog({
            autoOpen: false,
            resizable: false,
            draggable: false,
            width: 500,
            modal: true
        });
jQuery(".product_info").live('click', function () {
    var ref = jQuery(this).attr("data-ref");
    var articleId = jQuery(this).attr("data-articleId");
    var data = {};
    data.articleId = articleId;
    data.ref = ref;
    data.car = jQuery(".brand_model_type-select").val();

    $.post("/product/productInfo", data, function (result) {
        $dialog.productInfo.html(result);
        $dialog.productInfo.dialog("open");
        $("#productInfoTabs").tabs();

    })
})
jQuery(".productfano_info").live('click', function () {
    var ref = jQuery(this).attr("data-ref");
    jQuery('.productfanoimg_' + ref).show();
})
jQuery(".productfanoimg").live('click', function () {
    jQuery(this).hide();
})



jQuery(".edibutton").live('click', function () {
    //productsearch = '';
    var edi = jQuery(this).attr("data-id")
    if (edi == 0) {
        jQuery("#DataTables_Table_2_wrapper").hide();
        jQuery("#DataTables_Table_1_wrapper").show();
    } else {
        var table = dt_tables["ctrlgetoffcanvases2"];
        table.fnFilter(edi, 1, productsearch, true, false);
        table.fnFilter(productsearch, 4, true, false);
        //table.fnFilter('aaaa', 14, true, false);
        //var articleIds = 'asas';
        jQuery("#DataTables_Table_1_wrapper").hide();
        jQuery("#DataTables_Table_2_wrapper").show();
        /*
         table.fnDestroy();
         oTable.product = $('#product').dataTable({
         "sAjaxSource": 'http://192.168.1.105/developing/monitor/product/product/ajaxjson',
         "sServerMethod": 'POST',
         "sPaginationType": 'full_numbers',
         "fnServerParams": function (aoData) {
         aoData.push({"name": "articleIds", "value": articleIds});
         },
         "aLengthMenu": [[100, 150, 200, -1], [100, 150, 200, 'All']],
         "iDisplayLength": 100, "bPaginate": true,
         "bFilter": true, "fnInitComplete": function () {
         loadUi()
         }, "bAutoWidth": false, "bInfo": true, "bRetrieve": 'true', "aaSorting": [[0, 'desc']], "aoColumns": [null, null, null, null, null, null, null, null], "bProcessing": true, });
         */




    }
});


jQuery(".modeldiv").live('click', function () {
    //alert('sss');
    jQuery(this).find('.modelitem').toggle();
});
jQuery(".modeldiv").live('mouseout', function () {
    //alert('sss');
    //jQuery('.modelitem').hide();
});

jQuery(".forordersupplier").live('click', function () {
    //alert('sss');
    var data = {}
    data.id = jQuery(this).attr("data-ref");
    //data.order = jQuery(this).attr("data-order");
    data.order = order;
    //jQuery(this).find('.orderitemstable').show();
    if (data.id > 0 && jQuery(this).find('.ediprices').text() == '') {
        //jQuery('.ediprices').hide();
        var obj = this;
        jQuery.post("/product/getediprices", data, function (result) {
            jQuery('.ediprices_' + data.id).html(result);
            jQuery('.ediprices_' + data.id).show();
            jQuery('.ediprices_' + data.id).find('.orderitemstable').show();
            //jQuery('.orderitemstable').show();
        })
    }
});

jQuery(".alexander tr").live('mouseover', function () {
    //alert('sss');
    var data = {}
    data.id = jQuery(this).attr("data-ref");
    jQuery(this).find('.orderitemstable').show();
    //jQuery('.ediprices').html('');
    var obj = this;

});
jQuery(".ediprices").live('mouseout', function () {
    jQuery(this).hide();
})
jQuery(".ediprices").live('mouseover', function () {
    jQuery(this).show();
})

jQuery(".alexander").live('mouseout', function () {
    jQuery('.ediprices').hide();
});

jQuery(".alexander tr").live('mouseout', function () {
    //alert('sss');
    jQuery('.orderitemstable').hide();

});

jQuery(".offcanvas-tools .md-close").live("click", function () {
    $(".offcanvas-search").click();
    offcanvassearch = !offcanvassearch;
})
var order = 0;
setTimeout(function () {
    var $elem = jQuery("#searchmotor").autocomplete({
        source: "/order/motorsearch",
        method: "POST",
        minLength: 2,
        select: function (event, ui) {
            //alert(ui.item.value);
            //jQuery(".brand_model_type-select").val(ui.item.value)
            //jQuery("#gogo").click();
            asdda(order, ui.item.value, ui.item.label);
            jQuery("#searchmotor").val("");
        }
    })
}, 1000)
function asdda(order, car, cartext) {
    var data = {};
    data.car = car;
    data.order = order;
    jQuery(".subcategories").html("");
    jQuery(".categories").html("");
    if (data.car > 0) {
        $("#loaderer").show();
        jQuery.post("/order/getcategories", data, function (json) {
            $("#loaderer").hide();
            var nodes = [];
            var articles_count = [];
            var matched_count = [];
            var edimatched_count = [];
            var html = '<h2>' + cartext + '</h2>';
            html += '<div style="float:left; width:100%" id="accordion">';
            var as = json;

            jQuery.each(as, function (i, optionHtml) {
                if (!nodes[optionHtml.parentNodeId]) {
                    nodes[optionHtml.parentNodeId] = [];
                    articles_count[optionHtml.parentNodeId] = 0;
                    matched_count[optionHtml.parentNodeId] = 0;
                    edimatched_count[optionHtml.parentNodeId] = 0;
                }
                nodes[optionHtml.parentNodeId].push(optionHtml);
                articles_count[optionHtml.parentNodeId] += optionHtml.articles_count * 1;
                matched_count[optionHtml.parentNodeId] += optionHtml.matched_count * 1;
                edimatched_count[optionHtml.parentNodeId] += optionHtml.edimatched_count * 1;
            });

            jQuery.each(json, function (i, optionHtml) {
                if (optionHtml.parentNodeId == 0) {
                    html += '<h3 class="style-info">' + optionHtml.assemblyGroupName + ' (<span style="color:red">' + edimatched_count[optionHtml.assemblyGroupNodeId] + '</span>) (' + matched_count[optionHtml.assemblyGroupNodeId] + ') (<span style="color:blue">' + articles_count[optionHtml.assemblyGroupNodeId] + '</span>)</h3>';
                    html += '<div class="subcategoriesul" data-id="' + optionHtml.assemblyGroupNodeId + '">';
                    html += '<ul class="list">';
                    if (nodes[optionHtml.assemblyGroupNodeId]) {
                        jQuery.each(nodes[optionHtml.assemblyGroupNodeId], function (o, node) {
                            html += '<li class="subcategoriesli" data-car="' + jQuery(".brand_model_type-select").val() + '" data-all="' + node.all + '" style="cursor:pointer">' + node.assemblyGroupName + ' (<span style="color:red">' + node.edimatched_count + '</span>) (' + node.matched_count + ') (<span style="color:blue">' + node.articles_count + '</span>)</li>';
                        });
                    }
                    html += '<ul>';
                    html += '</div>';
                }
            });
            html += '</div>';
            jQuery('.categories').append(html);
            jQuery("#accordion").accordion({collapsible: true, active: false});
            jQuery("#searchmotor").val("");
        })
    }
}