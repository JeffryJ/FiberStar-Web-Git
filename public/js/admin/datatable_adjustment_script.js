var wrapper = $(".content-wrapper");
var lastWidth = wrapper.css('width');
var tables = [];

function checkWrapperWidth() {
    var width = wrapper.css('width');
    if( width != lastWidth){
        for(var i = 0; i < tables.length ; i ++){
            tables[i].columns.adjust().draw();
        }
        lastWidth = width;
    }

    setTimeout(checkWrapperWidth,100);
}

$(document).ready(function () {
    checkWrapperWidth();

    $(".table").each(function () {
        tables.push(
            $(this).DataTable({
                "scrollX" : true,
                "order": []
            })
        );
    });
});