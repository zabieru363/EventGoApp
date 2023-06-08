"use strict";

const deleteUsersButton = document.getElementById("delete-selected-users-btn");
const disabledUsersButton = document.getElementById("disabled-selected-users-btn");

// Recogemos todos los usuarios seleccionados
const chekboxes = [...document.getElementsByClassName("user-selected")];

deleteUsersButton.addEventListener("click", function() {
    const selectedCheckboxes = chekboxes.filter(checkbox => checkbox.checked);
    const selectedIds = selectedCheckboxes.map(checkbox => checkbox.value);
    console.log(selectedIds);
});