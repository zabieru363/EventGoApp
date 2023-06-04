"use strict";

const categories = [...document.getElementsByClassName("category")];
const eventsContainer = document.getElementsByClassName("events-container")[0];

document.addEventListener("eventsLoaded", function() {
    categories.forEach(function(category) {
        category.addEventListener("click", function() {
            if(eventsContainer.classList.contains("no-events")) {
                console.log("Sin eventos");
            }else{
                console.log("Con eventos");
            }
        });
    });
});