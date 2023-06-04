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

                if(data.length < 1) {
                    const li = document.createElement("li");
                    li.textContent = "Sin resultados";

                    li.style.padding = "0.5rem";
                    li.style.borderBottom = "0.5px solid grey";
                    li.style.background = "white";
                    li.style.color = "black";

                    resultsDatalist.appendChild(li);
                }else{
                    data.forEach(function(result) {
                        const li = document.createElement("li");
                        li.setAttribute("event-id", result.id);
                        li.textContent = result.title;
    
                        li.style.padding = "0.5rem";
                        li.style.borderBottom = "0.5px solid grey";
                        li.style.background = "white";
                        li.style.color = "black";

                        resultsDatalist.appendChild(li);
                    });
                }

                resultsDatalist.classList.remove("d-none");
            })
            .catch(error => console.log("Algo salió mal " + error));
    }else{
        resultsDatalist.innerHTML = "";
    }
}
