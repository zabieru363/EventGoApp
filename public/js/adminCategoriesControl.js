"use strict";

const categoriesContainer = document.getElementsByClassName("categories-container")[0];
const categories = [...document.getElementsByClassName("category")];
const form = document.forms[0];
const elements = [...form.elements];
const feedback = form.getElementsByClassName("invalid-feedback")[0];

const submitBtn = elements.pop();
submitBtn.disabled = true;
submitBtn.style.background = "#8dffcc";

const modalBody = document.getElementsByClassName("modal-body")[0];

async function deleteCategory() {
    const confirmation = confirm("¿Está seguro de que quiere ejecutar la siguiente operación?");

    if(confirmation) {
        const categoryId = +this.getAttribute("data-id");

        try{
            const response = await fetch("controllers/categoryAdminHandler.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({id: categoryId, action: "delete"})
            });

            if(response.ok) {
                this.remove();
                modalBody.textContent = "La categoría ha sido eliminada correctamente";
                const modal = new bootstrap.Modal(document.getElementById("categoryOperationResult"));
                modal.show();
            }
        }catch(error) {
            console.error("Algo salió mal " + error);
        }
    }
}

// * BORRADO
categories.forEach(function(category) {
    category.addEventListener("click", deleteCategory);
});

// * ALTA
elements[0].addEventListener("input", function() {
    if(this.value === "") {
        this.classList.remove("is-valid");
        this.classList.add("is-invalid");
        feedback.classList.add("d-block");
        feedback.textContent = "El nombre no puede ser vacío.";
    }else if(/\d/.test(this.value)) {
        this.classList.remove("is-valid");
        this.classList.add("is-invalid");
        feedback.classList.add("d-block");
        feedback.textContent = "El nombre no puede contener números.";
    }else{
        this.classList.add("is-valid");
        this.classList.remove("is-invalid");
        feedback.classList.remove("d-block");
        feedback.textContent = "";
    }
});

form.addEventListener("input", function() {
    if(elements[0].classList.contains("is-valid")) {
        submitBtn.disabled = false;
        submitBtn.style.background = "#198754";
    }else{
        submitBtn.disabled = true;
        submitBtn.style.background = "#8dffcc";
    }
});

form.addEventListener("submit", async function(e) {
    e.preventDefault();

    try{
        const response = await fetch("controllers/categoryAdminHandler.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({name: elements[0].value, action: "create"})
        });

        if(response.ok) {
            const data = response.json();
            console.log(data.id);

            const categoryDiv = document.createElement("div");
            categoryDiv.classList.add("category", "shadow", "mt-2", "p-2");
            categoryDiv.textContent = elements[0].value;
            categoryDiv.setAttribute("data-id", data.id);
            categoriesContainer.appendChild(categoryDiv);

            modalBody.textContent = "La categoría ha sido creada correctamente";
            const modal = new bootstrap.Modal(document.getElementById("categoryOperationResult"));
            modal.show();

            categoryDiv.addEventListener("click", deleteCategory);
        }
    }catch(error) {
        console.error("Algo salió mal " + error);
    }
});