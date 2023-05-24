"use strict";

const form = document.forms[0];
const elements = [...form.elements];
const feedbacks = form.getElementsByClassName("invalid-feedback");

const radioMe = document.getElementById("me");
const radioOther = document.getElementById("other");
const adminNameInput = document.getElementById("administrator_name");

(function() {
    radioMe.addEventListener("click", () => adminNameInput.classList.add("d-none"));
    radioOther.addEventListener("click", () => adminNameInput.classList.remove("d-none"));
})();

// Validación formulario

elements[0].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[0].classList.add("d-block");
        feedbacks[0].textContent = "Este campo es obligatorio";
    }else if(!(/^[a-zA-Z0-9\s]+$/.test(this.value))) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[0].classList.add("d-block");
        feedbacks[0].textContent = "Los caracteres especiales no están permitidos";
    }else{
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
        feedbacks[0].classList.remove("d-block");
        feedbacks[0].textContent = "";
    }
});