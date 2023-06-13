"use strict";

const baseContainer = document.getElementsByClassName("container")[0];

const dropdownHTML = {
    rule2 : `<div class='dropdown' rule='2'>
        <button class='btn btn-success'>Participaré</button>
    </div>`,
    rule3 : `<div class='dropdown' rule='3'>
        <button class='btn btn-danger'>No participaré</button>
    </div>`,
    rule4: `<div class="dropdown" rule="4">
        <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pendiente de confirmar
        </button>
        <ul class="dropdown-menu event-participation-options">
            <li class="dropdown-item op21">Puedo ir</li>
            <li class="dropdown-item opt3">No puedo ir</li>
        </ul>
    </div>`
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
                    // const data = await response.json();
        
                    dropdown.innerHTML = dropdownHTML[`rule${rule}`];
                }
            }catch(error) {
                console.error("Algo salió mal " + error);
            }
        });
    }
}