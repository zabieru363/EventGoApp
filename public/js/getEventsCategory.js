"use strict";

import Event from "./entities/Event.js";

const categories = [...document.getElementsByClassName("category")];

for(const category of categories) {
    category.addEventListener("click", function() {
        const id = category.getAttribute("data-id");
        const name = category.textContent;
        loadEvents({id, name});
    });
}

function loadEvents(category) {
    fetch("controllers/getEventsCategoryHandler.php", {
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