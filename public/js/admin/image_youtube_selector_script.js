$(document).ready(function () {
    var selector = $("#media_type");
    var imageDiv = $("#image-div");
    var youtubeDiv = $("#youtube-div");

    checkVisible();

    selector.change(function () {
        checkVisible();
    });

    function checkVisible() {
        if(selector.val() === "image"){
            youtubeDiv.hide();
            youtubeDiv.find(':text').val("");
            imageDiv.show();
        }
        else{
            imageDiv.hide();
            imageDiv.find(":file").val("");
            imageDiv.find(":text").val("");
            youtubeDiv.show();
        }
    }
});

