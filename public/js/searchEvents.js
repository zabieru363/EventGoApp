"use strict";

const eventInput = document.getElementsByClassName("event-input")[0];
const resultsDatalist = document.getElementsByClassName("event-results-datalist")[0];

eventInput.addEventListener("input", getResults);
eventInput.addEventListener("blur", function() {
    resultsDatalist.classList.add("d-none");
});

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

                if(data.length < 1) {
                    const li = document.createElement("li");
                    li.textContent = "Sin resultados";

                    li.style.padding = "0.5rem";
                    li.style.borderBottom = "0.5px solid grey";
                    li.style.background = "white";
                    li.style.color = "black";

                    resultsDatalist.appendChild(li);
                }else{
                    data.forEach(() => {
                        const li = `<li dataset-event-id="${data.id}" class="result-datalist">${data.title}</li>`;
                        resultsDatalist.insertAdjacentHTML("beforeend", li);

                        // li.style.padding = "0.5rem";
                        // li.style.borderBottom = "0.5px solid grey";
                        // li.style.background = "white";
                        // li.style.color = "black";
                        // li.style.cursor = "pointer";
                    });

                    array.forEach(element => {
                        
                    });
                }

                resultsDatalist.classList.remove("d-none");
            })
            .catch(error => console.log("Algo salió mal " + error));
    }else{
        resultsDatalist.innerHTML = "";
    }
}
