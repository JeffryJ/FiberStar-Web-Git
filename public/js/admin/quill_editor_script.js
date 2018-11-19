function QuillInit(selectors, form){
    var quills = [];
    var targetInputs = [];

    for(var i = 0; i < selectors.length ; i ++){

        var quill = new Quill(selectors[i],{
            theme:'snow'
        });

        quills.push(quill);
        targetInputs.push( $(selectors[i]).data("target") );
    }

    var formElement = document.querySelector(form);

    formElement.onsubmit = function () {
        for (var i = 0 ; i < quills.length ; i++){
            var element = document.querySelector('input[name='+targetInputs[i]+']');

            element.value = quills[i].root.innerHTML;
        }
    };

}

function QuillInitWithPlaceholder(selectors, form, placeholder){
    var quills = [];
    var targetInputs = [];

    for(var i = 0; i < selectors.length ; i ++){

        var quill = new Quill(selectors[i],{
            theme:'snow',
            placeholder:placeholder
        });

        quills.push(quill);
        targetInputs.push( $(selectors[i]).data("target") );
    }

    var formElement = document.querySelector(form);

    formElement.onsubmit = function () {
        for (var i = 0 ; i < quills.length ; i++){
            var element = document.querySelector('input[name='+targetInputs[i]+']');

            element.value = quills[i].root.innerHTML;
        }
    };

}

// var quill = new Quill('.editor',{
//     theme:'snow'
// });
//
// var form = document.querySelector('#news_form');
//
// form.onsubmit = function () {
//     var article = document.querySelector('input[name=article]');
//     // article.value = JSON.stringify(quill.getContents());
//
//     article.value = quill.root.innerHTML;
// };



