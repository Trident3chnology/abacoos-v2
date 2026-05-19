"use strict";

const viewer = document.getElementById('imageViewer');
const viewerImg = document.getElementById('viewerImg');
const closeViewer = document.getElementById('closeViewer');

function openViewer(src) {
    viewerImg.src = src;
    viewer.style.display = 'flex';

    // trigger animation
    setTimeout(() => {
        viewer.classList.add('active');
    }, 10);
}

function closeViewerFunc() {
    viewer.classList.remove('active');

    setTimeout(() => {
        viewer.style.display = 'none';
    }, 300);
}

closeViewer.onclick = closeViewerFunc;

viewer.addEventListener('click', (e) => {
    if (e.target === viewer) {
        closeViewerFunc();
    }
});