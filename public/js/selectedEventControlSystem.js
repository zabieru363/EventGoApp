"use strict";

const deleteUsersButton = document.getElementById("delete-selected-events-btn");
const disabledUsersButton = document.getElementById("disabled-selected-events-btn");
const activeUsersButton = document.getElementById("active-selected-events-btn");
const noSelectedEventsAlert = document.getElementsByClassName("no-selected-events")[0];

const chekboxes = [...document.getElementsByClassName("event-selected")];
const modalBody = document.getElementsByClassName("modal-body")[0];

async function sendSelectedEvents(action) {
    const selectedCheckboxes = chekboxes.filter(checkbox => checkbox.checked);
    if(selectedCheckboxes.length) {
        noSelectedEventsAlert.classList.add("d-none");
        const confirmation = confirm("¿Seguro que quiere relizar esta operación?");

        if(confirmation) {
            const selectedIds = selectedCheckboxes.map(checkbox => checkbox.value);
        
            try {
                const response = await fetch("controllers/eventAdminHandler.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({events_selected: selectedIds, action: action})
                });
        
                if(response.ok) {
                    await response.json();
    
                    // Actualizamos la vista
                    if(action === "delete") {
                        selectedIds.forEach(function(id) {
                            const userRow = document.getElementsByClassName(`event-row-${id}`)[0];
                            userRow.remove();
                        });

                        modalBody.textContent = "Eventos eliminados correctamente. Se han eliminado un total de " + selectedIds.length + " eventos.";
                        const modal = new bootstrap.Modal(document.getElementById("resultOperationModal"));
                        modal.show();
                    }
    
                    if(action === "ban") {
                        selectedIds.forEach(function(id) {
                            const userRow = document.getElementsByClassName(`event-row-${id}`)[0];
                            userRow.children[8].textContent = "NO";
                        });
                        
                        modalBody.textContent = "Eventos desactivados correctamente. Se han desactivado un total de " + selectedIds.length + " eventos.";
                        const modal = new bootstrap.Modal(document.getElementById("resultOperationModal"));
                        modal.show();
                    }

                    if(action === "active") {
                        selectedIds.forEach(function(id) {
                            const userRow = document.getElementsByClassName(`event-row-${id}`)[0];
                            userRow.children[8].textContent = "SI";
                        });

                        modalBody.textContent = "Eventos activados correctamente. Se han activado un total de " + selectedIds.length + " eventos.";
                        const modal = new bootstrap.Modal(document.getElementById("resultOperationModal"));
                        modal.show();
                    }
                }
            }catch(error) {
                console.error("Algo salió mal " + error);
            }
        }
    }else{
        noSelectedEventsAlert.classList.remove("d-none");
    }
}

deleteUsersButton.addEventListener("click", function() {
    sendSelectedEvents("delete");
});

disabledUsersButton.addEventListener("click", function() {
    sendSelectedEvents("ban");
});

activeUsersButton.addEventListener("click", function() {
    sendSelectedEvents("active");
});