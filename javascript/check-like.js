$(document).ready(function() {
    var userId = $(".box-container .box-subcontainer .icons .fa-solid.fa-heart").data("user-id");
    $('.box-container .box-subcontainer .icons .fa-solid.fa-heart').each(function() {
        var productId = $(this).data('product-id');
        checkIfFavorite(userId, productId, $(this));
    });
});
function checkIfFavorite(userId, productId, currentElem){
    //console.log(JSON.stringify({ user_id: userId, product_id: productId }));
    $.ajax({
        method: "POST",
        url: "../php/check-in-wishlist.php",
        contentType: 'application/json',
        data: JSON.stringify({ user_id: userId, product_id: productId }),
        success: function(response){
            if(response.exists_in_wishlist) currentElem.addClass("liked");
        },
        error: function(xhr) {
            alert(xhr.responseText);
        }
    });
}