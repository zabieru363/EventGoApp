"use strict";

const baseContainer = document.getElementsByClassName("container")[0];

if(baseContainer.classList.contains("session-clossed")) {
    const dropdown = baseContainer.getElementsByClassName("dropdown")[0];
    dropdown.addEventListener("click", () => window.location.replace("index.php?url=login"));
}

if(baseContainer.classList.contains("session-active")) {
    
}