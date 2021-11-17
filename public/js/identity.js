"use strict";
let identity = document.getElementById("identity");
let toggleIdentity = document.getElementById("toggleIdentity");
let arrowDown = document.querySelector(".fa-angle-down");
let arrowUp = document.querySelector(".fa-angle-up");

toggleIdentity.addEventListener("click", function () {
    arrowDown.style.display == "inline-block" ? arrowDown.style.display = "none" : arrowDown.style.display = "inline-block";
    arrowUp.style.display == "inline-block" ? arrowUp.style.display = "none" : arrowUp.style.display = "inline-block";
    identity.style.display == "block" ? identity.style.display = "none" : identity.style.display = "block";
});