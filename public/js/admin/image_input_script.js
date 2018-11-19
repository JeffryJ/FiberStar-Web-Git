$(document).ready( function() {
    $(document).on('change', '.btn-file :file', function() {
        var input = $(this);
        // var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

        var files = input.prop("files");
        var filenames = $.map(files, function (val) {
            return val.name;
        });

        var label = "";

        for(var i = 0 ; i < filenames.length ; i ++){
            if(i < filenames.length -1 ){
                label = label+filenames[0]+", ";
            }
            else{
                label = label+filenames[0];
            }
        }

        input.trigger('fileselect', [label]);
    });

    $(document).on('fileselect', '.btn-file :file', function (event, label) {
        var input = $(this).parents('.input-group').find(':text'),
            log = label;

        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
    });

    // $('.btn-file :file').on('fileselect', function(event, label) {
    //
    //     var input = $(this).parents('.input-group').find(':text'),
    //         log = label;
    //
    //     if( input.length ) {
    //         input.val(log);
    //     } else {
    //         if( log ) alert(log);
    //     }
    // });


});

function readURL(input, image) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(image).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function InputToImageLink(inputSelector,imageSelector){
    $(inputSelector).change(function(){
        readURL(this,imageSelector);
    });
}