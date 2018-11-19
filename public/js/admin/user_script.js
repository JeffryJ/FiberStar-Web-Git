$(document).ready(function(){
    $(document).on("click",".btn-edit-modal",function () {
        var id = $(this).attr("data-id");
        $($(this).attr("data-target")).load('users/edit/'+id,function () {
            $(this).modal();
        });

    });

    $(document).on("click","#btn-invite",function () {
        $($(this).attr("data-target")).load('users/invite', function () {
            $(this).modal();
        });

    });
});