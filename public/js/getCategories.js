"use strict";

const categoriesDiv = document.getElementsByClassName("categories-container")[0];

fetch("controllers/categoriesHandler.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);
        for(let i = 0; i < data.length; i++) {
            const categoryDiv = document.createElement("div");
            categoryDiv.classList.add("category", "shadow");
            categoryDiv.textContent = data[i];
            categoriesDiv.appendChild(categoryDiv);
        }
    })
    .catch((error) => "Algo salió mal " + error);