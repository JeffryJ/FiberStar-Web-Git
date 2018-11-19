$(document).ready(function(){
    var userFeed = new Instafeed({
    get: 'user',
    userId: '3032721881',
    accessToken:'3032721881.1677ed0.3df8d910e23d44dd8782136ff4e9eaf2',
    template: '<a class="animation" href="{{link}}"><img src="{{image}}" /></a>',
    sortBy:'most-recent',

    after:function(){
      $('.insta-feed-box').slick({
        slidesToShow:8,
        arrows:false,
        autoplay:true,
        autoplaySpeed:2000,
        variableWidth: true,
      });
    }

  });

  if(document.getElementsByClassName("insta-feed-box").length > 0){
    userFeed.run();
  }
});
