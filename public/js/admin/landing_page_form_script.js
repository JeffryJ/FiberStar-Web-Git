$(document).ready( function() {

    // var y = $("#y");
    // if(y.val() !==""){
    //     $(window).scrollTop(y);
    // }
    InputToImageLink("#background_image",'#background_image_preview');
    InputToImageLink("#benefit1_image","#benefit1_image_preview");
    InputToImageLink("#benefit2_image","#benefit2_image_preview");
    InputToImageLink("#benefit3_image","#benefit3_image_preview");
    InputToImageLink("#benefit4_image","#benefit4_image_preview");

    // $("#slider-content-form").submit(function () {
    //     $("#y").val($(this).offset().top);
    // });

});