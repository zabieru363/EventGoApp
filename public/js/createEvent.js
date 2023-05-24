"use strict";

const form = document.forms[0];
const elements = [...form.elements];
const feedbacks = form.getElementsByClassName("invalid-feedback");
const uploadedFilesDiv = form.getElementsByClassName("uploaded-files")[0];

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

elements[8].addEventListener("change", function() {
    const uploaded = [];

    for(let i = 0; i < this.files.length; i++) {
        if(uploaded.length < 3) {
            if(!(this.files[i].type.startsWith("image/"))) {
                this.classList.add("is-invalid");
                this.classList.remove("is-valid");
                feedbacks[6].classList.add("d-block");
                feedbacks[6].textContent = "Este archivo no es una imagen";
                break;
            }else{
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
                feedbacks[6].classList.remove("d-block");
                feedbacks[6].textContent = "";
                uploaded.push(this.files[i].name);
    
                const imageName = document.createElement("p");
                imageName.textContent = this.files[i].name;
                uploadedFilesDiv.appendChild(imageName);
            }
        }else{
            this.classList.add("is-invalid");
            this.classList.remove("is-valid");
            feedbacks[6].classList.add("d-block");
            feedbacks[6].textContent = "Solamente se pueden subir 3 imagenes.";
        }
    }
});

form.addEventListener("submit", function(e) {
    e.preventDefault();
});