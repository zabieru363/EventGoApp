"use strict";

import Event from "./entities/Event.js";

const categories = [...document.getElementsByClassName("category")];
const rnadomIndex =  Math.floor(Math.random() * categories.length);
const randomCategory = categories[rnadomIndex];

randomCategory.classList.add("category-active");
randomCategory.innerHTML += "<i class='ms-3 fa-regular fa-circle-check'></i>";

const eventsContainer = document.getElementsByClassName("events-container")[0];

// * CARGAMOS LOS EVENTOS DE UNA CATEGORÍA AL AZAR
loadEvents({id: rnadomIndex, name: randomCategory});

for(let i = 0; i < categories.length; i++) {
    categories[i].addEventListener("click", function() {
        eventsContainer.innerHTML = "";     // Vaciamos el contenedor principal de eventos.

        for(let j = 0; j < categories.length; j++) {
            categories[j].classList.remove("category-active");
            categories[j].innerHTML = categories[j].textContent;
        }

        this.classList.add("category-active");
        this.innerHTML += "<i class='ms-3 fa-regular fa-circle-check'></i>";

        const id = categories[i].getAttribute("data-id");
        const name = categories[i].textContent;

        loadEvents({id, name});
    });
}

function loadEvents(category) {
    fetch("controllers/getEventsCategoryHandler.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify(category)
    })
        .then(res => res.json())
        .then(data => {
            if(data.length < 1) {
                const alert = document.createElement("div");

                alert.innerHTML = `<div class="alert alert-success" role="alert">
                    No hay eventos en esta categoría.
                </div>`

                eventsContainer.appendChild(alert);
            }else{
                for(const e of data) {
                    const event = new Event(e.id, e.title, e.description, e.admin, e.city, e.start_date, e.end_date, e.images);
                    const eventImages = event.images;

                    let dynamicHTMLDropdown = "";

                    // Hacemos una petición para ver cuál el estado de cada evento.
                    fetch("controllers/getParticipationRuleEventHandler.php", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({idEvent: event.id})
                    })
                        .then(res => res.json())
                        .then(eventData => {
                            switch(eventData.rule) {
                                case 1:
                                    dynamicHTMLDropdown = `
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Participar
                                        </button>
                                        <ul class="dropdown-menu event-participation-options">
                                            <li class="dropdown-item opt1">Puedo ir</li>
                                            <li class="dropdown-item opt2">No puedo ir</li>
                                            <li class="dropdown-item opt3">Todavía no lo se</li>
                                        </ul>`;
                                    break;
                                case 2:
                                    dynamicHTMLDropdown = `<button class="btn btn-success">Participaré</button>`;
                                    break;
                                case 3:
                                    dynamicHTMLDropdown = `<button class="btn btn-danger">No participaré</button>`;
                                    break;
                                case 4:
                                    dynamicHTMLDropdown = `
                                        <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Pendiente de confirmar
                                        </button>
                                        <ul class="dropdown-menu event-confirmation-options">
                                            <li class="dropdown-item opt2">Puedo ir</li>
                                            <li class="dropdown-item opt3">No puedo ir</li>
                                        </ul>`
                                    break;
                            }
                        })
                        .catch(error => console.log("Algo salió mal " + error));

                    let carouselHTML = "";

                    for(let i = 0; i < eventImages.length; i++) {
                        if(i === 0) {
                            carouselHTML += `<div class="carousel-item active">
                                <img src="uploads/${eventImages[i]}" class="d-block w-100" alt="Imagen del evento">
                            </div>`
                        }else{
                            carouselHTML += `<div class="carousel-item">
                                <img src="uploads/${eventImages[i]}" class="d-block w-100" alt="Imagen del evento">
                            </div>`
                        }
                    }

                    // * CREAMOS UN CONTENEDOR PARA MOSTRAR EL EVENTO Y SUS DATOS
                    const eventContainer = document.createElement("div");

                    eventContainer.innerHTML = 
                    `<div class="card mb-3" data-id=${event.id}>
                            <h1 class="card-header display-6 p-3 text-center">${event.title}</h1>
                            <div class="card-body">
                                <div id="carouselControls" class="carousel slide mb-3" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        ${carouselHTML}
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselControls" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselControls" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
    
                                <h5 class="card-title">Organizado por ${event.admin}</h5>
                                <div class="card-text">
                                    <p class="event-description">
                                        ${event.description}
                                    </p>
                                    <p class="event-date"><i class="fa-solid fa-clock"></i> Empieza el <strong>${event.startDate}</strong>, finaliza el <strong>${event.endingDate}</strong></p>
                                    <p><strong><i class="fa-solid fa-location-dot"></i> ${event.city}</strong></p>
                                </div>
                                <div class='dropdown'>
                                    ${dynamicHTMLDropdown}
                                </div>
                            </div>
                        </div>`
                    
                    eventsContainer.appendChild(eventContainer);
                }
            }
        })
        .catch(error => console.log(error));
}