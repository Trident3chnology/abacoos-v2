"use strict";

const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('promptStatus') ?? null;
const message = urlParams.get('promptMessage') ?? null;

if (status && status.trim() == "success") {
    Swal.fire({
        icon: 'success', // 'success', 'error', 'warning', 'info', 'question'
        title: 'Success',
        text: message,
        confirmButtonText: 'OK',
        background: '#e0e5ec',
        customClass: {
            popup: 'neu-popup',
            title: 'neu-title',
            confirmButton: 'neu-btn'
        },
        buttonsStyling: false
    });
}

// Remove query string after showing
window.history.replaceState({}, document.title, window.location.pathname);