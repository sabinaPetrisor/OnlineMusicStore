$(document).on("submit", "#register-form", function(e) {
    e.preventDefault();
    var username = $("#username").val();
    var email = $("#email").val();
    var pass = $("#pass").val();
    var ppicture = $("#profile-picture")[0].files;
    /*data.append('file', $(profile_picture)[0]);*/
    var data = new FormData();
    data.append('username', username);
    data.append('email', email);
    data.append('password', pass);
    data.append('profile picture', ppicture);
    /*var ppicture = $("#profile-picture")[0].files;*/
    $.ajax({
        type: "POST",
        url: "../php/register.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data){
            console.log(data);
            var json_response = JSON.parse(data);
            if(json_response.status == "success"){
                alert("Registration successful!");
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