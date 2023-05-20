"use strict";

const form = document.forms[0];
const elements = [...form.elements];
const submitBtn = elements.pop();
submitBtn.disabled = true;
submitBtn.style.background = "#8dffcc";

const returnHomeBtn = document.getElementsByClassName("return-home-btn")[0];
const closeModalBtn = document.getElementsByClassName("btn-close")[0];
const feedbacks = form.getElementsByClassName("invalid-feedback");

elements[0].addEventListener("input", function () {
  if (this.value === "") {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    feedbacks[0].classList.add("d-block");
    feedbacks[0].textContent = "Este campo es obligatorio.";
  } else if (/\d/.test(this.value)) {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    feedbacks[0].classList.add("d-block");
    feedbacks[0].textContent = "El nombre no puede contener números.";
  } else {
    feedbacks[0].classList.remove("d-block");
    this.classList.remove("is-invalid");
    this.classList.add("is-valid");
    feedbacks[0].textContent = "";
  }
});

elements[1].addEventListener("input", function () {
  if (this.value === "") {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    feedbacks[1].classList.add("d-block");
    feedbacks[1].textContent = "Este campo es obligatorio.";
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    feedbacks[1].classList.add("d-block");
    feedbacks[1].textContent = "El email no es válido";
  } else {
    this.classList.remove("is-invalid");
    this.classList.add("is-valid");
    feedbacks[1].classList.remove("d-block");
    feedbacks[1].textContent = "";
  }
});

elements[2].addEventListener("input", function () {
  if (this.value === "") {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    feedbacks[2].classList.add("d-block");
    feedbacks[2].textContent = "Este campo es obligatorio.";
  } else if (this.value.length < 8 || this.value.length > 15) {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    feedbacks[2].classList.add("d-block");
    feedbacks[2].textContent = "Nombre de usuario no válido";
  } else {
    this.classList.remove("is-invalid");
    this.classList.add("is-valid");
    feedbacks[2].classList.remove("d-block");
    feedbacks[2].textContent = "";
  }
});

elements[3].addEventListener("input", function () {
  if (this.value === "") {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    feedbacks[3].classList.add("d-block");
    feedbacks[3].textContent = "Este campo es obligatorio.";
  } else {
    this.classList.remove("is-invalid");
    this.classList.add("is-valid");
    feedbacks[3].classList.remove("d-block");
    feedbacks[3].textContent = "";
  }
});

elements[4].addEventListener("input", function () {
  if((this.value === "") && (elements[5].value === "")) {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    elements[5].classList.add("is-invalid");
    elements[5].classList.remove("is-valid");
    feedbacks[5].classList.add("d-block");
    feedbacks[5].textContent = "La contraseña es obligatoria.";
  }else if(this.value !== elements[5].value) {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    elements[5].classList.add("is-invalid");
    elements[5].classList.remove("is-valid");
    feedbacks[5].classList.add("d-block");
    feedbacks[5].textContent = "Las contraseñas no coinciden";
  }else{
    this.classList.add("is-valid");
    this.classList.remove("is-invalid");

    elements[5].classList.add("is-valid");
    elements[5].classList.remove("is-invalid");

    feedbacks[5].classList.remove("d-block");
    feedbacks[5].textContent = "";
  }
  
  if (!/^(?=.*\d)(?=.*[A-Z]).{8,}$/.test(this.value)) {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    elements[5].classList.add("is-invalid");
    elements[5].classList.remove("is-valid");
    feedbacks[4].classList.add("d-block");
    feedbacks[4].textContent = "Contraseña debil";
  }else{
    feedbacks[4].classList.remove("d-block");
    feedbacks[4].textContent = "";
  }
});

elements[5].addEventListener("input", function () {
  if((this.value === "") && (elements[4].value === "")) {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    elements[4].classList.add("is-invalid");
    elements[4].classList.remove("is-valid");
    feedbacks[5].classList.add("d-block");
    feedbacks[5].textContent = "La contraseña es obligatoria.";
  }else{
    this.classList.remove("is-invalid");
    this.classList.add("is-valid");
    elements[4].classList.remove("is-invalid");
    elements[4].classList.add("is-valid");

    feedbacks[5].classList.remove("d-block");
    feedbacks[5].textContent = "";
  }
  
  if (this.value !== elements[4].value) {
    this.classList.add("is-invalid");
    this.classList.remove("is-valid");
    elements[4].classList.remove("is-valid");
    elements[4].classList.add("is-invalid");
    feedbacks[5].classList.add("d-block");
    feedbacks[5].textContent = "Las contraseñas no coinciden";
  }
});

// Carga la imagen en el circulo.
const preview = form.querySelector("#preview");
elements[6].addEventListener("change", function() {
    const file = this.files[0];
    if(!(file.type.startsWith("image/"))) {
      this.classList.remove("is-valid");
      this.classList.add("is-invalid");
      feedbacks[6].classList.add("d-block");
      feedbacks[6].textContent = "El archivo no es una imagen";
    }else{
      const reader = new FileReader();
      reader.addEventListener('load', function() {
        preview.setAttribute('src', this.result);
        preview.style.display = 'block';
      });
      reader.readAsDataURL(file);

      this.classList.add("is-valid");
      this.classList.remove("is-invalid");
      feedbacks[6].classList.remvoe("d-block");
      feedbacks[6].textContent = "";
    }
});

form.addEventListener("input", function () {
  const checker = elements.every(input => input.classList.contains("is-valid"));

  if(checker) {
    submitBtn.disabled = false;
    submitBtn.style.background = "#41b883";
  } else {
    submitBtn.disabled = true;
    submitBtn.style.background = "#8dffcc";
  }
});

form.addEventListener("submit", function (e) {
  e.preventDefault();
  fetch("../../controllers/createUserHandler.php", {
    method: "POST",
    body: new FormData(form)
  })
    .then((res) => res.json())
    .then((data) => {
      if (data["username_exists"]) {
        elements[2].classList.remove("is-valid");
        elements[2].classList.add("is-invalid");
        feedbacks[2].classList.add("d-block");
        feedbacks[2].textContent = data["username_message"];
      }else if(data["email_exists"]) {
        elements[1].classList.remove("is-valid");
        elements[1].classList.add("is-invalid");
        feedbacks[1].classList.add("d-block");
        feedbacks[1].textContent = data["email_message"];
      } else {
        elements[1].classList.remove("is-invalid");
        elements[1].classList.add("is-valid");
        feedbacks[1].classList.remove("d-block");
        feedbacks[1].textContent = "";

        elements[2].classList.remove("is-invalid");
        elements[2].classList.add("is-valid");
        feedbacks[2].classList.remove("d-block");
        feedbacks[2].textContent = "";

        elements.forEach(element => element.classList.remove("is-valid"));

        this.reset();
        preview.setAttribute('src', "");

        const modal = new bootstrap.Modal(document.getElementById("registerCompleteModal"));
        modal.show();

        closeModalBtn.addEventListener("click", function() {
          window.location.replace("../../index.php");
        });
        
        returnHomeBtn.addEventListener("click", function() {
          window.location.replace("../../index.php");
        });
      }
    })
    .catch((error) => console.log("Algo salió mal. " + error));
});