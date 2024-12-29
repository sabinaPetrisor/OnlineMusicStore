$(document).ready(function(){
    $(".place-order .place-order-form .input-box #country").on("change", function(){
        var countryCode = $(this).find("option:selected").data("country-code");
        //console.log(countryCode);
        $(".place-order .place-order-form .input-box #phone_number_preffix").prop("readonly", false);
        $(".place-order .place-order-form .input-box #phone_number_preffix").val(countryCode);
        $(".place-order .place-order-form .input-box #phone_number_preffix").prop("readonly", true);
    });
    $("#place-order-form").validate({
        rules:{
            first_name:{
                required: true
            },
            last_name:{
                required: true
            },
            email:{
                required: true,
                email: true
            },
            country:{
                required: true
            },
            city:{
                required: true,
            },
            phone_number:{
                required: true,
                digits: true,
                minlength: 7
            },
            address1:{
                required: true
            },
            address2:{
                required: true
            },
            postal_code:{
                required: true,
                digits: true,
                minlength: 5
            },
            payment_method:{
                required: true
            }
        },
        messages:{
            first_name:{
                required: "first name required!"
            },
            last_name:{
                required: "last name required!"
            },
            email:{
                required: "email required!",
                email: "email is not valid!"
            },
            country:{
                required: "country required!"
            },
            city:{
                required: "city required!"
            },
            phone_number:{
                required: "phone number required!",
                digits: "phone number must contain only digits!",
                minlength: "phone number must have at least 7 digits!"
            },
            address1:{
                required: "this field is required!"
            },
            address2:{
                required: "this field is required!"
            },
            postal_code:{
                required: "postal code required!",
                digits: "postal code must contain only digits!",
                minlength: "postal code must contain at least 5 digits!"
            },
            payment_method:{
                required: "payment method required!"
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            dataForm = new FormData(form);
            $.ajax({
                method: "POST",
                url: '../php/place-order-page.php',
                data: dataForm,
                processData: false,
                contentType: false,
                success: function(response){
                    console.log("Response is: ", response.data);
                    if(response.status == "success") {
                        alert(response.message);
                        window.location.href = "http://localhost/OnlineMusicStore/php/home-page.php";
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