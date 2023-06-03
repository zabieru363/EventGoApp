"use strict";

const form = document.forms[0];
const elements = [...form.elements];
const feedbacks = form.getElementsByClassName("invalid-feedback");
const alertEmail = form.getElementsByClassName("alert-danger")[0];

const submitBtn = elements.pop();
submitBtn.disabled = true;
submitBtn.style.background = "#8dffcc";

elements[0].addEventListener("input", function () {
    if (this.value === "") {
      this.classList.add("is-invalid");
      this.classList.remove("is-valid");
      feedbacks[0].classList.add("d-block");
      feedbacks[0].textContent = "Este campo es obligatorio.";
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
      this.classList.add("is-invalid");
      this.classList.remove("is-valid");
      feedbacks[0].classList.add("d-block");
      feedbacks[0].textContent = "El email no es válido";
    } else {
      this.classList.remove("is-invalid");
      this.classList.add("is-valid");
      feedbacks[0].classList.remove("d-block");
      feedbacks[0].textContent = "";
    }
});

elements[1].addEventListener("input", function () {
    if((this.value === "") && (elements[2].value === "")) {
      this.classList.add("is-invalid");
      this.classList.remove("is-valid");
      elements[2].classList.add("is-invalid");
      elements[2].classList.remove("is-valid");
      feedbacks[2].classList.add("d-block");
      feedbacks[2].textContent = "La contraseña es obligatoria.";
    }else if(this.value !== elements[2].value) {
      this.classList.add("is-invalid");
      this.classList.remove("is-valid");
      elements[2].classList.add("is-invalid");
      elements[2].classList.remove("is-valid");
      feedbacks[2].classList.add("d-block");
      feedbacks[2].textContent = "Las contraseñas no coinciden";
    }else{
      this.classList.add("is-valid");
      this.classList.remove("is-invalid");
  
      elements[2].classList.add("is-valid");
      elements[2].classList.remove("is-invalid");
  
      feedbacks[2].classList.remove("d-block");
      feedbacks[2].textContent = "";
    }
    
    if (!/^(?=.*\d)(?=.*[A-Z]).{8,}$/.test(this.value)) {
      this.classList.add("is-invalid");
      this.classList.remove("is-valid");
      elements[2].classList.add("is-invalid");
      elements[2].classList.remove("is-valid");
      feedbacks[1].classList.add("d-block");
      feedbacks[1].textContent = "Contraseña debil";
    }else{
      feedbacks[1].classList.remove("d-block");
      feedbacks[1].textContent = "";
    }
  });
  
elements[2].addEventListener("input", function () {
    if((this.value === "") && (elements[1].value === "")) {
      this.classList.add("is-invalid");
      this.classList.remove("is-valid");
      elements[1].classList.add("is-invalid");
      elements[1].classList.remove("is-valid");
      feedbacks[2].classList.add("d-block");
      feedbacks[2].textContent = "La contraseña es obligatoria.";
    }else{
      this.classList.remove("is-invalid");
      this.classList.add("is-valid");
      elements[1].classList.remove("is-invalid");
      elements[1].classList.add("is-valid");
  
      feedbacks[2].classList.remove("d-block");
      feedbacks[2].textContent = "";
    }
    
    if (this.value !== elements[1].value) {
      this.classList.add("is-invalid");
      this.classList.remove("is-valid");
      elements[1].classList.remove("is-valid");
      elements[1].classList.add("is-invalid");
      feedbacks[2].classList.add("d-block");
      feedbacks[2].textContent = "Las contraseñas no coinciden";
    }
});

form.addEventListener("input", function() {
    const checker = elements.every(element => element.classList.contains("is-valid"));

    if(checker) {
        submitBtn.disabled = false;
        submitBtn.style.background = "#41b883";
    } else {
        submitBtn.disabled = true;
        submitBtn.style.background = "#8dffcc";
    }
});

form.addEventListener("submit", function(e) {
    e.preventDefault();
    fetch("controllers/resetPasswordHandler.php", {
        method: "POST",
        body: new FormData(this)
    })
        .then(res => res.json())
        .then(data => {
            if(!data.process) {
                alertEmail.textContent = data.message;
                alertEmail.classList.remove("d-none");
            }else{
                alertEmail.classList.add("d-none");

                const modal = new bootstrap.Modal(document.getElementById("resetPasswordComplete"));
                modal.show();

                const modalCloseBtn = document.getElementsByClassName("btn-close")[0];

                modalCloseBtn.addEventListener("click", () => window.location.replace("index.php?url=login"));
            }
        })
        .catch(error => console.log("Algo salió mal " + error));
});