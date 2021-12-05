"use strict";

let toggleButton = document.querySelectorAll(".toggleButton");


toggleButton.forEach(button => {
    button.addEventListener('click', () => {
        let buttonId = button.getAttribute("id");
        console.log("id button : ", buttonId);

        let parentUl = button.closest("ul");
        let ulId = parentUl.getAttribute("id");
        console.log("id ul : ", ulId);

        let toggleContent = parentUl.querySelector(".toggleContent");
        let contentId = toggleContent.getAttribute("id");
        console.log("id content : ", contentId);

        let arrowDown = button.querySelector(".fa-angle-down");
        let arrowUp = button.querySelector(".fa-angle-up");
        arrowDown.style.display == "inline-block" ? arrowDown.style.display = "none" : arrowDown.style.display = "inline-block";
        arrowUp.style.display == "inline-block" ? arrowUp.style.display = "none" : arrowUp.style.display = "inline-block";
        toggleContent.style.display == "block" ? toggleContent.style.display = "none" : toggleContent.style.display = "block";
    });
});