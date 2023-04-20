const body = document.querySelector("body"),
 toggle = body.querySelector(".toggle"),
 student_light = body.querySelector(".light"),
 student_dark = body.querySelector(".dark");

 var menu = document.getElementsByClassName("menu");
 for (var i = 0; i < menu.length; i++) {
    menu[i].addEventListener('click', function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
    })
 }

toggle.addEventListener("click", () => {
    body.classList.toggle("dark");
    // if (body.classList.contains("dark")) {
    //     student_dark.style.display = "block";
    //     student_light.style.display = "none";
    // } else {
    //     student_dark.style.display = "none";
    //     student_light.style.display = "block";
    // }
})

