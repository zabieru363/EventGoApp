"use strict";

const userParticipationEventsList = document.getElementsByClassName("user-participation-events")[0];
const userPendingEventsList = document.getElementsByClassName("user-pending-events")[0];
const userCancelledEventsList = document.getElementsByClassName("user-cancelled-events")[0];
console.log(userParticipationEventsList);
console.log(userPendingEventsList);
console.log(userCancelledEventsList);
const deleteEventButtons = [...document.getElementsByClassName("delete-event-btn")];
const confirmBtn = document.getElementsByClassName("confirm")[0];
const cancelBtn = document.getElementsByClassName("cancel")[0];
const closeModalSecondButton = document.getElementsByClassName("return-home-btn")[0];

deleteEventButtons.forEach(function(button) {
    button.addEventListener("click", function() {
        const confirmationModal = new bootstrap.Modal(document.getElementById("eventRemoveConfirmation"));
        confirmationModal.show();

        confirmBtn.addEventListener("click", function() {
            confirmationModal.hide();
            const eventId = button.getAttribute("data-id");
            const eventContainer = button.closest(".card");

            const formData = new FormData();
            formData.append("event_id", eventId);
        
            fetch("controllers/deleteEventHandler.php", {
                method: "POST",
                body: formData
            })
                .then(res => {
                    if(res.ok) {
                        // Si se ha podido eliminar el evento actualizamos la vista.
                        const userParticipationEvents = [...userParticipationEventsList.children];

                        userParticipationEvents.forEach(function(event) {
                            if(event.getAttribute("data-id") === eventId) event.remove();
                        });

                        const userPendingEvents = [...userPendingEventsList.children];

                        userPendingEvents.forEach(function(event) {
                            if(event.getAttribute("data-id") === eventId) event.remove();
                        });

                        const userCancelledEvents = [...userCancelledEventsList.children];

                        userCancelledEvents.forEach(function(event) {
                            if(event.getAttribute("data-id") === eventId) event.remove();
                        });

                        eventContainer.remove();

                        const modal = new bootstrap.Modal(document.getElementById("eventRemovedModal"));
                        modal.show();

                        closeModalSecondButton.addEventListener("click", () => modal.hide());
                    }
                })
                .catch(error => console.log("Algo salió mal " + error));
        });

        cancelBtn.addEventListener("click", () => confirmationModal.hide());
    });
});