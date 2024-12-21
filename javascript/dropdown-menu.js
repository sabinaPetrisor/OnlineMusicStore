let navbar = document.querySelector(".header .flex .navbar");
let profile = document.querySelector(".header .flex .profile");

document.querySelector("#menu-btn").onclick = (event) => {
    event.stopPropagation();
    navbar.classList.toggle("active");
    profile.classList.remove("active");
}

document.querySelector("#user-btn").onclick = (event) => {
    event.stopPropagation();
    profile.classList.toggle("active");
    navbar.classList.remove("active");
}

window.onscroll = () => {
    navbar.classList.remove("active");
    profile.classList.remove("active");
}

document.onclick = (event) => {
    if (!navbar.contains(event.target) && !profile.contains(event.target) && !event.target.matches("#menu-btn") && !event.target.matches("#user-btn")) {
        navbar.classList.remove("active");
        profile.classList.remove("active");
    }
}

