"use strict";

const form = document.forms[0];
const loginErrorDiv = document.getElementsByClassName("login-error")[0];

loginErrorDiv.classList.add("alert");
loginErrorDiv.classList.add("alert-danger");
loginErrorDiv.style.display = "none";

// * Parte de validación

form.addEventListener("submit", function(e) {
    e.preventDefault();

    fetch("app/login.php", {
        method: "POST",
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(!data.status) {
            loginErrorDiv.style.display = "block";
        }else{
            loginErrorDiv.style.display = "none";
        }
    });
});