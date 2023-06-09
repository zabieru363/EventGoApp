"use strict";

const deleteEventButtons = [...document.getElementsByClassName("delete-event-btn")];

deleteEventButtons.forEach(function(button) {
    button.addEventListener("click", function() {
        const eventId = button.getAttribute("data-id");
        const eventContainer = button.closest(".card");
    
        fetch("controllers/deleteEventHandler.php", {
            method: "POST",
            body: JSON.stringify({id: eventId})
        })
            .then(res => res.json())
            .then(data => {
    
            })
            .catch(error => console.log("Algo salió mal " + error));
    });
});