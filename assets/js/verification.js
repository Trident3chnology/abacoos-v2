"use strict";

// Auto-focus first input on page load
window.addEventListener('load', () => {
    pinInputs[0].focus();
});

const pinInputs = document.querySelectorAll('.pin-input');
const resendLink = document.getElementById('resendCode');
const form = document.getElementById('form');

pinInputs.forEach((input, index) => {
    // Handle input
    input.addEventListener('input', (e) => {
        const value = e.target.value;

        // Only allow numbers
        if (!/^\d*$/.test(value)) {
            e.target.value = '';
            return;
        }

        // Move to next input if value entered
        if (value && index < pinInputs.length - 1) {
            pinInputs[index + 1].focus();
        }

        // Auto-submit when all 6 digits are filled
        checkAndAutoSubmit();
    });

    // Handle backspace
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
            pinInputs[index - 1].focus();
        }
    });

    // Handle paste
    input.addEventListener('paste', (e) => {
        e.preventDefault();
        const pastedData = e.clipboardData.getData('text').replace(/\D/g, '');

        if (pastedData.length === 6) {
            pinInputs.forEach((input, i) => {
                input.value = pastedData[i] || '';
            });
            pinInputs[5].focus();
            // Auto-submit after paste
            checkAndAutoSubmit();
        }
    });
});

// Auto-submit function
function checkAndAutoSubmit() {
    const pin = Array.from(pinInputs).map(input => input.value).join('');
    if (pin.length === 6) {
        setTimeout(() => {
            verifyPin(pin);
        }, 300);
    }
}

// Verify PIN with fetch
async function verifyPin(pin) {
    const email = document.querySelector('.email-display').value;

    // Optional: disable inputs while verifying
    pinInputs.forEach(input => input.disabled = true);

    try {
        const response = await fetch('include/process.php?action=verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: email, pin: pin })
        });

        const result = await response.json();

        if (response.ok && result.status === 'success') {
            Swal.fire({
                icon: 'success', // 'success', 'error', 'warning', 'info', 'question'
                title: 'Verified!',
                text: 'Verification successful!',
                background: '#e0e5ec',
                customClass: {
                    popup: 'neu-popup',
                    title: 'neu-title',
                    confirmButton: 'neu-btn'
                },
                timer: 1500,
                showConfirmButton: false,
                buttonsStyling: false
            }).then(() => {
                // ✅ Refresh the page after alert closes
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'warning', // 'success', 'error', 'warning', 'info', 'question'
                title: 'Error!',
                text: 'Verification failed: Invalid verification code.',
                background: '#e0e5ec',
                customClass: {
                    popup: 'neu-popup',
                    title: 'neu-title',
                    confirmButton: 'neu-btn'
                },
                timer: 1500,
                showConfirmButton: false,
                buttonsStyling: false
            }).then(() => {
                // ✅ Refresh the page after alert closes
                window.location.reload();
            });
            // Reset fields for retry
            pinInputs.forEach(input => input.value = '');
            pinInputs[0].focus();
        }

    } catch (error) {
        console.error('Error verifying PIN:', error);
        Swal.fire({
            icon: 'warning', // 'success', 'error', 'warning', 'info', 'question'
            title: 'Network Error',
            text: 'Network or server error. Please try again.',
            background: '#e0e5ec',
            customClass: {
                popup: 'neu-popup',
                title: 'neu-title',
                confirmButton: 'neu-btn'
            },
            timer: 1500,
            showConfirmButton: false,
            buttonsStyling: false
        }).then(() => {
            // ✅ Refresh the page after alert closes
            window.location.reload();
        });
    } finally {
        // Re-enable inputs
        pinInputs.forEach(input => input.disabled = false);
    }
}

// resendLink.addEventListener('click', async (e) => {
//     e.preventDefault();
//     const email = document.querySelector('.email-display').value;

//     try {
//         const response = await fetch('process.php?action=resend', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify({ email: email })
//         });

//         const result = await response.json();

//         if (response.ok && result.status === 'success') {
//             alert('📧 Verification code resent!');
//         } else {
//             alert('⚠️ Failed to resend code. Try again.');
//         }

//     } catch (error) {
//         alert('⚠️ Network error. Please try again.');
//     }

//     // Clear inputs
//     pinInputs.forEach(input => input.value = '');
//     pinInputs[0].focus();
// });

// // Auto-focus first input when modal opens
// document.getElementById('staticBackdrop').addEventListener('shown.bs.modal', () => {
//     pinInputs[0].focus();
// });