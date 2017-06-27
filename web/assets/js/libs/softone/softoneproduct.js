jQuery('.synafiacode input').live("keyup", function (e) {
    if (e.keyCode == 13) {
        //alert($(this).val());
        var data = {};
        data.erp_code = $(this).val();
        data.id = $(this).attr("id");
        $("#loaderer").show();
        $.post("/product/addRelation", data, function (result) {
            $("#loaderer").hide();
            var table = dt_tables["ctrlgettabs"];
            table.fnFilter();
            jQuery('.synafiacode input').val('')
        })

    }
});



jQuery('.parentcat input').live("keyup", function (e) {
    if (e.keyCode == 13) {
        //alert($(this).val());
        var data = {};
        data.name = $(this).val();
        data.id = $(this).attr("id");
        $("#loaderer").show();
        $.post("/category/addParent", data, function (result) {
            $("#loaderer").hide();
            var table = dt_tables["ctrlgettabs"];
            table.fnFilter();
            jQuery('.parentcat input').val('')
        })

    }
});

var r = false;
var cref = 0;
jQuery('.parentcategorylia').live("click", function (e) {

    var ref = $(this).attr("data-ref");


    var f = this;

    if (ref == undefined) {
        r = true;
    }
    if (r == false) {
        if (jQuery(this).hasClass("parentcategorylia")) {
            if (cref != ref)
                jQuery('.categoryul').slideUp();
            jQuery('.categoryul_' + ref).slideToggle();
            cref = ref;
        }
    }


})
jQuery('.productcategorychk').live('click', function () {
    var ref = $(this).attr("data-ref");
    var data = {};
    data.category = $(this).attr("data-ref");
    data.product = $(this).attr("data-product");
    $.post("/product/addCategory", data, function (result) {
        $("#loaderer").hide();
        var table = dt_tables["ctrlgettabs"];
        table.fnFilter();
        jQuery('.parentcat input').val('')
    })
})

setTimeout(function () {
    jQuery("select.form-control").chosen({width: "100%"});
    var obj = $(".synafiacode input");
    var $elem = jQuery(".synafiacode input").autocomplete({
        source: "/product/autocompletesearch",
        method: "POST",
        minLength: 2,
        select: function (event, ui) {
            var data = {};
            data.erp_code = ui.item.value;
            data.id = obj.attr("id");
            $("#loaderer").show();
            $.post("/product/addRelation", data, function (result) {
                $("#loaderer").hide();
                var table = dt_tables["ctrlgettabs"];
                table.fnFilter();
                jQuery('.synafiacode input').val('')
                jQuery("#SoftoneBundle:Product:sisxetisi:"+data.id).val(result.sisxetisi);
            })
        }
    })
}, 1000)

jQuery('.brandmodellia').live('click', function () {
    $(this).slideToggle();
})

jQuery('.brandmodellia').live('click', function () {
    
    
    var ref = $(this).attr("data-ref");
    var data = {};
    data.brandModel = $(this).attr("data-ref");
    data.product = $(".pbrands").attr("data-prod");
    //$(".pbrandmodelstypes").slideUp();
    $.post("/product/getBrandmodeltypes", data, function (result) {
        $(".pbrandmodelstypes_"+data.brandModel).html(result.data);
        $('.pbrandmodelstypes_' + ref).slideToggle();
    })
})
