"use strict";

const form = document.forms[0];
const elements = [...form.elements];
elements.length -= 2;
const feedbacks = form.getElementsByClassName("invalid-feedback");
const loginErrorDiv = document.getElementsByClassName("login-error")[0];
const submitBtn = document.getElementsByClassName("submit-btn")[0];
submitBtn.disabled = true;
submitBtn.style.background = "#8dffcc";

loginErrorDiv.classList.add("alert");
loginErrorDiv.classList.add("alert-danger");
loginErrorDiv.style.display = "none";

// * Parte de validación

elements[0].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        feedbacks[0].classList.add("d-block");
        feedbacks[0].textContent = "Este campo es obligatorio.";
    }else{
        feedbacks[0].classList.remove("d-block");
        this.classList.remove("is-invalid");
        this.classList.add("valid");
        feedbacks[0].textContent = "";
    }
});

elements[1].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        feedbacks[1].classList.add("d-block");
        feedbacks[1].textContent = "Este campo es obligatorio.";
    }else{
        feedbacks[1].classList.remove("d-block");
        this.classList.remove("is-invalid");
        this.classList.add("valid");
        feedbacks[1].textContent = "";
    }
});

form.addEventListener("input", function() {
    const checker = elements.every(element => element.classList.contains("valid"));

    if(checker) {
        submitBtn.disabled = false;
        submitBtn.style.background = "#41b883";
      } else {
        submitBtn.disabled = true;
        submitBtn.style.background = "#8dffcc";
      }
});

// * Comprobando que el login es correcto.

form.addEventListener("submit", function(e) {
    e.preventDefault();

    fetch("../../controllers/loginUser.php", {
        method: "POST",
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(!data.login) {
            loginErrorDiv.classList.remove("d-none");
            loginErrorDiv.textContent = data.message;
        }else{
            loginErrorDiv.classList.add("d-none");
            loginErrorDiv.textContent = "";
        }
    });
});