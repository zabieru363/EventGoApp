"use strict";

const eventInput = document.getElementsByClassName("event-input")[0];
const resultsDatalist = document.getElementsByClassName("event-results-datalist")[0];

eventInput.addEventListener("input", getResults);

function getResults() {
    if(this.value !== "") {     // Si no hay nada en el formulario no hay necesidad de hacer ninguna petición.
        const formData = new FormData();
        formData.append("search", this.value);
    
        fetch("controllers/searchEventsHandler.php", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                resultsDatalist.innerHTML = "";

                data.forEach(function(result) {
                    const option = document.createElement("option");
                    option.value = result.id;
                    option.textContent = result.title;
                    resultsDatalist.appendChild(option);
                });
            })
            .catch(error => console.log("Algo salió mal " + error));
    }
}
