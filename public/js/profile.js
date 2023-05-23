"use strict";

const editProfileBtn = document.getElementsByClassName("edit-profile-btn")[0];
const editProfileContainer = document.getElementsByClassName("edit-profile-container")[0];

const userInfo = document.getElementsByClassName("user-info")[0];
const userInfoElements = userInfo.children;

const form = document.forms[0];
const elements = [...form.elements];
const feedbacks = form.getElementsByClassName("invalid-feedback");

const submitBtn = elements.pop();

const closeModalBtn = document.getElementsByClassName("return-home-btn")[0];

editProfileBtn.addEventListener("click", function() {
    editProfileContainer.classList.remove("d-none");
});

// Validación de formulario
elements.forEach(input => input.classList.add("is-valid"));

elements[0].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[0].classList.add("d-block");
        feedbacks[0].textContent = "Este campo es obligatorio";
    }else{
        this.classList.add("is-valid");
        this.classList.remove("is-invalid");
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
    }else if(/\d/.test(this.value)) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[1].classList.add("d-block");
        feedbacks[1].textContent = "El nombre no puede contener números";
    }else{
        this.classList.add("is-valid");
        this.classList.remove("is-invalid");
        feedbacks[1].classList.remove("d-block");
        feedbacks[1].textContent = "";
    }
});

elements[2].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[2].classList.add("d-block");
        feedbacks[2].textContent = "Este campo es obligatorio";
    }else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[2].classList.add("d-block");
        feedbacks[2].textContent = "El email no es válido";
    }else{
        this.classList.add("is-valid");
        this.classList.remove("is-invalid");
        feedbacks[2].classList.remove("d-block");
        feedbacks[2].textContent = "";
    }
});

elements[3].addEventListener("input", function(){
    const file = this.files[0];

    if(!(file.type.startsWith("image/"))) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[3].classList.add("d-block");
        feedbacks[3].textContent = "El archivo no es una imagen"; 
    }else{
        this.classList.add("is-valid");
        this.classList.remove("is-invalid");
        feedbacks[3].classList.remove("d-block");
        feedbacks[3].textContent = ""; 
    }
});

form.addEventListener("input", function() {
    const checker = elements.every(input => input.classList.contains("is-valid"));

    if(checker) {
        submitBtn.disabled = false;
        submitBtn.style.background = "#0B5ED7";
    }else{
        submitBtn.disabled = true;
        submitBtn.style.background = "#609ffd";
    }
});

form.addEventListener("submit", function(e) {
    e.preventDefault();
    fetch("controllers/updateUserProfileHandler.php", {
        method: "POST",
        body: new FormData(this)
    })
        .then(res => res.json())
        .then(data => {
            
        })
        .catch(error => "Algo salió mal " + error);
});