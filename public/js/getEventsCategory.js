"use strict";

import Event from "./entities/Event.js";

const categories = [...document.getElementsByClassName("category")];
const eventsContainer = document.getElementsByClassName("events-container")[0];

for(const category of categories) {
    category.addEventListener("click", function() {
        eventsContainer.innerHTML = "";
        const id = category.getAttribute("data-id");
        const name = category.textContent;
        loadEvents({id, name});
    });
}

function loadEvents(category) {
    fetch("controllers/getEventsCategoryHandler.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
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
                    const event = new Event(e.title, e.description, e.admin, e.city, e.start_date, e.end_date, e.images);
                    const eventImages = event.images;
    
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
    
                    const eventContainer = document.createElement("div");
    
                    eventContainer.innerHTML = 
                    `<div class="card mb-3">
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
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Participar
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-item">Puedo ir</li>
                                        <li class="dropdown-item">No puedo ir</li>
                                        <li class="dropdown-item">Todavía no lo se</li>
                                    </ul>
                                </div>
                            </div>
                        </div>`
                    
                        eventsContainer.appendChild(eventContainer);
                }
            }
        })
        .catch(error => console.log("Algo salió mal " + error));
}