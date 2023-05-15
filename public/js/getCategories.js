"use strict";

const categoriesDiv = document.getElementsByClassName("categories-container")[0];

fetch("controllers/categoriesHandler.php")
    .then(res => res.json())
    .then(data => {
        data.forEach(function(category){
            const categoryDiv = document.createElement("div");
            categoryDiv.classList.add("category", "shadow");
            categoryDiv.textContent = category.name;
            categoriesDiv.appendChild(categoryDiv);
        });
    })
    .catch((error) => "Algo salió mal " + error);