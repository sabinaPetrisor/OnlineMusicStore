$(document).ready(function() {
    var userId = $(".fa-solid.fa-heart").data("user-id");
    $('.box-container .icons .fa-solid.fa-heart').on('click', function() {
        var productId = $(this).data('product-id');
        var userId = $(".fa-solid.fa-heart").data("user-id");
        
        // Verifică dacă inima este deja activată
        if ($(this).hasClass('liked')) {
            // Dacă este activă, dezactivează
            $(this).removeClass('liked');
            updateFavoriteStatus(userId, productId, false);
        } else {
            // Dacă nu este activată, activează
            $(this).addClass('liked');
            updateFavoriteStatus(userId, productId, true);
        }
    });
});

// Funcția care va trimite datele la server pentru a actualiza baza de date
function updateFavoriteStatus(userId, productId, isFavorite) {
    $.ajax({
        method: "POST",
        url: "../php/update-wishlist.php",
        contentType: 'application/json',
        data: JSON.stringify({ user_id: userId, product_id: productId, is_favorite: isFavorite }),
        success: function(response){
            if(response.success) console.log("Wishlist updated successfully!");
            else console.log("Wishlist failed to update!");
        },
        error: function(xhr) {
            alert(xhr.responseText);
        }
    });
    /*fetch('update_favorite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_id: userId, product_id: productId, is_favorite: isFavorite })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Starea favoritului a fost actualizată!");
        }
    });*/
}
