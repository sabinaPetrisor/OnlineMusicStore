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
         }
    });

    $("#register-form").on("submit", function(e) {
        e.preventDefault();
        var ppicture_length = $("#ppicture")[0].files.length;
        if(ppicture_length == 0) var ppicture = 'default-profile-pic.png';
        else var ppicture = $("#ppicture")[0].files[0].name;
        var data = {
            'username': $("#username").val(),
            'email': $("#email").val(),
            'password': $("#password").val(),
            'ppicture': ppicture
        };
        dataToJson = JSON.stringify(data); 
        console.log(dataToJson);
        $.ajax({
            method: "POST",
            url: '../php/register.php',
            //dataType: "json",
            data: {data: dataToJson},
            //processData: false,
            //cache: false,
            //async: false,
            success: function(response){
                console.log("Response is: ", response.data);
                if(response.status == "succes") alert(response.message);
                else alert(response.message);
            },
            error: function(xhr)  {
                alert(xhr.responseText);
            }            
        });
    });
});