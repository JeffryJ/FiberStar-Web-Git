$(document).ready(function () {

    $(document).on("click",".close",function () {
       $(this).parent().fadeTo(500, 0).slideUp(500, function(){
           $(this).remove();
       });
    });

    window.setTimeout(function() {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 4000);
});