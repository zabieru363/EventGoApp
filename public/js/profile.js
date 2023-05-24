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
const warning = document.getElementsByClassName("no-update-warning")[0];

editProfileBtn.addEventListener("click", function() {
    editProfileContainer.classList.remove("d-none");
});

// Validación de formulario

elements[0].addEventListener("input", function() {
    if(this.value !== "") {
        if(!/^(?=.*\d)(?=.*[A-Z]).{8,}$/.test(this.value)) {
            this.classList.add("is-invalid");
            this.classList.remove("valid");
            feedbacks[0].classList.add("d-block");
            feedbacks[0].textContent = "Contraseña debil";
        }else{
            this.classList.add("valid");
            this.classList.remove("is-invalid");
            feedbacks[0].classList.remove("d-block");
            feedbacks[0].textContent = "";
        }
    }else{
        this.classList.add("valid");
        this.classList.remove("is-invalid");
        feedbacks[0].classList.remove("d-block");
        feedbacks[0].textContent = "";
    }
});

elements[1].addEventListener("input", function() {
    if(this.value !== "") {
        if(/\d/.test(this.value)) {
            this.classList.add("is-invalid");
            this.classList.remove("valid");
            feedbacks[1].classList.add("d-block");
            feedbacks[1].textContent = "El nombre no puede contener números";
        }else{
            this.classList.add("valid");
            this.classList.remove("is-invalid");
            feedbacks[1].classList.remove("d-block");
            feedbacks[1].textContent = "";
        }
    }else{
        this.classList.add("valid");
        this.classList.remove("is-invalid");
        feedbacks[1].classList.remove("d-block");
        feedbacks[1].textContent = "";
    }
});

elements[2].addEventListener("input", function() {
    if(this.value !== "") this.classList.add("valid");
});

elements[3].addEventListener("change", function(){
    if(this.files.length !== 0) {
        const file = this.files[0];
        if(!(file.type.startsWith("image/"))) {
            this.classList.add("is-invalid");
            this.classList.remove("valid");
            feedbacks[3].classList.add("d-block");
            feedbacks[3].textContent = "El archivo no es una imagen"; 
        }else{
            this.classList.add("valid");
            this.classList.remove("is-invalid");
            feedbacks[3].classList.remove("d-block");
            feedbacks[3].textContent = ""; 
        }
    }
});

form.addEventListener("input", function() {
    const checker = elements.some(input => input.classList.contains("is-invalid"));

    if(checker) {
        submitBtn.disabled = true;
        submitBtn.style.background = "#609ffd";
    }else{
        submitBtn.disabled = false;
        submitBtn.style.background = "#0B5ED7";
    }
});

form.addEventListener("submit", function(e) {
    e.preventDefault();
    
    if(elements[0].value === "" && elements[1].value === "" 
    && elements[2].value === "" && elements[3].files.length === 0) {
        warning.classList.remove("d-none");
    }else{
        warning.classList.add("d-none");
        fetch("controllers/updateUserProfileHandler.php", {
            method: "POST",
            body: new FormData(this)
        })
            .then(res => res.json())
            .then(data => {
                if(data.Image) userInfoElements[0].src = `uploads/${data.Image}`;
                if(data.Name) userInfoElements[2].textContent = data.Name;
                if(data.City) userInfoElements[4].textContent = data.City;

                this.reset();

                const modal = new bootstrap.Modal(document.getElementById("editProfileSuccessModal"));
                modal.show();

                closeModalBtn.addEventListener("click", function() {
                    modal.hide();
                });
            })
            .catch(error => "Algo salió mal " + error);
    }
});