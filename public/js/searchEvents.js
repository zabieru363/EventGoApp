"use strict";

const eventInput = document.getElementsByClassName("event-input")[0];
const resultsDatalist = document.getElementsByClassName("event-results-datalist")[0];

eventInput.addEventListener("input", getResults);
eventInput.addEventListener("blur", function () {
  resultsDatalist.classList.add("d-none");
});

function getResults() {
  if (this.value !== "") {
    // Si no hay nada en el formulario no hay necesidad de hacer ninguna petición.
    const formData = new FormData();
    formData.append("search", this.value);

    fetch("controllers/searchEventsHandler.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        resultsDatalist.innerHTML = "";
        const li = document.createElement("li");
        if(data.length < 1) {
          li.classList.add("result-datalist");
          li.textContent = "Sin resultados";
          resultsDatalist.appendChild(li);
        } else {
          data.forEach(function(result) {
            li.setAttribute("event-id", result.id);
            li.classList.add("result-datalist");
            li.textContent = result.title;
            resultsDatalist.appendChild(li);

            li.addEventListener("click", () => console.log("Evento clic activado"));
          });

          resultsDatalist.classList.remove("d-none");
        }
      })
      .catch((error) => console.log("Algo salió mal " + error));
  } else {
    resultsDatalist.innerHTML = "";
    resultsDatalist.classList.add("d-none");
  }
}