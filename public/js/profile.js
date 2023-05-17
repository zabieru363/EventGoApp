"use strict";

const editProfileBtn = document.getElementsByClassName("edit-profile-btn")[0];
const showAllEventsBtn = document.getElementsByClassName("show-all-events-btn")[0];

const eventsContainer = document.getElementsByClassName("events-container")[0];
const editProfileContainer = document.getElementsByClassName("edit-profile-container")[0];

editProfileBtn.addEventListener("click", function() {
    eventsContainer.classList.add("d-none");
    editProfileContainer.classList.remove("d-none");
});

showAllEventsBtn.addEventListener("click", function() {
    editProfileContainer.classList.add("d-none");
    eventsContainer.classList.remove("d-none");
});