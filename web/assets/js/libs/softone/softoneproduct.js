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
jQuery('.parentcategoryli').live("click", function (e) {

    var ref = $(this).attr("data-ref");


    var f = this;

    if (ref == undefined) {
        r = true;
    }
    if (r == false) {
        if (jQuery(this).hasClass("categoryli")) {
            if (cref != ref)
                jQuery('.categoryli').slideUp();
            jQuery('.categoryli_' + ref).slideToggle();
            cref = ref;
        }
    }


})


setTimeout(function () {

}, 2000)