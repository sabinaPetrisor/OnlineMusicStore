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
         }
    });

    $("#login-form").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(this);
        /*formData.append('email', $("#email").val());
        formData.append('password', $("#password").val());*/
        $.ajax({
            method: "POST",
            url: 'http://localhost/OnlineMusicStore/php/login.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log("Response is: ", response.data);
                if(response.status == "success") window.location.href = response.data['url']+"?id="+response.data['user_id'];
                else alert(response.message);
            },
            error: function(xhr) {
                alert(xhr.responseText);
            }
        });
    });
});