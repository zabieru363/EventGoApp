"use strict";

const eventInput = document.getElementsByClassName("event-input")[0];
const resultsDatalist = document.getElementsByClassName("event-results-datalist")[0];

eventInput.addEventListener("input", getResults);

function getResults() {
    const formData = new FormData();
    formData.append("search", this.value);

    fetch("controllers/searchEventsHandler.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {

        })
        .catch(error => console.log("Algo salió mal " + error));
}
