"use strict";

/**
 * Ultra-Smooth Form Field Validation (/animate & /ui-ux-pro-max)
 * Prevents keypress stuttering, layout shifts, and rapid HTTP requests.
 */
function setupValidation(inputId, feedbackId, urlBuilder) {
    const input = document.getElementById(inputId);
    const feedback = document.getElementById(feedbackId);
    if (!input || !feedback) return;

    let debounceTimer;
    let controller;
    let lastValue = '';

    input.addEventListener("input", function () {
        const value = input.value.trim();
        const modal = input.closest('.modal');
        const submitBtn = modal ? modal.querySelector('#submitBtn') : null;

        if (value.length === 0) {
            clearTimeout(debounceTimer);
            feedback.textContent = '';
            feedback.style.opacity = '0';
            input.classList.remove('is-invalid', 'is-valid');
            if (submitBtn) submitBtn.disabled = false;
            lastValue = '';
            return;
        }

        // Prevent duplicate calls for identical value
        if (value === lastValue) return;

        // Keep layout steady & smoothly dim previous message while user is typing
        feedback.style.opacity = '0.35';

        // Debounce: Wait 350ms after user pauses typing before making API check
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            lastValue = value;

            // Cancel previous in-flight request
            if (controller) controller.abort();
            controller = new AbortController();

            fetch(urlBuilder(value), { signal: controller.signal })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        feedback.textContent = data.message;
                        feedback.style.color = "#dc2626"; // Crimson Red
                        feedback.style.opacity = '1';
                        input.classList.remove('is-valid');
                        input.classList.add('is-invalid');
                        if (submitBtn) submitBtn.disabled = true;
                    } else {
                        feedback.textContent = data.message;
                        feedback.style.color = "#16a34a"; // Clean Emerald Green
                        feedback.style.opacity = '1';
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                        if (submitBtn) submitBtn.disabled = false;
                    }
                })
                .catch(err => {
                    if (err.name !== 'AbortError') {
                        feedback.textContent = "Error checking availability.";
                        feedback.style.color = "#d97706";
                        feedback.style.opacity = '1';
                    }
                });

        }, 350);
    });
}