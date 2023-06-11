"use strict";

const deleteUsersButton = document.getElementById("delete-selected-events-btn");
const disabledUsersButton = document.getElementById("disabled-selected-events-btn");
const activeUsersButton = document.getElementById("active-selected-events-btn");

const chekboxes = [...document.getElementsByClassName("event-selected")];
const modalBody = document.getElementsByClassName("modal-body")[0];

async function sendSelectedEvents(action) {
    const selectedCheckboxes = chekboxes.filter(checkbox => checkbox.checked);
    if(selectedCheckboxes.length) {
        const confirmation = confirm("¿Seguro que quiere relizar esta operación?");

        if(confirmation) {
            const selectedIds = selectedCheckboxes.map(checkbox => checkbox.value);
        
            try {
                const response = await fetch("controllers/userAdminHandler.php", {
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
                            userRow.children[6].textContent = "NO";
                        });
                        
                        modalBody.textContent = "Eventos desactivados correctamente. Se han desactivado un total de " + selectedIds.length + " eventos.";
                        const modal = new bootstrap.Modal(document.getElementById("resultOperationModal"));
                        modal.show();
                    }

                    if(action === "active") {
                        selectedIds.forEach(function(id) {
                            const userRow = document.getElementsByClassName(`user-row-${id}`)[0];
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
        console.log("No ss ha seleccionado ningún usuario");
    }
}

deleteUsersButton.addEventListener("click", function() {
    sendSelectedUsers("delete");
});

disabledUsersButton.addEventListener("click", function() {
    sendSelectedUsers("ban");
});

activeUsersButton.addEventListener("click", function() {
    sendSelectedUsers("active");
});