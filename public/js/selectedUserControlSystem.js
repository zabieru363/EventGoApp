"use strict";

const deleteUsersButton = document.getElementById("delete-selected-users-btn");
const disabledUsersButton = document.getElementById("disabled-selected-users-btn");
const activeUsersButton = document.getElementById("active-selected-users-btn");
const noSelectedUsersAlert = document.getElementsByClassName("no-selected-users")[0];

const chekboxes = [...document.getElementsByClassName("user-selected")];
const modalBody = document.getElementsByClassName("modal-body")[0];

async function sendSelectedUsers(action) {
    const selectedCheckboxes = chekboxes.filter(checkbox => checkbox.checked);
    if(selectedCheckboxes.length) {
        noSelectedUsersAlert.classList.add("d-none");
        const confirmation = confirm("¿Seguro que quiere relizar esta operación?");

        if(confirmation) {
            const selectedIds = selectedCheckboxes.map(checkbox => checkbox.value);
        
            try {
                const response = await fetch("controllers/userAdminHandler.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({users_selected: selectedIds, action: action})
                });
        
                if(response.ok) {
                    await response.json();
    
                    // Actualizamos la vista
                    if(action === "delete") {
                        selectedIds.forEach(function(id) {
                            const userRow = document.getElementsByClassName(`user-row-${id}`)[0];
                            userRow.remove();
                        });

                        modalBody.textContent = "Usuarios eliminados correctamente. Se han eliminado un total de " + selectedIds.length + " usuarios.";
                        const modal = new bootstrap.Modal(document.getElementById("resultOperationModal"));
                        modal.show();
                    }
    
                    if(action === "ban") {
                        selectedIds.forEach(function(id) {
                            const userRow = document.getElementsByClassName(`user-row-${id}`)[0];
                            userRow.children[6].textContent = "NO";
                        });
                        
                        modalBody.textContent = "Usuarios desactivados correctamente. Se han desactivado un total de " + selectedIds.length + " usuarios.";
                        const modal = new bootstrap.Modal(document.getElementById("resultOperationModal"));
                        modal.show();
                    }

                    if(action === "active") {
                        selectedIds.forEach(function(id) {
                            const userRow = document.getElementsByClassName(`user-row-${id}`)[0];
                            userRow.children[6].textContent = "SI";
                        });

                        modalBody.textContent = "Usuarios activados correctamente. Se han activado un total de " + selectedIds.length + " usuarios.";
                        const modal = new bootstrap.Modal(document.getElementById("resultOperationModal"));
                        modal.show();
                    }
                }
            }catch(error) {
                console.error("Algo salió mal " + error);
            }
        }
    }else{
        noSelectedUsersAlert.classList.remove("d-none");
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