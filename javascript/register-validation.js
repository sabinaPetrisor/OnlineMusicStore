$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param * 1000000)}, 'File size must be less than {0}MB');

$(document).ready(function(){
    $("#register-form").validate({
        rules:{
            username:{
                required: true
            },
            email:{
                required: true,
                email: true
            },
            password:{
                required: true,
                minlength: 8
            },
            cpass:{
                required: true,
                equalTo: "#password"
            },
            ppicture:{
                accept: "image/jpg|image/jpeg|image/png",
                filesize: 5
            }
        },
        messages:{
            username:{
                required: "username required!"
            },
            email:{
                required: "email required!",
                email: "email is not valid!"
            },
            password:{
                required: "password required!",
                minlength: "password must have at least 8 characters!"
            },
            cpass:{
                required: "confirmation of password required!",
                equalTo: "passwords are not the same!"
            },
            ppicture:{
                accept: "picture type is not valid!",
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
         },
         submitHandler: function(form) {
            dataForm = new FormData(form);
            $.ajax({
                method: "POST",
                url: 'http://localhost/OnlineMusicStore/php/register.php',
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