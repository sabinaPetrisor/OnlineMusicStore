$(document).ready(function(){
    $("#price-slider").on("input", function(){
        $("#price-slider-value").text("Max price: "+$(this).val()+"€");
    });

    /*$(".genre").each(function(){
        if()
    });*/
});