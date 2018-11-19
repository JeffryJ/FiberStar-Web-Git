function phoneInput(selector){
    $(document).on("keydown",selector,function (e) {
        if(
            (e.keyCode >=48 && e.keyCode<=57)       //digit only
            ||(e.keyCode == 187 && e.shiftKey)      //plus key
            || (e.keyCode == 189 && !e.shiftKey)    //minus key
            || e.keyCode == 8                       //backspace key
            || e.keyCode == 37                      //left key
            || e.keyCode == 39                      //right key
            || e.keyCode == 18                      //alt key
            || e.ctrlKey && e.keyCode == 65         //CTRL+A key
            || e.ctrlKey && e.keyCode == 67         //CTRL+C key
            || e.ctrlKey && e.keyCode == 86         //CTRL+V key
        ){
            return true;
        }else{
            return false;
        }
    });
}