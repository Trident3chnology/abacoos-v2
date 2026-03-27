"use strict";

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    const submitBtn = document.getElementById("submitBtn");
    const loadingBtn = document.getElementById("loadingBtn");

    form.addEventListener("submit", function () {
        if (!form.checkValidity()) return;

        // Hide submit button
        submitBtn.classList.add("d-none");

        // Show loading button
        loadingBtn.classList.remove("d-none");
    });
});