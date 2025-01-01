$(document).ready(function(){
    $("#login-form").validate({
        rules: {
            email:{
                required: true,
                email: true
            },
            password:{
                required: true
            }
        },
        messages: {
            username:{
                required: "username required!",
                email: "invalid email!"
            },
            password:{
                required: "password required!"
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
        /*formData.append('email', $("#email").val());
        formData.append('password', $("#password").val());*/
            $.ajax({
                method: "POST",
                url: 'http://localhost/OnlineMusicStore/php/login-page.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Response is: ", response.data);
                    if(response.status == "success") window.location.href = response.data['url'];
                    else alert(response.message);
                },
                error: function(xhr) {
                    alert(xhr.responseText);
                }
            });
        }
    });
});