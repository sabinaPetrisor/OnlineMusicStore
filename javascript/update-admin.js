$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param * 1000000)}, 'File size must be less than {0}MB');

/*$.validator.addMethod('notEqualTo', function(value, element, param) {
    return this.optional(element) || param !== value;
}, "You provided the old password as the new password! They should be different!");*/

$.validator.addMethod('allPassRequired', function(value, element, param) {
    return this.optional(element) || value !== "" && param !== "";
}, "All fields on this side required to change the password!");

$(document).ready(function(){
    $("#update-form").validate({
        rules:{
            email:{
                email: true
            },
            new_password:{
                allPassRequired: "#new_password_confirm",
                minlength: 8
            },
            new_password_confirm:{
                allPassRequired: "#new_password",
                equalTo: "#new_password"
            },
            ppicture:{
                accept: "image/jpg|image/jpeg|image/png",
                filesize: 5
            }
        },
        messages:{
            email:{
                email: "email is not valid!"
            },
            new_password:{
                minlength: "new password must have at least 8 characters!"
            },
            new_password_confirm:{
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
             // Dacă formularul este valid, trimite-l
            dataForm = new FormData(form);
            console.log(dataForm);
            $.ajax({
                method: "POST",
                url: 'http://localhost/OnlineMusicStore/php/admin-update-profile.php',
                data: dataForm,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response.overall_status == "success") {
                        if(response.message !== "") alert(response.message);
                        window.location.href = "http://localhost/OnlineMusicStore/php/admin-page.php";
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