$.validator.addMethod('isLessThan', function(value, element, param) {
    console.log('Value:', value);
    console.log('Stock:', param.value);
    return this.optional(element) || parseInt(value) <= parseInt(param.value);
}, "Quantity greater than stock!");

function calculateTotalPriceOfAllProducts(){
    var total = 0.0;
    $(".cart .box-subcontainer").each(function(){
        var product_price = parseFloat($("#product_price").data("price"));
        console.log("product_price = " + product_price);
        var quantity = parseInt($(this).find("#quantity").val());
        console.log("quantity = " + quantity);
        var product_total = product_price * quantity;
        total += product_total;
        $("#total").text("Total: " + total + "€");
    });
}

$(document).ready(function(){
    calculateTotalPriceOfAllProducts();
    $("#cart-form").validate({
        rules:{
            stock_hidden:{

            },
            quantity:{
                isLessThan: stock_hidden
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
         }
    });
    $("#quantity").on("input", function() {
        if($(this).valid()) {
            var price = parseInt($("#price_hidden").val());
            //console.log("price/unit = "+price);
            var product_total_price = price * parseInt($(this).val());
            $("#total_price").text("Total price: " + product_total_price + "€");
            calculateTotalPriceOfAllProducts();
        }
    });

});