"use strict";

const categories = [...document.getElementsByClassName("category")];
const form = document.forms[0];
const elements = [...form.elements];
const feedbacks = form.getElementsByClassName("invalid-feedback");

const submitBtn = elements.pop();
submitBtn.disabled = true;
submitBtn.style.background = "#8dffcc";

// * BORRADO
categories.forEach(function(category) {
    category.addEventListener("click", async function() {
        const confirmation = confirm("¿Está seguro de que quiere ejecutar la siguiente operación?");

        if(confirmation) {
            const categoryId = this.getAttribute("data-id");

            try{
                const formData = new FormData();
                formData.append("category_id", categoryId);

                const response = await fetch("controllers/categoryAdminHandler.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: formData
                });

                if(response.ok) {
                    modalBody.textContent = "La categoría ha sido eliminada correctamente";
                    const modal = new bootstrap.Modal(document.getElementById("categoryOperationResult"));
                    modal.show();
                }
            }catch(error) {
                console.error("Algo salió mal " + error);
            }
        }
    });
});

// * ALTA
elements[0].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.remove("is-valid");
        this.classList.add("is-invalid");
        feedbacks.classList.add("d-block");
        feedbacks[0].textContent = "El nombre no puede ser vacío.";
    }else if(/\d/.test(this.value)) {
        this.classList.remove("is-valid");
        this.classList.add("is-invalid");
        feedbacks.classList.add("d-block");
        feedbacks[0].textContent = "El nombre no puede contener números.";
    }else{
        this.classList.add("is-valid");
        this.classList.remove("is-invalid");
        feedbacks.classList.remove("d-block");
        feedbacks[0].textContent = "";
    }
});