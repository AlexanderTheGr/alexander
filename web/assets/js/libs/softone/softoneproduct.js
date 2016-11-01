jQuery('.synafiacode input').live("keyup", function (e) {
    if (e.keyCode == 13) {
        alert($(this).val());
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