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
                filesize: 5,

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
        //e.preventDefault();
        var username = $("#username").val();
        var email = $("#email").val();
        var pass = $("#password").val();
        var ppicture = $("#ppicture")[0].files;
        /*data.append('file', $(profile_picture)[0]);*/
        var data = new FormData();
        data.append('username', username);
        data.append('email', email);
        data.append('password', pass);
        data.append('ppicture', ppicture);
        /*var ppicture = $("#profile-picture")[0].files;*/
        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                var json_response = JSON.parse(data);
                if(json_response.status == "success"){
                    console.log(JSON.stringify(data));
                    alert(json_response.message);

                }
                else{
                    alert("Error: " + json_response.message);
                }
            },
            error: function(){
                alert("Error on Ajax form processing!");
            }
        });
    });
});