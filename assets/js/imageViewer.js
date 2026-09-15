"use strict";

const viewer = document.getElementById('imageViewer');
const viewerImg = document.getElementById('viewerImg');
const closeViewer = document.getElementById('closeViewer');
const viewerDownload = document.getElementById('viewerDownload');

function openViewer(src) {
    if (!viewer || !viewerImg) return;
    viewerImg.src = src;
    if (viewerDownload) {
        viewerDownload.href = src;
    }
    viewer.style.display = 'flex';

    // trigger animation
    setTimeout(() => {
        viewer.classList.add('active');
    }, 10);
}

function closeViewerFunc() {
    if (!viewer) return;
    viewer.classList.remove('active');

    setTimeout(() => {
        viewer.style.display = 'none';
    }, 280);
}

if (closeViewer) {
    closeViewer.onclick = closeViewerFunc;
}

if (viewer) {
    viewer.addEventListener('click', (e) => {
        if (e.target === viewer) {
            closeViewerFunc();
        }
    });
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && viewer && viewer.classList.contains('active')) {
        closeViewerFunc();
    }
});