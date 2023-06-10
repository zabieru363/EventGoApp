"use strict";

const acceptCookiesBtn = document.getElementById("accepCookiesBtn");
const cookiesModal = new bootstrap.Modal(document.getElementById("cookiesModal"));
cookiesModal.show();    // Mostramos el modal por defecto.

acceptCookiesBtn.addEventListener("click", async function() {
    try {
        localStorage.setItem("accepted-cookies", true);
        const formData = new FormData();
        formData.append("cookies-accepted", true);

        const response = await fetch("controllers/cookiesHandler.php", {
            method: "POST",
            body: formData
        });

        if(response.ok) cookiesModal.hide();
    }catch(error) {
        console.error("Algo salió mal " + error);
    }
});