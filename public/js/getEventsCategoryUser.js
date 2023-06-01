"use strict";

import Event from "./entities/Event.js";

const categories = [...document.getElementsByClassName("category")];
const firstCategory = categories[0];

randomCategory.classList.add("category-active");
randomCategory.innerHTML += "<i class='ms-3 fa-regular fa-circle-check'></i>";

const eventsContainer = document.getElementsByClassName("events-container")[0];

// * CARGAMOS LOS EVENTOS DE LA PRIMERA CATEGORÍA
