"use strict";

const form = document.forms[0];
const feedbacks = form.getElementsByClassName("invalid-feedback");

// Recogiendo elementos del formulario por id a traves de la variable form.
const eventTitleInput = form["event_title"];
const eventDescriptionTextarea = form["event_description"];
const adminRadio = form.adminRadio;

const radioMe = form.me;
const radioOther = form.other;
const adminNameInput = document.getElementById("administrator_name");

const eventLocationSelect = form["locations"];
const eventCategoriesSelect = form["event_categories"];
const eventStartDateInput = form["start_date"];
const eventEndDateInput = form["end_date"];

const eventImagesInput = form["images"];

const submitBtn = form.getElementsByClassName("submit-btn")[0];
submitBtn.disabled = true;
submitBtn.style.background = "#8dffcc";

const modalTitle = document.getElementsByClassName("modal-title")[0];
const modalBody = document.getElementsByClassName("modal-body")[0];
const closeModalBtn = document.getElementsByClassName("btn-close")[0];

(function() {
    radioMe.addEventListener("click", function() {
        adminNameInput.classList.add("d-none");
        adminNameInput.value = "";
        adminNameInput.classList.remove("is-valid");
        adminNameInput.classList.remove("is-invalid");
        feedbacks[2].textContent = "";
    });

    radioOther.addEventListener("click", () => adminNameInput.classList.remove("d-none"));
})();

// Validación formulario

eventTitleInput.addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[0].classList.add("d-block");
        feedbacks[0].textContent = "Este campo es obligatorio";
    }else if(!(/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/.test(this.value))) {
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

adminNameInput.addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[2].classList.add("d-block");
        feedbacks[2].textContent = "Este campo es obligatorio";
    }else if(!(/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/.test(this.value))) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[2].classList.add("d-block");
        feedbacks[2].textContent = "Los caracteres especiales y números no están permitidos";
    }else{
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
        feedbacks[2].classList.remove("d-block");
        feedbacks[2].textContent = "";
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

eventCategoriesSelect.addEventListener("input", function() {
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

eventStartDateInput.addEventListener("input", function() {
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

eventEndDateInput.addEventListener("input", function() {
    if(this.value === "") {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[6].classList.add("d-block");
        feedbacks[6].textContent = "Este campo es obligatorio";
    }else{
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
        feedbacks[6].classList.remove("d-block");
        feedbacks[6].textContent = "";   
    }
});

eventImagesInput.addEventListener("input", function() {
    let valid = true;

    if(this.files.length <= 3) {
        for(const file of this.files) {
            if(!(file.type.startsWith("image/"))) {
                valid = false;
                this.value = "";
                break;
            }
        }

        if(valid) {
            this.classList.remove("is-invalid");
            this.classList.add("is-valid");
            feedbacks[7].classList.remove("d-block");
            feedbacks[7].textContent = "";  
        }else{
            this.classList.add("is-invalid");
            this.classList.remove("is-valid");
            feedbacks[7].classList.add("d-block");
            feedbacks[7].textContent = "Se ha subido un archivo que no es una imagen. Vuelve a subir los archivos";
        }

    }else{
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
        feedbacks[7].classList.add("d-block");
        feedbacks[7].textContent = "Solamente puedes subir 3 imagenes cómo máximo";
        this.value = "";
    }
});

form.addEventListener("input", function() {
    const fields = [eventTitleInput, eventDescriptionTextarea, eventLocationSelect,
    eventCategoriesSelect, eventStartDateInput, eventEndDateInput, eventImagesInput];

    if(adminRadio.value === "other") {
        fields.push(adminNameInput);
        if(adminNameInput.value === "") {
            submitBtn.disabled = true;
            submitBtn.style.background = "#8dffcc";
        }
    }

    const allValid = fields.every(field => field.classList.contains("is-valid"));

    if(!allValid || adminRadio.value === "") {
        submitBtn.disabled = true;
        submitBtn.style.background = "#8dffcc";
    }else{
        submitBtn.disabled = false;
        submitBtn.style.background = "#41b883";
    }
});

form.addEventListener("submit", function(e) {
    e.preventDefault();

    fetch("controllers/createEventHandler.php", {
        method: "POST",
        body: new FormData(this)
    })
        .then(res => res.json())
        .then(data => {
            if(data.created) {
                const modal = new bootstrap.Modal(document.getElementById("createEventModal"));
                modalTitle.textContent = "Evento creado";
                if(data.assigned && data["event_user_assoc"]) 
                    modalBody.textContent = `Se ha creado el evento y se ha encuadrado en la categoría 
                    ${eventCategoriesSelect.options[eventCategoriesSelect.selectedIndex].text}`;
                modal.show();
            }

            this.reset();
            [...form.elements].forEach(input => input.classList.remove("is-valid"));

            closeModalBtn.addEventListener("click", () => window.location.replace("index.php"));
        })
        .catch(error => console.log("Algo salió mal: " + error));
});