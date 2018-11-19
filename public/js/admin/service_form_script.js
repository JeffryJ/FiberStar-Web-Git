var number = 0;

$(document).ready(function () {
    var lastInput = $("#advantage-container input[type=text]").last();

    if(lastInput.length){
        number = parseInt( lastInput.attr("id").replace(/[^0-9]/g,'') );
    }

    var toBeDeleted = $("#to_be_deleted");
    var valToBeDeleted = [];

    QuillInit(["#description"], "#service_form");
    InputToImageLink("#imgInp","#img-upload");

    $("#btn-add-advantage").click(function (e) {
        e.preventDefault();
        number++;
        createNewAdvantageField("#advantage-container");

    });

    $("#advantage-container").on('click','.delete-field', function (e) {
        e.preventDefault();

        var target =  $(this).data("target");
        var value = $(target).parent().find("input[type=hidden]").val();

        if(value != 0){
            valToBeDeleted.push(value);
            toBeDeleted.val(JSON.stringify(valToBeDeleted));
        }

        deleteAdvantageField(
            [ target , $(this) ]
        );

        var i = 1;
        $("#advantage-container input[type=text]").each(function () {
            $(this).attr("id","advantage-"+i);
            $(this).attr("placeholder","Advantage "+i);
            i++;
        });
        i = 1;
        $("#advantage-container button").each(function () {
            $(this).data("target","#advantage-"+i);
            i++;
        });

        number--;
    });
});

function createNewAdvantageField(selector){
    $(selector).append(
        '<div class="col-md-offset-2 col-md-6 col-xs-8">\n' +
        '    <input type="text" class="form-control" id="advantage-'+number+'" placeholder="Advantage '+number+'" name="advantages[]">\n' +
        '    <input type="hidden" name="advantage_ids[]" value="0">'+
        '</div>'+
        '<div class="error col-xs-4">\n' +
        '    <button class="delete-field btn btn-danger" id="button-'+number+'" data-target="#advantage-'+number+'">Delete</button>\n' +
        '</div>'
    );
}

function deleteAdvantageField(selectors) {
    for (var i = 0;  i < selectors.length ; i++){
        $(selectors[i]).parent().remove();
    }
}