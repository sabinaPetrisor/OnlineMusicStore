let navbar = document.querySelector(".header .flex .navbar");

var userBtn = document.getElementById("user-btn");
if(userBtn !== null) var profile = document.querySelector(".header .flex .profile");

document.querySelector("#menu-btn").onclick = (event) => {
    event.stopPropagation();
    navbar.classList.toggle("active");
    if(userBtn !== null) profile.classList.remove("active");
}

if(userBtn !== null) {
    userBtn.onclick = (event) => {
        event.stopPropagation();
        profile.classList.toggle("active");
        navbar.classList.remove("active");
    }
}

window.onscroll = () => {
    navbar.classList.remove("active");
    if(userBtn !== null) profile.classList.remove("active");
}

document.onclick = (event) => {
    if(userBtn !== null){
        if (!navbar.contains(event.target) && !profile.contains(event.target) && !event.target.matches("#menu-btn") && !event.target.matches("#user-btn")) {
            navbar.classList.remove("active");
            profile.classList.remove("active");
        }
    }
    else {
        if(!navbar.contains(event.target) && !event.target.matches("#menu-btn")) navbar.classList.remove("active");
    }
}

