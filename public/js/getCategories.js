"use strict";

const categoriesDiv = document.getElementsByClassName("categories-container")[0];

fetch("controllers/categoriesHandler.php")
    .then(res => res.json())
    .then(data => {
        for(let i = 0; i < data.length; i++) {
            const categoryDiv = document.createElement("div");
            categoryDiv.classList.add("category", "shadow", "mt-2", "p-2");
            categoryDiv.textContent = data[i];
            categoriesDiv.appendChild(categoryDiv);
        }
    })
    .catch((error) => "Algo salió mal " + error);