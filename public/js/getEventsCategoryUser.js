"use strict";

import Event from "./entities/Event.js";

const categories = [...document.getElementsByClassName("category")];
const eventsContainer = document.getElementsByClassName("events-container")[0];

// * CARGAMOS TODOS LOS EVENTOS
fetch("controllers/getAllEventsHandler.php")
    .then(res => res.json())
    .then(data => {
        // const firstCategory = categories[0];
        console.log(data);
    })
    .catch(error => console.log("Algo salió mal " + error));