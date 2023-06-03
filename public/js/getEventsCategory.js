"use strict";

import Event from "./entities/Event.js";

const categories = [...document.getElementsByClassName("category")];
const eventsContainer = document.getElementsByClassName("events-container")[0];
const firstCategory = categories[0];

// * CARGAMOS TODOS LOS EVENTOS
fetch("controllers/getAllEventsHandler.php")
    .then(res => res.json())
    .then(data => {
        categories.forEach(function(category) {
            category.addEventListener("click", function() {
                eventsContainer.innerHTML = "";
                const categoryId = this.getAttribute("data-id");

                for(let i = 0; i < categories.length; i++) {
                    categories[i].classList.remove("category-active");
                    categories[i].innerHTML = categories[i].textContent;
                }
        
                this.classList.add("category-active");
                this.innerHTML += "<i class='ms-3 fa-regular fa-circle-check'></i>";

                // * OBTENEMOS TODOS LOS EVENTOS DE ESA CATEGORÍA
                const categoryEvents = data.filter(e => +categoryId === e.category);

                if(categoryEvents.length < 1) {
                    const alert = document.createElement("div");

                    alert.innerHTML = `<div class="alert alert-success" role="alert">
                        No hay eventos en esta categoría.
                    </div>`

                    eventsContainer.appendChild(alert);
                }else{
                    for(const e of categoryEvents) {
                        // Si esta propiedad no existe significa que no está la sesión iniciada.
                        if(typeof e.rule === "undefined") {
                            const event = new Event(e.id, e.title, e.description, e.admin,
                                e.city, e.start_date, e.end_date, e.images, e.category);
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
                                       <div class='dropdown' rule='1'>
                                           <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                               Participar
                                           </button>
                                           <ul class="dropdown-menu event-participation-options">
                                               <li class="dropdown-item op21">Puedo ir</li>
                                               <li class="dropdown-item opt3">No puedo ir</li>
                                               <li class="dropdown-item opt4">Todavía no lo se</li>
                                           </ul>
                                       </div>
                                   </div>
                               </div>`
                           
                           eventsContainer.appendChild(eventContainer);

                           const dropdown = eventContainer.querySelector(".dropdown");

                           // Si la sesión no está iniciada enviamos al usuario a la página de login.
                           dropdown.addEventListener("click", () => window.location.href = "index.php?url=login");
                        }else{
                            const event = new Event(e.id, e.title, e.description, e.admin,
                                e.city, e.start_date, e.end_date, e.images, e.category, e.rule);
                           const eventImages = event.images;
   
                           let dynamicHTMLDropdown = "";
   
                           switch(event.rule) {
                               case 1:
                                   dynamicHTMLDropdown = `
                                       <div class='dropdown' rule='1'>
                                           <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                               Participar
                                           </button>
                                           <ul class="dropdown-menu event-participation-options">
                                               <li class="dropdown-item op21">Puedo ir</li>
                                               <li class="dropdown-item opt3">No puedo ir</li>
                                               <li class="dropdown-item opt4">Todavía no lo se</li>
                                           </ul>
                                       </div>`;
                                   break;
                               case 2:
                                   dynamicHTMLDropdown = `
                                       <div class='dropdown' rule='2'>
                                           <button class="btn btn-success">Participaré</button>
                                       </div>`;
                                   break;
                               case 3:
                                   dynamicHTMLDropdown = `
                                       <div class='dropdown' rule='3'>
                                           <button class="btn btn-danger">No participaré</button>
                                       </div>`;
                                   break;
                               case 4:
                                   dynamicHTMLDropdown = `
                                       <div class='dropdown' rule='4'>
                                           <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                               Pendiente de confirmar
                                           </button>
                                           <ul class="dropdown-menu event-confirmation-options">
                                               <li class="dropdown-item opt2">Puedo ir</li>
                                               <li class="dropdown-item opt3">No puedo ir</li>
                                           </ul>
                                       </div>`
                                   break;
                           }
   
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
                                       ${dynamicHTMLDropdown}
                                   </div>
                               </div>`
                           
                           eventsContainer.appendChild(eventContainer);
                        }
                    }
                }
            });
        });

        // * SACAMOS LOS EVENTOS DE LA PRIMERA CATEGORÍA.
        const firstCategoryId = +firstCategory.getAttribute("data-id");
        firstCategory.click();
    })
    .catch(error => console.log("Algo salió mal " + error));