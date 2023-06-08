"use strict";

const deleteUsersButton = document.getElementById("delete-selected-users-btn");
const disabledUsersButton = document.getElementById("disabled-selected-users-btn");

const chekboxes = [...document.getElementsByClassName("user-selected")];

async function sendSelectedUsers(action) {
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
                    body: JSON.stringify({users_selected: selectedIds, action: action})
                });
        
                if(response.ok) {
                    const data = await response.json();
    
                    // Actualizamos la vista
                    if(action === "delete") {
                        selectedIds.forEach(function(id) {
                            const userRow = document.getElementsByClassName(`user-row-${id}`)[0];
                            userRow.remove();
                        });
                    }
    
                    if(action === "ban") {
                        selectedIds.forEach(function(id) {
                            const userRow = document.getElementsByClassName(`user-row-${id}`)[0];
                            userRow.children[6].textContent = "NO";
                        });
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