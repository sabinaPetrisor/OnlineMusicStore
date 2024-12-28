function calculateTotalPriceOfAllProducts(){
    var total = 0;
    $(".place-order .box-subcontainer").each(function(){
        var total_product_price = parseFloat($("#total-product-price").data("total-product-price"));
        console.log("total_product_price = " + total_product_price);
        total += total_product_price;
        $("#total").text("Grand Total: " + total + "€");
    });
}

$(document).ready(function(){
    calculateTotalPriceOfAllProducts();
});