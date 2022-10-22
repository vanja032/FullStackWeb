var locationTeleport = "index.php";
var galleryPicture = null;
var pictureTypes = [];
var pictures = [];
var messages = [];
var requestTypes = null;
var requestPictures = null;
var requestMessages = null;
const imageTypes = ["image/png", "image/gif", "image/jpeg", "image/jpg", "image/svg+xml", "image/bmp", "image/tiff"];
const byteSize = 52428800;//File size in MB
if($("html").attr("self")){
    if($("html").attr("self").toString().localeCompare("updategallery")===0 || $("html").attr("self").toString().localeCompare("gallery")===0){
        requestTypes = getImageTypes();
        requestPictures = getImages();
    }
    else if($("html").attr("self").toString().localeCompare("messages")===0){
        requestMessages = getMessages();
    }
}

$(document).ready(function(){
    if($("html").attr("self")){
        if($("html").attr("self").toString().localeCompare("updategallery") === 0 || $("html").attr("self").toString().localeCompare("gallery") === 0){
            requestTypes.then(function(data){
                parseImageTypes($("#imagegallerytype"), $("#picturetypescontainer"));
                parseImageTypes($("#gallerytyperemove"));
            }).then(function(data){
                requestPictures.then(function(data){
                    if(window.location.href.split("?").length > 1 && $("html").attr("self").toString().localeCompare("gallery")===0){
                        var parameter = window.location.href.split("?")[1].split("&")[0].split("=")[0];
                        var parameterValue = (window.location.href.split("?")[1].split("&")[0].split("=")[1] == undefined) ? "" : window.location.href.split("?")[1].split("&")[0].split("=")[1].replace("%20", " ");
                        $.each(pictureTypes["data"], function(key, value){
                            if(value["Type_Name"].toLowerCase().localeCompare(parameterValue.toLowerCase()) === 0){
                                $("#gallerytype" + value["Type_ID"]).prop("checked", true);
                            }
                        });
                    }
                    parseImages($("#gallerycontainer"), true);
                });
            });
            
            $(window).scroll(function(){
                var top_position = $(window).scrollTop();
                var top_location = $("#gallerycontainer").position().top + $("#gallerycontainer").height() - $(window).height();
                if(top_position > top_location){
                    parseImages($("#gallerycontainer"), false);
                }
            });

        }
        else if($("html").attr("self").toString().localeCompare("messages")===0){
            requestMessages.then(function(data){
                parseMessages($("#messagecontainer"));
            });
        }
    }

    $("#loginButton").bind("click", function(){
        var username_check = false;
        var password_check = false;

        var usernameFormat = /^[0-9a-zA-Z_.-]+$/;
        var emailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var usernameValue = $("#loginUsername").val();

        var passwordFormat = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[ !@#$.,%^&*])[a-zA-Z0-9 !@#$.,%^&*]{8,30}$/;
        var passwordValue = $("#loginPassword").val();

        $("#loginsubmitHelp").text("");
        $("#loginsubmitHelp").removeClass("color-custom3");
        $("#loginsubmitHelp").addClass("color-custom5");

        if(usernameFormat.test(usernameValue) || emailFormat.test(usernameValue)){
            $("#loginUsername").removeClass("incorrect_field");
            $("#loginUsername").addClass("correct_field");
            $("#usernameHelp").text("");
            username_check = true;
        }
        else {
            $("#loginUsername").removeClass("correct_field");
            $("#loginUsername").addClass("incorrect_field");
            $("#usernameHelp").text("Korisničko ime može sadržati samo slova a-z, A-Z, specijalne karaktere _ . - i brojeve 0-9.");
            username_check = false;
        }

        if(passwordFormat.test(passwordValue)){
            $("#loginPassword").removeClass("incorrect_field");
            $("#loginPassword").addClass("correct_field");
            $("#passwordHelp").text("");
            password_check = true;
        }
        else {
            $("#loginPassword").removeClass("correct_field");
            $("#loginPassword").addClass("incorrect_field");
            $("#passwordHelp").text("Šifra može sadržati samo karaktere a-z, A-Z, specijalne karaktere !@#$.,%^&*, prazna mesta i brojeve 0-9 i mora imati makar jedno veliko, jedno malo slovo, jedan broj i jedan specijalni karakter i mora biti dužine od 8 do 30 karaktera.");
            password_check = false;
        }

        if(username_check && password_check){
            $(function(){
                $.ajax({
                url: "PhpScripts/RequestProcessing.php",
                method: "post",
                cache: false,
                data:{username:usernameValue, password:passwordValue},
                dataType: "json",
                    success: function(data){
                        if(data["type"].localeCompare("success")===0){
                            $("#loginsubmitHelp").removeClass("color-custom5");
                            $("#loginsubmitHelp").addClass("color-custom3");
                            $("#loginsubmitHelp").text("Uspešno ste se prijavili. Dobrodošli " + data["data"]["User_First_Name"] + " " + data["data"]["User_Last_Name"] + ". Bićete preusmereni u narednih par trenutaka.");
                            $("#loginUsername").removeClass("incorrect_field");
                            $("#loginUsername").removeClass("correct_field");
                            $("#usernameHelp").text("");

                            $("#loginPassword").removeClass("incorrect_field");
                            $("#loginPassword").removeClass("correct_field");
                            $("#passwordHelp").text("");

                            setTimeout(function(){
                                window.location = locationTeleport;
                            }, 2000);
                        }
                        else if(data["type"].localeCompare("errornotfound")===0){
                            $("#loginsubmitHelp").text("Uneto korisničko ime i/ili šifra ne postoje u sistemu. Pokušajte ponovo kasnije.");
                        }
                        else{
                            $("#loginsubmitHelp").text("Nepoznata greška. Pokušajte ponovo kasnije.");
                        }
                    }
                });
            }); 
        }
    });

    $("#picturecategorysubmit").bind("click", function(){
        $("#picturecategoryHelp").addClass("color-custom5");
        var picturecategoryValue = $("#picturecategoryinput1").val().trim();
        var picturecategoryFormat = /^.{1,30}$/;
        if(picturecategoryFormat.test(picturecategoryValue))
        {
            $("#picturecategoryinput1").removeClass("incorrect_field");
            $("#picturecategoryinput1").addClass("correct_field");
            $("#picturecategoryHelp").text("");
            $(function(){
                $.ajax({
                url: "PhpScripts/RequestProcessing.php",
                method: "post",
                cache: false,
                data:{picturecategory:picturecategoryValue},
                dataType: "json",
                    success: function(data){
                        if(data["type"].localeCompare("success")===0){
                            $("#picturecategoryinput1").val("");
                            $("#picturecategoryHelp").text("");
                            $("#picturecategoryinput1").removeClass("correct_field");
                            $("#picturecategoryinput1").removeClass("incorrect_field");
                            $("#picturecategoryHelp").removeClass("color-custom5");
                            $("#picturecategoryHelp").text("Picture category successful stored!");
                            requestTypes = getImageTypes();
                            requestTypes.then(function(data){
                                parseImageTypes($("#imagegallerytype"), $("#picturetypescontainer"));
                                parseImageTypes($("#gallerytyperemove"));
                            });
                        }
                        else{
                            $("#picturecategoryHelp").text("Kategorija slike nije validna. Mora imati od 1 do 30 karaktera.");
                            $("#picturecategoryinput1").removeClass("correct_field");
                            $("#picturecategoryinput1").addClass("incorrect_field");
                        }
                    }
                });
            });
        }
        else{
            $("#picturecategoryHelp").text("Kategorija slike nije validna. Mora imati od 1 do 30 karaktera.");
            $("#picturecategoryinput1").removeClass("correct_field");
            $("#picturecategoryinput1").addClass("incorrect_field");
        }
    });



    $("#picturecategoryremove").bind("click", function(){
        $("#imagetyperemoveHelp").addClass("color-custom5");
        var removetypecheck = false;
        var removeallcheck = false;

        var picturegalleryTypeValue = $("#gallerytyperemove").find(":selected").val().trim();
        var picturegalleryTypeText = $("#gallerytyperemove").find(":selected").text().trim();
        if(Math.floor(picturegalleryTypeValue) == picturegalleryTypeValue && $.isNumeric(picturegalleryTypeValue) && picturegalleryTypeValue != (-1) && checkIfExist(pictureTypes["data"], picturegalleryTypeValue.toString(), picturegalleryTypeText)){
            $("#gallerytyperemove").removeClass("incorrect_field");
            $("#gallerytyperemove").addClass("correct_field");
            $("#imagetyperemoveHelp").text("");
            removetypecheck = true;
        }
        else {
            $("#gallerytyperemove").removeClass("correct_field");
            $("#gallerytyperemove").addClass("incorrect_field");
            $("#imagetyperemoveHelp").text("Izabrana kategorija slike nije validna. Proverite ponovo.");
            removetypecheck = false;
        }
        var typeRemoveAllValue = $("#imagegalleryallremovetype").prop("checked");
        if(typeof typeRemoveAllValue == "boolean"){
            $("label[for='imagegalleryallremovetype']").removeClass("color-custom5");
            removeallcheck = true;
        }
        else{
            $("label[for='imagegalleryallremovetype']").addClass("color-custom5");
            removeallcheck = false;
        }

        if(removetypecheck && removeallcheck)
        {
            $(function(){
                $.ajax({
                url: "PhpScripts/RequestProcessing.php",
                method: "post",
                cache: false,
                data:{typeforremove:picturegalleryTypeValue, typeremoveall:typeRemoveAllValue},
                dataType: "json",
                    success: function(data){
                        if(data["type"].localeCompare("success")===0){
                            $("#gallerytyperemove option:selected").prop("selected", false);
                            $("#gallerytyperemove option[value='-1']").prop("selected", true);

                            $("#gallerytyperemove").removeClass("correct_field");
                            $("#gallerytyperemove").removeClass("incorrect_field");

                            $("#imagegalleryallremovetype").prop("checked", false);
                            $("label[for='imagegalleryallremovetype']").removeClass("color-custom5");

                            $("#imagetyperemoveHelp").removeClass("color-custom5");
                            $("#imagetyperemoveHelp").text(data["message"]);
                            requestTypes = getImageTypes();
                            requestPictures = getImages();
                            requestTypes.then(function(data){
                                parseImageTypes($("#imagegallerytype"), $("#picturetypescontainer"));
                                parseImageTypes($("#gallerytyperemove"));
                            }).then(function(data){
                                requestPictures.then(function(data){
                                    parseImages($("#gallerycontainer"), true);
                                });
                            });
                        }
                        else if(data["type"].localeCompare("errorSQL")===0){
                            $("#imagetyperemoveHelp").text(data["message"]);
                            $("#gallerytyperemove").removeClass("correct_field");
                            $("#gallerytyperemove").addClass("incorrect_field");
                        }
                        else{
                            $("#imagetyperemoveHelp").text("Nepoznata greška. Pokušajte ponovo kasnije.");
                        }
                    }
                });
            });
        }
    });



    $("#imagegallerysubmit").bind("click", function(){
        var picturefilecheck = false;
        var picturetypecheck = false;
        var pictureheadercheck = false;
        var picturebodycheck = false;
        var picturedisplaycheck = false;

        var picturegalleryTypeValue = $("#imagegallerytype").find(":selected").val().trim();
        var picturegalleryTypeText = $("#imagegallerytype").find(":selected").text().trim();
        var picturegalleryTypeFormat = /^.{1,30}$/;
        if(picturegalleryTypeValue == (-1) ^ (picturegalleryTypeFormat.test(picturegalleryTypeText) && Math.floor(picturegalleryTypeValue) == picturegalleryTypeValue && $.isNumeric(picturegalleryTypeValue) && picturegalleryTypeValue != (-1) && checkIfExist(pictureTypes["data"], picturegalleryTypeValue.toString(), picturegalleryTypeText))){
            picturegalleryTypeValue = (picturegalleryTypeValue == (-1)) ? 'NULL' : picturegalleryTypeValue;
            $("#imagegallerytype").removeClass("incorrect_field");
            $("#imagegallerytype").addClass("correct_field");
            $("#imagetypeHelp").text("");
            picturetypecheck = true;
        }
        else {
            $("#imagegallerytype").removeClass("correct_field");
            $("#imagegallerytype").addClass("incorrect_field");
            $("#imagetypeHelp").text("Izabrana kategorija slike nije validna. Proverite ponovo.");
            picturetypecheck = false;
        }

        var picturegalleryHeaderValue = $("#imagegalleryheader").val().trim();
        var picturegalleryHeaderFormat = /^.{0,50}$/;
        if(picturegalleryHeaderFormat.test(picturegalleryHeaderValue)) {
            $("#imagegalleryheader").removeClass("incorrect_field");
            $("#imagegalleryheader").addClass("correct_field");
            $("#imageheaderHelp").text("");
            pictureheadercheck = true;
        }
        else {
            $("#imagegalleryheader").removeClass("correct_field");
            $("#imagegalleryheader").addClass("incorrect_field");
            $("#imageheaderHelp").text("Naslov slike nije validan. Mora biti do 50 karaktera dužine.");
            pictureheadercheck = false;
        }

        var picturegalleryBodyValue = $("#imagegallerybody").val().trim();
        var picturegalleryBodyFormat = /^.{0,200}$/;
        if(picturegalleryBodyFormat.test(picturegalleryBodyValue)) {
            $("#imagegallerybody").removeClass("incorrect_field");
            $("#imagegallerybody").addClass("correct_field");
            $("#imagebodyHelp").text("");
            picturebodycheck = true;
        }
        else {
            $("#imagegallerybody").removeClass("correct_field");
            $("#imagegallerybody").addClass("incorrect_field");
            $("#imagebodyHelp").text("Tekst slike nije validan. Mora biti do 200 karaktera dužine.");
            picturebodycheck = false;
        }

        var picturegalleryDisplayValue = $("#imagegalleryshowtext").prop("checked");
        if(typeof picturegalleryDisplayValue == "boolean"){
            $("label[for='imagegalleryshowtext']").removeClass("color-custom5");
            picturedisplaycheck = true;
        }
        else{
            $("label[for='imagegalleryshowtext']").addClass("color-custom5");
            picturedisplaycheck = false;
        }
        
        if(galleryPicture != null){
            if(imageTypes.includes(galleryPicture["type"]) && galleryPicture["size"] <= byteSize){
                
                $("label[for='imagegallerypicture']").removeClass("incorrect_field");
                $("label[for='imagegallerypicture']").addClass("correct_field");
                $("#imagefileHelp").text("");
                picturefilecheck = true;
            }
            else{
                if(!imageTypes.includes(galleryPicture["type"])){
                    $("label[for='imagegallerypicture']").removeClass("correct_field");
                    $("label[for='imagegallerypicture']").addClass("incorrect_field");
                    $("#imagefileHelp").text("Izabrana slika nije ispravnog tipa.");
                }
                if(!(galleryPicture["size"] <= byteSize)){
                    $("label[for='imagegallerypicture']").removeClass("correct_field");
                    $("label[for='imagegallerypicture']").addClass("incorrect_field");
                    $("#imagefileHelp").text($("#imagefileHelp").text() + " Slika mora biti veličine do 50MB.");
                }
                $("#imagefileHelp").text($("#imagefileHelp").text() + " Proverite ponovo.");
                picturefilecheck = false;
            }
        }
        else{
            $("label[for='imagegallerypicture']").removeClass("correct_field");
            $("label[for='imagegallerypicture']").addClass("incorrect_field");
            $("#imagefileHelp").text("Please select image to continue!");
            picturefilecheck = false;
        }
        
        if(picturefilecheck && picturetypecheck && pictureheadercheck && picturebodycheck && picturedisplaycheck){
            var submitForm = new FormData();
            submitForm.append("pictureFileValue", galleryPicture);
            submitForm.append("pictureTypeValue", picturegalleryTypeValue);
            submitForm.append("pictureHeaderValue", picturegalleryHeaderValue);
            submitForm.append("pictureBodyValue", picturegalleryBodyValue);
            submitForm.append("pictureDisplayValue", picturegalleryDisplayValue);
            $("#imagesubmitHelp").addClass("color-custom5");
            $(function(){
                $.ajax({
                url: "PhpScripts/RequestProcessing.php",
                method: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: submitForm,
                    success: function(data){
                        var parsedData = JSON.parse(data);
                        if(parsedData["type"].localeCompare("success")===0){
                            $("#imagegallerytype option:selected").prop("selected", false);
                            $("#imagegallerytype option[value='-1']").prop("selected", true);

                            $("#imagegallerypicture").val("");
                            $("label[for='imagegallerypicture']").removeClass("correct_field");
                            $("label[for='imagegallerypicture']").removeClass("incorrect_field");
                            $("#imagefileHelp").text("");

                            $("#imagegallerytype").removeClass("correct_field");
                            $("#imagegallerytype").removeClass("incorrect_field");
                            $("#imagetypeHelp").text("");

                            $("#imagegalleryheader").val("");
                            $("#imagegalleryheader").removeClass("correct_field");
                            $("#imagegalleryheader").removeClass("incorrect_field");
                            $("#imageheaderHelp").text("");

                            $("#imagegallerybody").val("");
                            $("#imagegallerybody").removeClass("correct_field");
                            $("#imagegallerybody").removeClass("incorrect_field");
                            $("#imagebodyHelp").text("");

                            $("#imagegalleryshowtext").prop("checked", false);
                            $("label[for='imagegalleryshowtext']").removeClass("color-custom5");

                            $("#imagesubmitHelp").removeClass("color-custom5");
                            $("#imagesubmitHelp").text(parsedData["message"]);
                            $("#inputimagepreview").css("background-image", "url('Media/Images/PlusIconPNG.png')");
                            galleryPicture = null;
                            requestPictures = getImages();
                            requestPictures.then(function(data){
                                parseImages($("#gallerycontainer"), true);
                            });
                        }
                        else if(parsedData["type"].localeCompare("errorSQL")===0){
                            $("#imagesubmitHelp").text(parsedData["message"]);
                        }
                        else if(parsedData["type"].localeCompare("error")===0){
                            $("label[for='imagegallerypicture']").removeClass("correct_field");
                            $("label[for='imagegallerypicture']").addClass("incorrect_field");
                            $("#imagefileHelp").text(parsedData["message"]);
                            $("#inputimagepreview").css("background-image", "url('Media/Images/PlusIconPNG.png')");
                            galleryPicture = null;
                        }
                        else{
                            $("#imagesubmitHelp").text("Nepoznata greška. Pokušajte ponovo kasnije.");
                        }
                    }
                });
            });
        }
    });



    $("#messagesubmit").bind("click", function(){
        var contactfirstnamecheck = false;
        var contactlastnamecheck = false;
        var contactemailcheck = false;
        var contactmessagecheck = false;

        var firstnameFormat = /^.{0,20}$/;
        var firstnameValue = $("#contactfirstname").val().trim();

        var lastnameFormat = /^.{0,30}$/;
        var lastnameValue = $("#contactlastname").val().trim();

        var emailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/;
        var emailValue = $("#contactemail").val().trim();

        var messageFormat = /^.{1,300}$/;
        var messageValue = $("#contactmessagetext").val().trim();

        if(firstnameFormat.test(firstnameValue)) {
            $("#contactfirstname").removeClass("incorrect_field");
            $("#contactfirstname").addClass("correct_field");
            $("#firstnameHelp").text("");
            contactfirstnamecheck = true;
        }
        else {
            $("#contactfirstname").removeClass("correct_field");
            $("#contactfirstname").addClass("incorrect_field");
            $("#firstnameHelp").text("Ime mora biti do 20 karaktera dužine.");
            contactfirstnamecheck = false;
        }

        if(lastnameFormat.test(lastnameValue)) {
            $("#contactlastname").removeClass("incorrect_field");
            $("#contactlastname").addClass("correct_field");
            $("#lastnameHelp").text("");
            contactlastnamecheck = true;
        }
        else {
            $("#contactlastname").removeClass("correct_field");
            $("#contactlastname").addClass("incorrect_field");
            $("#lastnameHelp").text("Prezime mora biti do 30 karaktera dužine.");
            contactlastnamecheck = false;
        }

        if(emailFormat.test(emailValue)) {
            $("#contactemail").removeClass("incorrect_field");
            $("#contactemail").addClass("correct_field");
            $("#emailHelp").removeClass("color-custom5");
            $("#emailHelp").addClass("color-custom3");
            $("#emailHelp").text("Vaši podaci neće biti deljeni nigde.");
            contactemailcheck = true;
        }
        else {
            $("#contactemail").removeClass("correct_field");
            $("#contactemail").addClass("incorrect_field");
            $("#emailHelp").removeClass("color-custom3");
            $("#emailHelp").addClass("color-custom5");
            if(emailValue != ""){
                $("#emailHelp").text("Unet email je neispravan.");
            }
            else{
                $("#emailHelp").text("Unesite ispravan email.");
            }
            contactemailcheck = false;
        }

        if(messageFormat.test(messageValue)) {
            $("#contactmessagetext").removeClass("incorrect_field");
            $("#contactmessagetext").addClass("correct_field");
            $("#messagehelp").text("");
            contactmessagecheck = true;
        }
        else {
            $("#contactmessagetext").removeClass("correct_field");
            $("#contactmessagetext").addClass("incorrect_field");
            $("#messagehelp").text("Tekst poruke mora biti od 1 do 200 karaktera dužine.");
            contactmessagecheck = false;
        }

        if(contactfirstnamecheck && contactlastnamecheck && contactemailcheck && contactmessagecheck){
            $(function(){
                $.ajax({
                url: "PhpScripts/RequestProcessing.php",
                method: "post",
                cache: false,
                data:{contactfirstname:firstnameValue, contactlastname:lastnameValue, contactemail:emailValue, contactmessage:messageValue},
                dataType: "json",
                    success: function(data){
                        if(data["type"].localeCompare("success")===0){
                            $("#contactfirstname").removeClass("incorrect_field");
                            $("#contactfirstname").removeClass("correct_field");
                            $("#contactfirstname").val("");
                            $("#firstnameHelp").text("");

                            $("#contactlastname").removeClass("incorrect_field");
                            $("#contactlastname").removeClass("correct_field");
                            $("#contactlastname").val("");
                            $("#lastnameHelp").text("");

                            $("#contactemail").removeClass("incorrect_field");
                            $("#contactemail").removeClass("correct_field");
                            $("#contactemail").val("");
                            $("#emailHelp").removeClass("color-custom5");
                            $("#emailHelp").addClass("color-custom3");
                            $("#emailHelp").text("Vaši podaci neće biti deljeni nigde.");

                            $("#contactmessagetext").removeClass("incorrect_field");
                            $("#contactmessagetext").removeClass("correct_field");
                            $("#contactmessagetext").val("");
                            $("#messagehelp").text("");
                            $("#contactsubmitHelp").removeClass("color-custom5");
                            $("#contactsubmitHelp").addClass("color-custom3");
                            $("#contactsubmitHelp").text(data["message"]);
                        }
                        else if(data["type"].localeCompare("errorSQL")===0){
                            $("#contactsubmitHelp").removeClass("color-custom3");
                            $("#contactsubmitHelp").addClass("color-custom5");
                            $("#contactsubmitHelp").text(data["message"]);
                        }
                        else{
                            $("#contactsubmitHelp").removeClass("color-custom3");
                            $("#contactsubmitHelp").addClass("color-custom5");
                            $("#contactsubmitHelp").text("Nepoznata greška. Pokušajte ponovo kasnije.");
                        }
                    }
                });
            }); 
        }
    });


    $("#removeallmessages").bind("click", function(){
        $(".messagesremove").each(function(){
            $(this).triggerHandler("removeallmesstrigger");
        });
    });


    $("#imagesupdateall").bind("click", function(){
        $(".imagesselectaction").each(function(){
            $(this).triggerHandler("updatealltrigger");
        });
    });
    $("#imagesdeleteall").bind("click", function(){
        $(".imagesselectaction").each(function(){
            $(this).triggerHandler("removealltrigger");
        });
    });


    $("#imagegallerypicture").on("change", function(event){
        if(event.target.files.length > 0 && event.target.files[0] != ""){
            if(imageTypes.includes(event.target.files[0]["type"])){
                $("#inputimagepreview").css("background-image", "url('" + URL.createObjectURL(event.target.files[0]) + "')");
            }
            else{
                $("#inputimagepreview").css("background-image", "url('Media/Images/PlusIconPNG.png')");
            }
            galleryPicture = event.target.files[0];
        }
    });



    $("#arrow1").bind("click", function(){
        $("html, body").animate({ scrollTop: parseFloat($("#scrollContent1").position().top) + "px" });
    });

  //  var hover = false;
    $("a[for='submenu01']").bind("mouseenter", function(){
        $("#submenu01").css("display", "block");
    });
    $("#submenu01").bind("mouseenter", function(){
        $("#submenu01").css("display", "block");
    });
    $("#submenu01").bind("mouseleave", function(){
        $("#submenu01").css("display", "none");
    });


});

function changeCardPicture(object, value){
    if(object.prop("files").length > 0 && object.prop("files")[0] != ""){
        let image = new Image();
        image.src = URL.createObjectURL(object.prop("files")[0]);
        $("#gallerypictureimageurl" + value).data("imagefile", object.prop("files")[0]);
        image.onload = function(){
            object.siblings(".filelabel").children("img").attr("src", image.src);
            object.siblings(".filelabel").children("img").attr("url", image.src);
            object.siblings(".filelabel").children("div").css("background-image", "url('" + image.src + "')");
            object.siblings(".filelabel").children("img").bind("revokeImagePreview", function(event){revokeImagePreview(image.src);});
        };
    }
}

function cropImagePreview(object){
    let canvas = document.createElement("canvas");
    let iw, ih, sx, sy;
    if(object.naturalWidth*9/16 > object.naturalHeight){
        iw = object.naturalHeight*16/9;
        ih = object.naturalHeight;
        sx = (object.naturalWidth - iw)/2;
        sy = 0;
    } else{
        iw = object.naturalWidth;
        ih = object.naturalWidth*9/16;
        sx = 0;
        sy = (object.naturalHeight - ih)/2;
    }
    canvas.width = iw;
    canvas.height = ih;
    canvas.getContext("2d").drawImage(object, sx, sy, iw, ih, 0, 0, iw, ih);
    return canvas.toDataURL();
}

function revokeImagePreview(object){
    URL.revokeObjectURL(object);
}

function getImageTypes(){
    return new Promise(function(resolve, reject) {
        $(function(){
            $.ajax({
            url: "PhpScripts/RequestProcessing.php",
            method: "post",
            data:{pictureTypeRequest:"true"},
            cache: false,
            dataType: "json",
                success: function(data){
                    pictureTypes = data;
                    resolve(pictureTypes);
                }
            });
        });
    });
}

function getImages(){
    return new Promise(function(resolve, reject) {
        $(function(){
            $.ajax({
            url: "PhpScripts/RequestProcessing.php",
            method: "post",
            cache: false,
            data:{readPicturesRequest:"true"},
            dataType: "json",
                success: function(data){
                    pictures = data;
                    resolve(pictures);
                }
            });
        });
    });
}

function getMessages(){
    return new Promise(function(resolve, reject) {
        $(function(){
            $.ajax({
            url: "PhpScripts/RequestProcessing.php",
            method: "post",
            cache: false,
            data:{readMessagesRequest:"true"},
            dataType: "json",
                success: function(data){
                    messages = data;
                    resolve(messages);
                }
            });
        });
    });
}

function parseImageTypes(object, block){
    if(block == undefined){
        object.html("<option selected value='-1'>Picture category</option>");
        $.each(pictureTypes["data"], function(key, value){
            object.html(object.html() + "<option value='" + value["Type_ID"] + "'>" + value["Type_Name"] + "</option>");
        });
    }
    else{
        if($("html").attr("self").toString().localeCompare("gallery")===0){
            object.html("<option selected value='-1'>Picture category</option>");
            block.html("");
            $.each(pictureTypes["data"], function(key, value){
                object.html(object.html() + "<option value='" + value["Type_ID"] + "'>" + value["Type_Name"] + "</option>");
                block.html(block.html() + `<div class="checkbox col-6 col-md-3 col-lg-3">
                <input type="checkbox" id="gallerytype` + value["Type_ID"] + `" onchange='parseImages($("#gallerycontainer"), true);'/>  
                <label class="box2" for="gallerytype` + value["Type_ID"] + `">
                <p data-text="` + value["Type_Name"] + `">` + value["Type_Name"] + `</p>  
                </label>
            </div>`);
            });
        }
        else if($("html").attr("self").toString().localeCompare("updategallery")===0){
            object.html("<option selected value='-1'>Picture category</option>");
            block.html("");
            $.each(pictureTypes["data"], function(key, value){
                object.html(object.html() + "<option value='" + value["Type_ID"] + "'>" + value["Type_Name"] + "</option>");
                block.html(block.html() + `<div class="checkbox col-6 col-md-3 col-lg-3">
                <input type="checkbox" id="gallerytype` + value["Type_ID"] + `" onchange='parseImages($("#gallerycontainer"), true);'/>  
                <label class="box2" for="gallerytype` + value["Type_ID"] + `">
                <p data-text="` + value["Type_Name"] + `">` + value["Type_Name"] + `</p>  
                </label>
            </div>`);
            });
        }
    }
}

var numberofimages = 0;
function parseImages(object, clear){
    var checked = false;
    if(clear){
        numberofimages = 0;
        object.html("");
    }
    var checked_types = [];
    var selected_images = [];
    $.each(pictureTypes["data"], function(key, value){
        if($("#gallerytype" + value["Type_ID"]).prop("checked")){
            checked = true; 
            checked_types.push(value["Type_ID"]);
        }
    });
    var limit = (numberofimages + 12 > pictures["data"].length)?pictures["data"].length:numberofimages + 12;
    var data = [];
    if(checked){
        var ord = 0;
        $.each(pictures["data"], function(key, value){
            if(checked_types.includes(value["Picture_Type_Category"])){
                data.push(value);
            }
        });
    }
    else{
        data = pictures["data"];
    }
    if($("html").attr("self").toString().localeCompare("gallery")===0){
        $.each(data.slice(numberofimages, limit), function(key, value){
            if($("#gallerytype" + value["Picture_Type_Category"]).prop("checked") || !checked){
                var contentHtml = object.html();
                contentHtml += `<div class="col-6 col-md-4 col-lg-3">
                    <div class="card border-0 transform-on-hover">
                    <a class="lightbox" href="` + value["Picture_URL"] + `">
                        <img src="` + value["Picture_URL"] + `" alt="Card Image ` + value["Picture_ID"] + `" class="card-img-top" style="display: none;"/>
                        <div id="gallerypicturediv` + value["Picture_ID"] + `" style="width: 100%; height: 155px; background-color: #42424211; background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url('` + value["Picture_URL"] + `');"></div>
                    </a>`;
                if(value["Display_Body"] != 1){
                    contentHtml += `<div class="card-body">
                        <h6>` + value["Picture_Header"] + `</h6>
                        <p class="text-muted card-text">` + value["Picture_Body"] + `</p>
                    </div>`;
                }
                object.html(contentHtml + `</div></div>`);
                numberofimages++;
            }
        });
    }
    if($("html").attr("self").toString().localeCompare("updategallery")===0){
        var picturetypeselectioncontent = "<option selected value='-1'>Picture category</option>";
        $.each(pictureTypes["data"], function(key, value){
            picturetypeselectioncontent = picturetypeselectioncontent + "<option value='" + value["Type_ID"] + "'>" + value["Type_Name"] + "</option>";
        });
        $.each(data.slice(numberofimages, limit), function(key, value){
            if($("#gallerytype" + value["Picture_Type_Category"]).prop("checked") || !checked){
                object.html(object.html() + `<div class="col-6 col-md-4 col-lg-3" id="gallerypicturecol` + value["Picture_ID"] + `">
                <div class="card border-0 transform-on-hover" style="position: relative;">
                <span class="lightbox">
                    <input type="file" accept="image/png, image/gif, image/jpeg, image/jpg" id="imagegallery` + value["Picture_ID"] + `" style="display: none;" onchange="changeCardPicture($(this), ` + value["Picture_ID"] + `);"/>
                    <label class="filelabel" style="width: 100%; height: 100%; margin: 0; padding: 0; float: left;" for="imagegallery` + value["Picture_ID"] + `">
                    <img src="` + value["Picture_URL"] + `" url="` + value["Picture_URL"] + `" id="gallerypictureimageurl` + value["Picture_ID"] + `" style="display: none;"/>
                    <div id="gallerypicturediv` + value["Picture_ID"] + `" style="width: 100%; height: 160px; background-color: #42424211; background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url('` + value["Picture_URL"] + `');"></div>
                    </label>
                </span>
                <input type="checkbox" class="imagesselectaction" id="picturecheck` + value["Picture_ID"] + `" style="width:1.5rem; height:1.5rem; position: absolute; top: 1rem; left: 1rem;"/> 
                <div class="card-body">
                    <h6><input id="picturecardheader` + value["Picture_ID"] + `" class="form-control rounded-pill" type="text" value="` + value["Picture_Header"] + `" style="width: 100%;" placeholder="Image header"/></h6>
                    <p class="text-muted card-text"><textarea id="picturecardbody` + value["Picture_ID"] + `" class="form-control rounded" rows="3" placeholder="Image body" style="resize: none; width: 100%;">` + value["Picture_Body"] + `</textarea></p>
                    <select id="picturetypeselect` + value["Picture_ID"] + `" class="form-select form-control rounded" aria-label="Picture category" style="width: 100%;">
                    ` + picturetypeselectioncontent + `
                    </select>
                    <div class="form-row mt-4">
                        <div class="col-3 my-auto mr-1">
                            <input type="checkbox" id="gallerypictureshowcheck` + value["Picture_ID"] + `" style="width:1.5rem; height:1.5rem;">
                        </div>
                        <div class="col-8 ml-1">
                            <label class="mr-2" style="cursor: pointer; text-align: left; font-size: 0.9rem;" for="gallerypictureshowcheck` + value["Picture_ID"] + `">Don't show image header and image body</label>
                        </div>
                    </div>
                    <small id="imagesubmitHelp` + value["Picture_ID"] + `" class="form-text text-muted color-custom5"></small>
                    <button type="button" class="btn custom-btn1 rounded-pill w-100 mt-4" onclick="setImages(` + value["Picture_ID"] + `);">Update</button>
                    <button type="button" class="btn custom-btn1 rounded-pill w-100 mt-2" onclick="removeImages(` + value["Picture_ID"] + `);">Delete</button>
                    </div>
                </div></div>`);
                $("#picturetypeselect" + value["Picture_ID"] + " option[value='" + value["Picture_Type_Category"] + "']").attr("selected", true);
                
                $("#picturecheck" + value["Picture_ID"]).ready(function(){
                    $("#picturecheck" + value["Picture_ID"]).bind("updatealltrigger", function(event){updatealltrigger($("#picturecheck" + value["Picture_ID"]), value["Picture_ID"]);});
                    $("#picturecheck" + value["Picture_ID"]).bind("removealltrigger", function(event){removealltrigger($("#picturecheck" + value["Picture_ID"]), value["Picture_ID"]);});
                });
                if(value["Display_Body"] == 1){
                    $("#gallerypictureshowcheck" + value["Picture_ID"]).attr("checked", true);
                }
                else{
                    $("#gallerypictureshowcheck" + value["Picture_ID"]).attr("checked", false);
                }
                numberofimages++;
            }
        });
    }
    baguetteBox.run('.cards-gallery', { animation: 'slideIn'});
}


function parseMessages(object){
    object.html("");
    $.each(messages["data"], function(key, value){
        object.html(object.html() + `<div class="form-row my-4 p-2 rounded-lg bg-custom3 color-custom6" id="messagerow` + value["Message_ID"] + `" style="border: 2px solid #9c9c9cb7;">
        <div class="col-1" style="display: flex; flex-flow: row wrap; justify-content: center;">
          <input class="my-auto messagesremove" type="checkbox" id="messageremove` + value["Message_ID"] + `" style="width:1.5rem; height:1.5rem;"/>
        </div>
        <div class="col px-4" style="border-left: 2px solid #9c9c9cb7;">
          <h5>First name: ` + value["User_First_Name"] + `</h5>
          <h5>Last name: ` + value["User_Last_Name"] + `</h5>
          <h5>Email: ` + value["User_Email"] + `</h5>
          <h5>Date: ` + value["Message_Sending_Date"] + `</h5>
        </div>
        <div class="col pl-4" style="border-left: 2px solid #9c9c9cb7;">
          <h6>Message: ` + value["Message_Text"] + `</h6>
        </div>
        </div>`);
        $("#messageremove" + value["Message_ID"]).ready(function(){
            $("#messageremove" + value["Message_ID"]).bind("removeallmesstrigger", function(event){removeallmesstrigger($("#messageremove" + value["Message_ID"]), value["Message_ID"]);});
        });
    });
}


function checkIfExist(array, value, object){
    var check = false;
    $.each(array, function(key, val){
        if(val["Type_ID"] == value && val["Type_Name"] == object){
            check = true;
            return false;
        }
    });
    return check;
}


function removeImages(object){
    if(Math.floor(object) == object && $.isNumeric(object)){
        object = object.toString().trim();
        $(function(){
            $.ajax({
            url: "PhpScripts/RequestProcessing.php",
            method: "post",
            cache: false,
            data:{removePicturesRequest:object},
            dataType: "json",
                success: function(data){
                    if(data["type"].localeCompare("success")===0){
                        $("#gallerypicturecol" + object).remove();
                    }
                }
            });
        });
    }
}


function removeMessages(object){
    if(Math.floor(object) == object && $.isNumeric(object)){
        object = object.toString().trim();
        $(function(){
            $.ajax({
            url: "PhpScripts/RequestProcessing.php",
            method: "post",
            cache: false,
            data:{removeMessagesRequest:object},
            dataType: "json",
                success: function(data){
                    if(data["type"].localeCompare("success")===0){
                        //console.log("#messagerow" + object);
                        $("#messagerow" + object).remove();
                    }
                }
            });
        });
    }
}


function setImages(object){
    if(Math.floor(object) == object && $.isNumeric(object)){
        object = object.toString().trim();

        var picturefilecheck = false;
        var picturetypecheck = false;
        var pictureheadercheck = false;
        var picturebodycheck = false;
        var picturedisplaycheck = false;

        var picturegalleryTypeValue = $("#picturetypeselect" + object).find(":selected").val().trim();
        var picturegalleryTypeText = $("#picturetypeselect" + object).find(":selected").text().trim();
        var picturegalleryTypeFormat = /^.{1,30}$/;
        if(picturegalleryTypeValue == (-1) ^ (picturegalleryTypeFormat.test(picturegalleryTypeText) && Math.floor(picturegalleryTypeValue) == picturegalleryTypeValue && $.isNumeric(picturegalleryTypeValue) && picturegalleryTypeValue != (-1) && checkIfExist(pictureTypes["data"], picturegalleryTypeValue.toString(), picturegalleryTypeText))) {
            picturegalleryTypeValue = (picturegalleryTypeValue == (-1)) ? 'NULL' : picturegalleryTypeValue;
            $("#picturetypeselect" + object).removeClass("incorrect_field");
            $("#picturetypeselect" + object).addClass("correct_field");
            picturetypecheck = true;
        }
        else {
            $("#picturetypeselect" + object).removeClass("correct_field");
            $("#picturetypeselect" + object).addClass("incorrect_field");
            picturetypecheck = false;
        }

        var picturegalleryHeaderValue = $("#picturecardheader" + object).val().trim();
        var picturegalleryHeaderFormat = /^.{0,50}$/;
        if(picturegalleryHeaderFormat.test(picturegalleryHeaderValue)) {
            $("#picturecardheader" + object).removeClass("incorrect_field");
            $("#picturecardheader" + object).addClass("correct_field");
            pictureheadercheck = true;
        }
        else {
            $("#picturecardheader" + object).removeClass("correct_field");
            $("#picturecardheader" + object).addClass("incorrect_field");
            pictureheadercheck = false;
        }

        var picturegalleryBodyValue = $("#picturecardbody" + object).val().trim();
        var picturegalleryBodyFormat = /^.{0,200}$/;
        if(picturegalleryBodyFormat.test(picturegalleryBodyValue)) {
            $("#picturecardbody" + object).removeClass("incorrect_field");
            $("#picturecardbody" + object).addClass("correct_field");
            picturebodycheck = true;
        }
        else {
            $("#picturecardbody" + object).removeClass("correct_field");
            $("#picturecardbody" + object).addClass("incorrect_field");
            picturebodycheck = false;
        }

        var picturegalleryDisplayValue = $("#gallerypictureshowcheck" + object).prop("checked");
        if(typeof picturegalleryDisplayValue == "boolean"){
            $("label[for='gallerypictureshowcheck" + object + "']").removeClass("color-custom5");
            picturedisplaycheck = true;
        }
        else{
            $("label[for='gallerypictureshowcheck" + object + "']").addClass("color-custom5");
            picturedisplaycheck = false;
        }
        
        let image = $("#gallerypictureimageurl" + object).data("imagefile");
        var edited = true;

        if(image == undefined ^ (image != null && imageTypes.includes(image["type"]) && image["size"] <= byteSize)){
            if(image == undefined){
                image = $("#gallerypictureimageurl" + object).attr("url");
                edited = false;
            }
            $("#gallerypicturediv" + object).css("border", "2px solid rgba(255, 255, 255, 1)");
            $("#gallerypicturediv" + object).removeClass("incorrect_field");
            $("#gallerypicturediv" + object).addClass("correct_field");
            picturefilecheck = true;
        }
        else{
            $("#gallerypicturediv" + object).css("border", "2px solid rgba(255, 255, 255, 1)");
            $("#gallerypicturediv" + object).removeClass("correct_field");
            $("#gallerypicturediv" + object).addClass("incorrect_field");
            picturefilecheck = false;
            edited = false;
        }

        if(picturefilecheck && picturetypecheck && pictureheadercheck && picturebodycheck && picturedisplaycheck){
            var submitForm = new FormData();
            submitForm.append("imageFileValue", image);
            submitForm.append("imageFileEdited", edited);
            submitForm.append("imageID", object);
            submitForm.append("imageTypeValue", picturegalleryTypeValue);
            submitForm.append("imageHeaderValue", picturegalleryHeaderValue);
            submitForm.append("imageBodyValue", picturegalleryBodyValue);
            submitForm.append("imageDisplayValue", picturegalleryDisplayValue);
            $("#imagesubmitHelp" + object).addClass("color-custom5");
            $(function(){
                $.ajax({
                url: "PhpScripts/RequestProcessing.php",
                method: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: submitForm,
                    success: function(data){
                        var parsedData = JSON.parse(data);
                        if(parsedData["type"].localeCompare("success")===0){
                            $("#imagesubmitHelp" + object).removeClass("color-custom5");
                            $("#imagesubmitHelp" + object).text(parsedData["message"]);
                            $("#gallerypictureimageurl" + object).removeData("imagefile");
                        }
                        else if(parsedData["type"].localeCompare("errorSQL")===0){
                            $("#imagesubmitHelp" + object).text(parsedData["message"]);
                        }
                        else if(parsedData["type"].localeCompare("error")===0){
                            $("#gallerypicturediv" + object).css("border", "2px solid rgba(255, 255, 255, 1)");
                            $("#gallerypicturediv" + object).removeClass("correct_field");
                            $("#gallerypicturediv" + object).addClass("incorrect_field");
                            $("#imagesubmitHelp" + object).text(parsedData["message"]);
                            $("#gallerypicturediv" + object).css("background-image", "url('Media/Images/PlusIconPNG.png')");
                            $("#gallerypictureimageurl" + object).removeData("imagefile");
                        }
                        else{
                            $("#imagesubmitHelp" + object).text("Nepoznata greška. Pokušajte ponovo kasnije.");
                        }
                    }
                });
            });
        }
    }
}



function updatealltrigger(object, value){
    if(object.prop("checked")){
        setImages(value);
    }
}

function removealltrigger(object, value){
    if(object.prop("checked")){
        removeImages(value);
    }
}

function removeallmesstrigger(object, value){
    if(object.prop("checked")){
        removeMessages(value);
    }
}

function logout(){
    $(function(){
        $.ajax({
        url: "PhpScripts/RequestProcessing.php",
        method: "post",
        cache: false,
        data:{logout:"true"},
        dataType: "json",
            success: function(data){
                window.location.reload();
            }
        });
    });
}

function HypenationJustify(object){
    console.log("A");
    var letterSize = parseInt(object.css("font-size"));
    var textWidth = object.outerWidth();
    console.log(letterSize + " " + textWidth);
    for(var i=0;i<object.length;i++){

    }
}

function ChangeBodyImage(object){
    var image = object.siblings("img");
    $("body").css("background-image", "url('" + image.attr("src") + "')");
}