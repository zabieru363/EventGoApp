"use strict";

const categories = [...document.getElementsByClassName("category")];
const eventsContainer = document.getElementsByClassName("events-container")[0];

categories.forEach(function(category) {
    category.addEventListener("click", function() {
        const events = [...eventsContainer.children];

        events.forEach(event => console.log(event));
    });
});