"use strict";

function formatNumber(input) {
    // Remove non-numeric characters except decimal point
    let value = input.value.replace(/,/g, '');

    if (!isNaN(value) && value !== "") {
        // Split integer and decimal parts
        let parts = value.split('.');

        // Format integer part with commas
        parts[0] = parseInt(parts[0], 10).toLocaleString();

        // Join back
        input.value = parts.join('.');
    } else {
        // input.value = '';
        input.value = input.value.substring(0, input.value.length - 1)
    }
}