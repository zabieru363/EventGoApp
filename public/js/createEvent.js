"use strict";

const radioMe = document.getElementById("me");
const radioOther = document.getElementById("other");
const adminNameInput = document.getElementById("administrator_name");

radioMe.addEventListener("click", () => adminNameInput.classList.add("d-none"));
radioOther.addEventListener("click", () => adminNameInput.classList.remove("d-none"));