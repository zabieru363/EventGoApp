"use strict";

const citiesSelect = document.getElementById("cities");

fetch("../../controllers/citiesHandler.php")
.then(res => res.json()
.then(data => {
    let counter = 1;
    for(let i = 0; i < data.length; i++) {
        const option = document.createElement("option");
        option.setAttribute("value", counter);
        option.textContent = data[i];
        citiesSelect.appendChild(option);
        counter++;
    }
})
.catch(error => "Algo salió mal " + error));