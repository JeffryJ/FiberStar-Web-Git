var city = $("#City");
var district = $("#District");
var subdistrict = $("#SubDistrict");
var street =  $("#Street");

var stage = $("#stage");
var coveragelocator = $("#coveragelocator");
var buttonforward = $("#buttonforward");
var youhavebeen = $("#youHaveBeen");

$(document).ready(function(){
    $("body").on("DOMSubtreeModified","#District,#SubDistrict,#Street",function () {
        if($(this).html().length > 0 ){
            $(this).css("display","inline");
        }
        else{
            $(this).css("display","none");
        }
    });
});

city.on('change',function(){
    if (city.val()!=="none"&&city.val()!=="null") {
        stage.html("Stages: "+ $("#City option:selected").text());

        $.get("/api/coverage/kecamatans-of/"+city.val(),function (data) {
            district.empty();

            district.append($("<option></option>").attr("value", 'null').text('--Pick Your District (Kecamatan)--'));
            $.each(data, function(index, value) {
                district.append($("<option></option>")
                    .attr("value", data[index].id).text(data[index].name));
            });
            district.append($("<option></option>").attr("value", 'none').text('My District Does Not Exist'));
        });

        subdistrict.empty();
        street.empty();

        coveragelocator.css("display","none");
        buttonforward.css("display","none");

        youhavebeen.css("display","none");
    }
    else if(city.val() === "null"){
        stage.html("&nbsp;");

        coveragelocator.css("display","none");
        buttonforward.css("display","none");

        district.empty();
        subdistrict.empty();
        street.empty();

        youhavebeen.css("display","none");
    }
    else if(city.val()==="none") {
        stage.html("Stages: Not Listed");

        coveragelocator.css("display","inline");
        buttonforward.css("display","inline");

        district.empty();
        subdistrict.empty();
        street.empty();

        youhavebeen.css("display","none");
    }
});
district.on('change',function(){
    if (district.val()!=="none"&& district.val()!=="null") {
        stage.html("Stages: "+ $("#City option:selected").text()+ " - "+  $("#District option:selected").text());

        $.get("/api/coverage/kelurahans-of/"+district.val(),function (data) {
            subdistrict.empty();

            subdistrict.append($("<option></option>").attr("value", 'null').text('--Pick Your Sub-District (Kelurahan)--'));
            $.each(data, function(index, value) {
                subdistrict.append($("<option></option>")
                    .attr("value", data[index].id).text(data[index].name));
            });
            subdistrict.append($("<option></option>").attr("value", 'none').text('My Sub-district Does Not Exist'));
        });

        street.empty();

        coveragelocator.css("display","none");
        buttonforward.css("display","none");

        youhavebeen.css("display","none");
    }
    else if(district.val() === "null"){
        stage.html("Stages: "+ $("#City option:selected").text());

        coveragelocator.css("display","none");
        buttonforward.css("display","none");

        subdistrict.empty();
        street.empty();

        youhavebeen.css("display","none");
    }
    else if(district.val()==="none") {
        stage.html("Stages: "+ $("#City option:selected").text()+" - " + "Not Listed");

        coveragelocator.css("display","inline");
        buttonforward.css("display","inline");

        subdistrict.empty();
        street.empty();

        youhavebeen.css("display","none");
    }
});
subdistrict.on('change',function(){
    if (subdistrict.val()!=="none"&& subdistrict.val()!=="null") {
        stage.html("Stages: "+ $("#City option:selected").text()+ " - "+  $("#District option:selected").text() +" - "+  $("#SubDistrict option:selected").text());

        $.get("/api/coverage/roads-of/"+subdistrict.val(),function (data) {
            street.empty();

            street.append($("<option></option>").attr("value", 'null').text('--Pick Your Street (Jalan)--'));
            $.each(data, function(index, value) {
                street.append($("<option></option>")
                    .attr("value", data[index].id).text(data[index].name));
            });
            street.append($("<option></option>").attr("value", 'none').text('My Street Does Not Exist'));
        });

        coveragelocator.css("display","none");
        buttonforward.css("display","none");

        youhavebeen.css("display","none");
    }
    else if(subdistrict.val() === "null"){
        stage.html("Stages: "+ $("#City option:selected").text()+ " - "+  $("#District option:selected").text() );

        coveragelocator.css("display","none");
        buttonforward.css("display","none");

        street.empty();

        youhavebeen.css("display","none");
    }
    else if(subdistrict.val()==="none") {
        stage.html("Stages: "+ $("#City option:selected").text()+ " - "+  $("#District option:selected").text()+" - "+"Not Listed");

        coveragelocator.css("display","inline");
        buttonforward.css("display","inline");

        street.empty();

        youhavebeen.css("display","none");
    }
});
street.on('change',function(){
    if (street.val()!=="none"&& street.val()!=="null") {
        stage.html("Stages: "+ $("#City option:selected").text()+ " - "+  $("#District option:selected").text() +" - "+  $("#SubDistrict option:selected").text()+" - "+  $("#Street option:selected").text());

        coveragelocator.css("display","none");
        buttonforward.css("display","none");

        youhavebeen.css("display","inline");
    }
    else if(street.val() === "null"){
        stage.html("Stages: "+ $("#City option:selected").text()+ " - "+  $("#District option:selected").text() +" - "+  $("#SubDistrict option:selected").text());

        coveragelocator.css("display","none");
        buttonforward.css("display","none");

        youhavebeen.css("display","none");
    }
    else if(street.val()==="none") {
        stage.html("Stages: "+ $("#City option:selected").text()+ " - "+  $("#District option:selected").text()+" - "+  $("#SubDistrict option:selected").text() +" - "+"Not Listed");

        coveragelocator.css("display","inline");
        buttonforward.css("display","inline");

        youhavebeen.css("display","none");
    }
});

var submitbtn = $("#buttonsendrequest");

//after map form send
function formCompleted(){

  var timeleft = 5;
  var downloadTimer = setInterval(function(){
  timeleft--;
  document.getElementById("countdowntimer").textContent = timeleft;
  if(timeleft <= 0)
    clearInterval(downloadTimer);
    if (timeleft==0) {
      window.location.reload(1);
    }
  },1000);

  document.getElementById('coverage-form-only').style.display = "none";
  document.getElementById('buttonsendrequest').style.display = "none";
  stage.css("display","none");
  document.getElementById("coverage-request-timer").style.display = "inline";

  document.getElementById("myCoveragelayerseperatoriD").style.height = "30%";
}

$("#coverage-form").submit(function (event) {
    event.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var form = $(this);
    var url = form.attr("action");

    var name = $("#name_input").val();
    var phone_no = $("#phone_no").val();
    var email = $("#email_input").val();
    var street = $("#street_input").val();
    var city = $("#city_input").val();
    var district = $("#district_input").val();
    var subdistrict = $("#subdistrict_input").val();
    var postal_code = $("#postalcode_input").val();
    var latitude = $("#latitude_input").val();
    var longitude = $("#longitude_input").val();

    $.ajax({
        type:'POST',
        url: url,
        data: {
            name: name,
            phone_no: phone_no,
            email: email,
            street: street,
            city: city,
            district:district,
            subdistrict:subdistrict,
            postal_code:postal_code,
            latitude:latitude,
            longitude:longitude
        },
        beforeSend: function () {
            submitbtn.val("Submitting...");
            submitbtn.prop("disabled",true);
        },
    }).done(function () {
        submitbtn.val("Submit");
        submitbtn.prop("disabled",false);
        formCompleted();
    });
});

function gotofooter() {
    var ele = $("#fiberstar-footer");
    $("html,body").animate({
        scrollTop:$(ele).offset().top
    },1500);
}

function exitpopup(){
    hide('popup2');
}

var show = function(id) {
    document.getElementById(id).style.display ='block';
};
var hide = function(id) {
    document.getElementById(id).style.display ='none';
};

