"use strict";

const userParticipationEventsList = document.getElementsByClassName("user-participation-events")[0];
const userPendingEventsList = document.getElementsByClassName("user-pending-events")[0];
const userCancelledEventsList = document.getElementsByClassName("user-cancelled-events")[0];

const modalBody = document.getElementsByClassName("confirm-events-modal-body")[0];
const closeConfirmModalBtn = document.getElementsByClassName("close-confirm-modal-btn")[0];
const dropdowns = [...userPendingEventsList.getElementsByClassName("dropdown")];

dropdowns.forEach(function(dropdown) {
    dropdown.children[1].addEventListener("click", async function(e) {
        let rule = 0;
        const eventId = dropdown.getAttribute("data-id");
        const eventContainer = dropdown.closest(".card");
        if(e.target.classList.contains("opt2")) rule = 2;
        if(e.target.classList.contains("opt3")) rule = 3;

        try {
            const response = await fetch("controllers/setParticipationRuleEventHandler.php", {
                method: "POST",
                body: JSON.stringify({idEvent: eventId, rule: rule})
            });

            if(response.ok) {
                if(rule === 2) {
                    const dropdownForRemove = eventContainer.getElementsByClassName("dropdown")[0];
                    dropdownForRemove.remove();
                    userParticipationEventsList.appendChild(eventContainer);
                    modalBody.textContent = "Participarás en este evento, tu confirmación ha sido realizada. Puedes verlo en tu lista de eventos en los que participas";
                }

                if(rule === 3) {
                    const dropdownForRemove = eventContainer.getElementsByClassName("dropdown")[0];
                    dropdownForRemove.remove();
                    userCancelledEventsList.appendChild(eventContainer);
                    modalBody.textContent = "No participarás en este evento, tu confirmación ha sido realizada. Puedes verlo en tu lista de eventos cancelados";
                }

                dropdown.remove();

                const modal = new bootstrap.Modal(document.getElementById("confirmEventsModal"));
                modal.show();

                closeConfirmModalBtn.addEventListener("click", () => modal.hide());
            }

        }catch(error) {
            console.error("Algo salió mal " + error);
        }
    });
});