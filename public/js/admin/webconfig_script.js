var number = 0;

$(document).ready(function () {
    QuillInitWithPlaceholder(["#address"],"#webconfig_form","Company Address");
    phoneInput('#phone');
    phoneInput('#fax');
    InputToImageLink("#logo_image","#logo_image_preview");
    InputToImageLink("#cuscare_image",'#cuscare_image_preview');


    $(document).on("click",".btn-edit-socmed-modal",function () {
        var id = $(this).attr("data-id");
        $($(this).attr("data-target")).load('webconfig/social-media/edit/'+id,function () {
            $(this).modal();
        });
    });

    $(document).on("click","#btn-add-socmed-modal",function () {
        $($(this).attr("data-target")).load('webconfig/social-media/add',function () {
            $(this).modal();
        });
    });

    $(document).on("click",".btn-edit-apikey-modal",function () {
        var id = $(this).attr("data-id");
        $($(this).attr("data-target")).load('webconfig/bing-api-key/edit/'+id,function () {
            $(this).modal();
        });
    });

    $(document).on("click","#btn-add-apikey-modal",function () {
        $($(this).attr("data-target")).load('webconfig/bing-api-key/add',function () {
            $(this).modal();
        });
    });

    var lastInput = $("#cc-container input[type=text]").last();
    if(lastInput.length){
        number = parseInt( lastInput.attr("id").replace(/[^0-9]/g,'') );
    }

    var toBeDeleted = $("#to_be_deleted");
    var valToBeDeleted = [];

    $("#btn-add-cc").click(function (e) {
        e.preventDefault();
        number++;
        createNewCCField("#cc-container");

    });

    $("#cc-container").on('click','.delete-field', function (e) {
        e.preventDefault();

        var target =  $(this).data("target");
        var value = $(target).parent().find("input[type=hidden]").val();

        if(value != 0){
            valToBeDeleted.push(value);
            toBeDeleted.val(JSON.stringify(valToBeDeleted));
        }

        deleteCCField(
            [ target , $(this) ]
        );

        var i = 1;
        $("#cc-container input[type=text]").each(function () {
            $(this).attr("id","cc-"+i);
            $(this).attr("placeholder","CC "+i);
            i++;
        });
        i = 1;
        $("#cc-container button").each(function () {
            $(this).data("target","#cc-"+i);
            i++;
        });

        number--;
    });


});

function createNewCCField(selector){
    $(selector).append(
        '<div class="col-md-offset-2 col-md-6 col-xs-8">\n' +
        '    <input type="text" class="form-control" id="cc-'+number+'" placeholder="CC '+number+'" name="ccs[]">\n' +
        '    <input type="hidden" name="cc_ids[]" value="0">'+
        '</div>'+
        '<div class="error col-xs-4">\n' +
        '    <button class="delete-field btn btn-danger" id="button-'+number+'" data-target="#cc-'+number+'">Delete</button>\n' +
        '</div>'
    );
}

function deleteCCField(selectors) {
    for (var i = 0;  i < selectors.length ; i++){
        $(selectors[i]).parent().remove();
    }
}