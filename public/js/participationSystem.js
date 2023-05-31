"use strict";

const categories = [...document.getElementsByClassName("category")];

categories.forEach(function(category) {
    category.addEventListener("click", function(e) {
        const eventsContainer = document.getElementsByClassName("events-container")[0];

        if(eventsContainer.children.length < 1) {
            console.log("La categoría NO tiene eventos");
        }else{
            console.log("La categoría tiene eventos");
        }
    });
});