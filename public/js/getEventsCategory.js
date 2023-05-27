"use strict";

const categoriesContainer = document.getElementsByClassName("categories-container")[0];

for(const category of categoriesContainer) {
    category.addEventListener("click", function() {
        const id = category.getAttribute("data-id");
        const name = category.textContent;
        loadEvents({id, name});
    });
}

function loadEvents(category) {
    fetch("controllers/getEventsCategory.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(category)
    })
        .then(res => res.json())
        .then(data => {

        })
        .catch(error => console.log("Algo salió mal " + error));
}