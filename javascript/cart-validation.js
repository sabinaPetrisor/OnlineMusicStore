$.validator.addMethod('isLessThan', function(value, element) {
    console.log('Value:', value);
    var stock = parseInt($(element).closest('.cart-form').find(".stock_hidden").val());
    console.log('Stock:', stock);
    return this.optional(element) || parseInt(value) <= stock;
}, "Quantity greater than stock!");

function calculateTotalPriceOfAllProducts(){
    var total = 0;
    $(".box-subcontainer").each(function(){
        var price = parseFloat($(this).find(".price_hidden").val());
        var quantity = parseInt($(this).find(".box").val());
        var subtotal = price * quantity;
        console.log("subtotal in function is = " + subtotal);
        /*var product_price = parseFloat($(this).find("#price_hidden").data("price"));
        console.log("product_price = " + product_price);
        var quantity = parseInt($(this).find(".quantity").val());
        console.log("quantity = " + quantity);
        var product_total = product_price * quantity;*/
        total += subtotal;
        $(".final-total .total").text("Grand Total: " + total + "€");
    });
}

$(document).ready(function(){
    calculateTotalPriceOfAllProducts();
    $(".cart-form").each(function(){
        /*var productId = $(this).find("input[name='product_id_hidden']").val();
        console.log("productId=", productId);*/
        $(this).validate({
            rules:{
                quantity:{
                    isLessThan: true
                }
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
             }
        });
        $(".box").on("input", function() {
            var currentForm = $(this).closest(".cart-form");
            if(currentForm.valid()) {
                var price = parseFloat(currentForm.find(".price_hidden").val());
                var subtotal = price * parseInt($(this).val());
                console.log("subtotal = "+ subtotal);
                //console.log("price/unit = "+price);
                //var product_total_price = price * parseInt($(this).val());
                calculateTotalPriceOfAllProducts();
                $(this).closest(".box-subcontainer").find(".subtotal").text("Total price: " + subtotal + "€");
                //calculateTotalPriceOfAllProducts();
            }
        });
    });
});