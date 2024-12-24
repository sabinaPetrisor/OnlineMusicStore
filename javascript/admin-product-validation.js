$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param * 1000000)}, 'File size must be less than {0}MB');

$.validator.addMethod('unsignedAndCorrectFloat', function(value, element) {
    return this.optional(element) || /^(?:[1-9]\d*|\b0\.\d+)$/.test(value)
}, "This must be an unsigned floating value!");

$.validator.addMethod('unsignedAndCorrectInt', function(value, element) {
    return this.optional(element) || /^(?:[1-9]\d*|0)$/.test(value)
}, "This must be an unsigned integer value!");

$(document).ready(function() {
    $("#add-products-form").validate({
        rules:{
            title:{
                required: true
            },
            artist:{
                required: true
            },
            category:{
                required: true
            },
            tracklist:{
                required: true
            },
            release_date:{
                required: true
            },
            price:{
                required: true,
                number: true,
                unsignedAndCorrectFloat: true
            },
            stock:{
                required: true,
                number: true,
                unsignedAndCorrectInt: true
            },
            cover:{
                required: true,
                accept: "image/jpg|image/jpeg|image/png",
                filesize: 5
            }
        },
        messages:{
            title:{
                required: "title required!"
            },
            artist:{
                required: "artist required!"
            },
            category:{
                required: "category required!"
            },
            tracklist:{
                required: "tracklist required!"
            },
            release_date:{
                required: "release date required!"
            },
            price:{
                required: "price required!",
                number: "price must be a number!"
            },
            stock:{
                required: "stock required!",
                number: "stock must be a number!"
            },
            cover:{
                required: "cover picture required!",
                accept: "picture type is not valid!"
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
         },
         submitHandler: function(form) {
            var dataForm = new FormData(form);
            $.ajax({
                method: "POST",
                url: "http://localhost/OnlineMusicStore/php/admin-products.php",
                data: dataForm,
                processData: false,
                contentType: false,
                success: function(response){
                    console.log("Response is: ", response.data);
                    if(response.status == "success") {
                            alert(response.message);
                            window.location.href = "http://localhost/OnlineMusicStore/php/admin-products.php?id="+response.data['admin_id'];
                    }
                    else alert(response.message);
                },
                error: function(xhr)  {
                    alert(xhr.responseText);
                }            
            });
         }
    });

    $("#update-form").validate({
        rules:{
            price:{
                number: true,
                unsignedAndCorrectFloat: true
            },
            stock:{
                number: true,
                unsignedAndCorrectInt: true
            },
            cover:{
                accept: "image/jpg|image/jpeg|image/png",
                filesize: 5
            }
        },
        messages:{
            price:{
                number: "price must be a number!"
            },
            stock:{
                number: "stock must be a number!"
            },
            cover:{
                accept: "picture type is not valid!"
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
         },
         submitHandler: function(form) {
            var dataForm = new FormData(form);
            $.ajax({
                method: "POST",
                url: "../php/admin-update-product.php",
                data: dataForm,
                processData: false,
                contentType: false,
                success: function(response){
                    console.log("Response is: ", response.data);
                    if(response.overall_status == "success") {
                        if(response.message !== "") alert(response.message);
                            window.location.href = "http://localhost/OnlineMusicStore/php/admin-products.php?id="+response.data['admin_id'];
                    }
                    else alert(response.message);
                },
                error: function(xhr)  {
                    alert(xhr.responseText);
                }            
            });
         }
    });
});