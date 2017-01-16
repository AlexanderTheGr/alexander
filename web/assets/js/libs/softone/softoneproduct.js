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

var $elem = jQuery(".synafiacode input").autocomplete({
    source: "/product/autocompletesearch",
    method: "POST",
    minLength: 2,
    select: function (event, ui) {
        var data = {}
    }
})

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
}, 1000)