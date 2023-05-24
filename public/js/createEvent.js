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
    }else if(!(/^[a-zA-Z0-9\sñÑ]+$/.test(this.value))) {
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

elements[1].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[1].classList.add("d-block");
        feedbacks[1].textContent = "Este campo es obligatorio";
    }else{
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
        feedbacks[1].classList.remove("d-block");
        feedbacks[1].textContent = "";
    }
});

elements[3].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[3].classList.add("d-block");
        feedbacks[3].textContent = "Este campo es obligatorio";
    }else{
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
        feedbacks[3].classList.remove("d-block");
        feedbacks[3].textContent = "";
    }
});

elements[6].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[4].classList.add("d-block");
        feedbacks[4].textContent = "Este campo es obligatorio";
    }else{
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
        feedbacks[4].classList.remove("d-block");
        feedbacks[4].textContent = "";   
    }
});

elements[7].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[5].classList.add("d-block");
        feedbacks[5].textContent = "Este campo es obligatorio";
    }else{
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
        feedbacks[5].classList.remove("d-block");
        feedbacks[5].textContent = "";   
    }
});

elements[8].addEventListener("input", function() {
    const files = [...this.files];
    const allImages = files.every(file => file.type.startsWith("image/"));

    if(files.length > 3) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[6].classList.add("d-block");
        feedbacks[6].textContent = "Solo se pueden subir 3 imagenes";
    }else if(!allImages) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[6].classList.add("d-block");
        feedbacks[6].textContent = "Los archivos deben de ser imagenes";
    }else{
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
        feedbacks[5].classList.remove("d-block");
        feedbacks[5].textContent = "";
    }
});

form.addEventListener("submit", function(e) {
    e.preventDefault();
});