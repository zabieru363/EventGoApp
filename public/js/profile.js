"use strict";

const editProfileBtn = document.getElementsByClassName("edit-profile-btn")[0];
const showAllEventsBtn = document.getElementsByClassName("show-all-events-btn")[0];

const eventsContainer = document.getElementsByClassName("events-container")[0];
const editProfileContainer = document.getElementsByClassName("edit-profile-container")[0];

const userInfo = document.getElementsByClassName("user-info")[0];
const userInfoElements = userInfo.children;

editProfileBtn.addEventListener("click", function() {
    eventsContainer.classList.add("d-none");
    editProfileContainer.classList.remove("d-none");
});

showAllEventsBtn.addEventListener("click", function() {
    editProfileContainer.classList.add("d-none");
    eventsContainer.classList.remove("d-none");
});

// Obteniendo los datos del perfil de usuario.
fetch("../../controllers/userDataHandler.php")
    .then(res => res.json())
    .then(data => {
        userInfoElements[0].src = `../../uploads/${data.Image}`;
        userInfoElements[2].textContent = data.name;
        userInfoElements[3].textContent = data.email;
    })
    .catch(error => "Algo salió mal " + error);