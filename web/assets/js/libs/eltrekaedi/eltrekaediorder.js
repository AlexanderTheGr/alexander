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

var bobj;
function asdf(obj, filter, freesearch) {

    bobj = obj;
    var data = {}
    var title = 'Αναζήτηση για "' + $(obj).val() + '"';
    data.order = '<?php echo $model->id ?>'
    data.terms = $(obj).val();
    data.stype = $('input[name=stype]:checked').val();
    if (freesearch) {
        data.freesearch = 1;
    }
    if (filter) {
        bfilter.push(filter);
        data.filter = bfilter;
    }

    $.post("/edi/eltreka/order/fororder", data, function (result) {
        //$("#offcanvas-search .offcanvas-body").html(result);
        $("#offcanvas-search .offcanvas-head .text-primary").html(title);
        var table = dt_tables["ctrlgetoffcanvases"];
        table.fnFilter(jQuery('#eltrekaediitem').val());
        //$(".offcanvas-search").click();

    })
}
function fororder() {
    if (jQuery('#eltrekaediitem').val()) {
        $(".offcanvas-search").click();
    }
}