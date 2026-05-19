"use strict";

document.addEventListener("DOMContentLoaded", function () {

    // Handle ALL forms with class .form-submit-loader
    document.querySelectorAll(".form-submit-loader").forEach(form => {

        const submitBtn = form.querySelector(".submitBtn");
        const loadingBtn = form.querySelector(".loadingBtn");

        if (!submitBtn || !loadingBtn) return;

        form.addEventListener("submit", function (e) {

            // Stop if invalid
            if (!form.checkValidity()) return;

            // Prevent double submit
            if (form.classList.contains("is-submitting")) {
                e.preventDefault();
                return;
            }

            form.classList.add("is-submitting");

            // Hide submit button
            submitBtn.classList.add("d-none");

            // Show loading button
            loadingBtn.classList.remove("d-none");
        });

    });

});