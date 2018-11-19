$(document).ready(function () {
    InputToImageLink("#imgInp","#img-upload");

    $("#imgInp").change(function (e) {
       var filenameAndExt = e.target.files[0].name;
       var filename = filenameAndExt.substr(0,filenameAndExt.lastIndexOf('.'));
       $("#volume").val(filename).prop("disabled",false);
    });
});