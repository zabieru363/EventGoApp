"use strict";

fetch("../../controllers/getCities.php")
.then(res => res.json()
.then(data => {
    console.log(data);
})
.catch(error => "Algo salió mal " + error));