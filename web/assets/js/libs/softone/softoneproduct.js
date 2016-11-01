jQuery('.synafiacode input').live("keyup", function (e) {
    if (e.keyCode == 13) {
        //alert($(this).val());
        var data = {};
        data.erp_code = $(this).val();
        data.id = $(this).attr("id");
        $.post("/product/addRelation", data, function (result) {
            var table = dt_tables["ctrlgettabs"];
            table.fnFilter();
            if (result.returnurl) {
                location.href = result.returnurl;
            }
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