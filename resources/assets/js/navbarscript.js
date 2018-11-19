window.sr = ScrollReveal();

$(document).ready(function(){

    var scTop = 0;
    $(window).scroll(function(){
        scTop = $(window).scrollTop();
        $('.counter').html(scTop);

        if(scTop >=100){
            $('.navbar-wrapper').addClass('navbar-opacity');
        }else if(scTop < 100){
            $('.navbar-wrapper').removeClass('navbar-opacity');
        }

    });


    $('#contact-us').click(function(){
      $('html,body').animate({
        scrollTop: $('#fiberstar-footer').offset().top
        },1000);
    });

});
