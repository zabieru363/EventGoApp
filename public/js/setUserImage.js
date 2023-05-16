"use strict";

const imageCircle = document.querySelector(".user-image > img");

fetch("controllers/imageHandler.php")
    .then(res => res.json())
    .then(data => {
        imageCircle.src =  `uploads/${data}`;
    })
    .catch((error) => console.log("Algo salió mal " + error));