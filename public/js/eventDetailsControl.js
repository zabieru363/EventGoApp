"use strict";

const modalBody = document.getElementsByClassName("event-participation-modal-body")[0];
const closeModalBtn = document.getElementsByClassName("close-events-participation-modal-btn")[0];
const baseContainer = document.getElementsByClassName("container")[0];

const dropdownHTML = {
    rule2 : `<div class='dropdown' rule='2'>
        <button class='btn btn-success'>Participaré</button>
    </div>`,
    rule3 : `<div class='dropdown' rule='3'>
        <button class='btn btn-danger'>No participaré</button>
    </div>`,
    rule4: `<button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Pendiente de confirmar
            </button>
            <ul class="dropdown-menu event-participation-options">
                <li class="dropdown-item opt2">Puedo ir</li>
                <li class="dropdown-item opt3">No puedo ir</li>
            </ul>`
};

if(baseContainer.classList.contains("session-clossed")) {
    const dropdown = baseContainer.getElementsByClassName("dropdown")[0];
    dropdown.addEventListener("click", () => window.location.replace("index.php?url=login"));
}

if(baseContainer.classList.contains("session-active")) {
    const eventContainer = baseContainer.getElementsByClassName("card")[0];
    const idEvent = +eventContainer.getAttribute("data-id");
    const dropdown = baseContainer.getElementsByClassName("dropdown")[0];

    if(+dropdown.getAttribute("rule") === 1) {
        let rule = 0;
        dropdown.children[1].addEventListener("click", async function(e) {
            if(e.target.classList.contains("opt2")) rule = 2;
            if(e.target.classList.contains("opt3")) rule = 3;
            if(e.target.classList.contains("opt4")) rule = 4;

            try {
                const response = await fetch("controllers/setParticipationRuleEventHandler.php", {
                    method: "POST",
                    body: JSON.stringify({idEvent, rule})
                });
    
                if(response.ok) {
                    dropdown.innerHTML = dropdownHTML[`rule${rule}`];

                    if(rule == 2) {
                        modalBody.textContent = "Confirmación realizada. Participarás en este evento. Se ha añadido a tu lista"
                        + " de eventos en los que vas a participar. Puedes verlo en la sección, Mis eventos" +
                        " > eventos en los que vas a participar.";
                    }

                    if(rule == 3) {
                        modalBody.textContent = "Confirmación realizada. No participarás en este evento. Se ha añadido a tu lista"
                        + " de eventos cancelados. Puedes verlo en la sección, Mis eventos" +
                        " > eventos cancelados.";
                    }

                    if(rule === 4) {
                        modalBody.textContent = "Confirmación pendiente. Se ha añadido a tu lista"
                        + " de eventos pendientes de confirmación. Puedes verlo en la sección, Mis eventos" +
                        " > eventos pendientes de confirmación.";

                        dropdown.children[1].addEventListener("click", async function(e) {
                            let confirmRule = 0;
                            if(e.target.classList.contains("opt2")) confirmRule = 2;
                            if(e.target.classList.contains("opt3")) confirmRule = 3;

                            try {
                                const response = await fetch("controllers/setParticipationRuleEventHandler.php", {
                                    method: "POST",
                                    body: JSON.stringify({idEvent, rule: confirmRule})
                                });

                                if(response.ok) {
                                    dropdown.innerHTML = dropdownHTML[`rule${confirmRule}`];

                                    if(confirmRule == 2) {
                                        modalBody.textContent = "Confirmación realizada. Participarás en este evento. Se ha añadido a tu lista"
                                        + " de eventos en los que vas a participar. Puedes verlo en la sección, Mis eventos" +
                                        " > eventos en los que vas a participar.";
                                    }
                
                                    if(confirmRule == 3) {
                                        modalBody.textContent = "Confirmación realizada. No participarás en este evento. Se ha añadido a tu lista"
                                        + " de eventos cancelados. Puedes verlo en la sección, Mis eventos" +
                                        " > eventos cancelados.";
                                    }

                                    const modal = new bootstrap.Modal(document.getElementById("eventParticipationModal"));
                                    modal.show();

                                    closeModalBtn.addEventListener("click", () => modal.hide());
                                }
                            }catch(error) {
                                console.error("Algo salió mal " + error);
                            }
                        });
                    }

                    const modal = new bootstrap.Modal(document.getElementById("eventParticipationModal"));
                    modal.show();

                    closeModalBtn.addEventListener("click", () => modal.hide());
                }
            }catch(error) {
                console.error("Algo salió mal " + error);
            }
        });
    }

    if(+dropdown.getAttribute("rule") === 4) {
        let rule = 0;
        dropdown.children[1].addEventListener("click", async function(e) {
            if(e.target.classList.contains("opt2")) rule = 2;
            if(e.target.classList.contains("opt3")) rule = 3;

            try {
                const response = await fetch("controllers/setParticipationRuleEventHandler.php", {
                    method: "POST",
                    body: JSON.stringify({idEvent, rule})
                });
    
                if(response.ok) dropdown.innerHTML = dropdownHTML[`rule${rule}`];
            }catch(error) {
                console.error("Algo salió mal " + error);
            }
        });
    }
}