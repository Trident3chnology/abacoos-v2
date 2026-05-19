"use strict";

function setupValidation(inputId, feedbackId, urlBuilder) {
    const input = document.getElementById(inputId);
    const feedback = document.getElementById(feedbackId);

    let debounceTimer;
    let controller;
    let lastValue = '';

    input.addEventListener("input", function () {
        const value = input.value.trim();

        // Reset UI
        feedback.textContent = '';
        input.classList.remove('is-invalid', 'is-valid');

        const modal = input.closest('.modal');
        const submitBtn = modal.querySelector('#submitBtn');
        submitBtn.disabled = false;

        if (value.length === 0) return;

        // Prevent duplicate calls for same value
        if (value === lastValue) return;
        lastValue = value;

        // Debounce (delay request)
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {

            // Cancel previous request
            if (controller) controller.abort();
            controller = new AbortController();

            fetch(urlBuilder(value), { signal: controller.signal })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        feedback.textContent = data.message;
                        feedback.style.color = "red";
                        input.classList.add('is-invalid');
                        submitBtn.disabled = true;
                    } else {
                        feedback.textContent = data.message;
                        feedback.style.color = "green";
                        input.classList.add('is-valid');
                    }
                })
                .catch(err => {
                    if (err.name !== 'AbortError') {
                        feedback.textContent = "Error checking.";
                        feedback.style.color = "orange";
                    }
                });

        }, 100);
    });
}