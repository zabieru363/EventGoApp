"use strict";

const form = document.forms[0];
const feedbacks = form.getElementsByClassName("invalid-feedback");

// Recogiendo elementos del formulario por id a traves de la variable form.
const eventTitleInput = form["event_title"];
const eventDescriptionTextarea = form["event_description"];

const radioMe = form.me;
const radioOther = form.other;
const adminNameInput = document.getElementById("administrator_name");

const eventLocationSelect = form["locations"];
const eventStartDateInput = form["start_date"];
const eventEndDateInput = form["end_date"];

const eventImagesInput = form["images"];
const dragArea = form.getElementsByClassName("drag-area")[0];
const dragText = dragArea.getElementsByTagName("h2")[0];
const buttonDragArea = dragArea.getElementsByTagName("button")[0];
let files;

function showFiles(files) {
    if(!files.length) {
        processFile(files);
    }else{
        for(const file of files) {
            processFile(file);
        }
    }
}

function processFile(file) {
    const fileType = file.type;
    const validExtensions = ["image/jpeg", "image/jpg", "image/png", "image/gif"];

    if(validExtensions.includes(fileType)) {
    }else{
        feedbacks[6].classList.add("d-blocK");
        feedbacks[6].textContent = "Este archivo no es una imagen";
    }
}

buttonDragArea.addEventListener("click", function(e) {
    e.preventDefault();
    eventImagesInput.click();
});

dragArea.addEventListener("dragover", function(e) {
    e.preventDefault();
    this.classList.add("active");
    dragText.textContent = "Suelta los archivos aquí";
});

dragArea.addEventListener("dragleave", function(e) {
    e.preventDefault();
    this.classList.remove("active");
    dragText.textContent = "Arrastra y suelta imagenes";
});

dragArea.addEventListener("drop", function(e) {
    e.preventDefault();
    files = e.dataTransfer.files;
    showFiles(files);
    this.classList.remove("active");
    dragText.textContent = "Arrastra y suelta imagenes";
});

eventImagesInput.addEventListener("change", function() {
    files = this.files;
    dragArea.classList.add("active");
    showFiles(files);
    dragArea.classList.remove("active");
});

(function() {
    radioMe.addEventListener("click", () => adminNameInput.classList.add("d-none"));
    radioOther.addEventListener("click", () => adminNameInput.classList.remove("d-none"));
})();

// Validación formulario

eventTitleInput.addEventListener("input", function() {
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

eventDescriptionTextarea.addEventListener("input", function() {
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

eventLocationSelect.addEventListener("input", function() {
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

eventStartDateInput.addEventListener("input", function() {
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

eventEndDateInput.addEventListener("input", function() {
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

form.addEventListener("submit", function(e) {
    e.preventDefault();
});