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
        resultsDatalist.classList.remove("d-none");

        if(data.length < 1) {
          const li = document.createElement("li");
          li.classList.add("result-datalist");
          li.textContent = "Sin resultados";
          resultsDatalist.appendChild(li);
        } else {
          data.forEach(function(result) {
            const li = document.createElement("li");
            li.setAttribute("event-id", result.id);
            li.classList.add("result-datalist");
            li.textContent = result.title;
            resultsDatalist.appendChild(li);

            li.addEventListener("mousedown", function() {
              const eventId = li.getAttribute("event-id");
              window.location.href = `index.php?url=event&action=details&id=${eventId}`;
            });
          });
        }
      })
      .catch((error) => console.log("Algo salió mal " + error));
  } else {
    resultsDatalist.innerHTML = "";
    resultsDatalist.classList.add("d-none");
  }
}