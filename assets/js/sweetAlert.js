"use strict";

var WEB_ROOT_PATH = (typeof window.WEB_ROOT !== 'undefined') ? window.WEB_ROOT : '/abacoos-v2/';
var SUCCESS_LOTTIE_URL = WEB_ROOT_PATH + 'assets/animation/Success.json';

/**
 * Global Lottie Success Alert Renderer (/animate & /ui-ux-pro-max)
 * Replaces static green checkmarks with smooth Success.json animation.
 */
function showLottieSuccessAlert(title, text, confirmText = 'OK', onConfirm = null) {
    if (typeof Swal === 'undefined') return;

    Swal.fire({
        html: `
            <div class="d-flex justify-content-center align-items-center mb-2" style="min-height: 125px;">
                <lottie-player src="${SUCCESS_LOTTIE_URL}" background="transparent" speed="1" style="width: 130px; height: 130px;" autoplay></lottie-player>
            </div>
            <h3 class="neu-title mb-2" style="font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1.35rem; color: #0f172a; letter-spacing: -0.02em;">${title || 'Success'}</h3>
            <p class="text-secondary mb-0 font-weight-bold" style="font-size: 0.9rem; color: #475569;">${text || 'Action completed successfully.'}</p>
        `,
        showConfirmButton: true,
        confirmButtonText: confirmText,
        background: '#e6e7ee',
        customClass: {
            popup: 'neu-popup border-0 rounded-2xl',
            confirmButton: 'neu-btn font-weight-bold uppercase px-4 py-2'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed && typeof onConfirm === 'function') {
            onConfirm();
        }
    });
}

const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('promptStatus') ?? null;
const message = urlParams.get('promptMessage') ?? null;

if (status && status.trim() == "success") {
    showLottieSuccessAlert('Success', message);
} else if (status && status.trim() == "error") {
    Swal.fire({
        icon: 'error',
        title: 'Error',
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

// Clean query parameters after displaying alert
window.history.replaceState({}, document.title, window.location.pathname);