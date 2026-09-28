/**
 * Abacoos PWA Manager
 * Handles Service Worker registration, install prompts, and connection status notifications.
 */
(function () {
  'use strict';

  var deferredPrompt = null;
  var webRoot = window.WEB_ROOT || '/abacoos-v2/';
  var swUrl = webRoot.endsWith('/') ? webRoot + 'sw.js' : webRoot + '/sw.js';

  // 1. Register Service Worker
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
      navigator.serviceWorker
        .register(swUrl)
        .then(function (reg) {
          // Check for SW updates
          reg.onupdatefound = function () {
            var installingWorker = reg.installing;
            if (installingWorker) {
              installingWorker.onstatechange = function () {
                if (installingWorker.state === 'installed' && navigator.serviceWorker.controller) {
                  showNotification('New version available. Refresh to update.', 'info');
                }
              };
            }
          };
        })
        .catch(function (err) {
          console.warn('[PWA] Service Worker registration failed:', err);
        });
    });
  }

  // 2. Check if already installed / standalone mode
  var isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;

  // 3. Capture PWA Install Prompt
  window.addEventListener('beforeinstallprompt', function (e) {
    e.preventDefault();
    deferredPrompt = e;

    // Only suggest install if user hasn't dismissed it in the last 7 days
    var dismissedUntil = localStorage.getItem('abacoos_pwa_dismissed');
    if (dismissedUntil && Date.now() < parseInt(dismissedUntil, 10)) {
      return;
    }

    if (!isStandalone) {
      showInstallPromptBanner();
    }
  });

  // 4. Handle Successful Installation
  window.addEventListener('appinstalled', function () {
    deferredPrompt = null;
    hideInstallPromptBanner();
    showNotification('Abacoos installed successfully!', 'success');
  });

  // 5. Online / Offline Connectivity Notifications
  window.addEventListener('online', function () {
    showNotification('Back online! Reconnected to server.', 'success');
  });

  window.addEventListener('offline', function () {
    showNotification('You are currently offline. Cached resources remain accessible.', 'warning');
  });

  // UI Helpers
  function showNotification(msg, type) {
    var existingToast = document.getElementById('pwa-status-toast');
    if (existingToast) {
      existingToast.remove();
    }

    var toast = document.createElement('div');
    toast.id = 'pwa-status-toast';
    toast.className = 'pwa-toast pwa-toast-' + (type || 'info');
    toast.innerHTML = '<span>' + msg + '</span>';

    document.body.appendChild(toast);

    setTimeout(function () {
      toast.classList.add('show');
    }, 50);

    setTimeout(function () {
      toast.classList.remove('show');
      setTimeout(function () {
        if (toast.parentNode) {
          toast.parentNode.removeChild(toast);
        }
      }, 300);
    }, 4000);
  }

  function showInstallPromptBanner() {
    if (document.getElementById('pwa-install-banner')) return;

    var banner = document.createElement('div');
    banner.id = 'pwa-install-banner';
    banner.className = 'pwa-install-banner';
    banner.innerHTML = `
      <div class="pwa-install-content">
        <div class="pwa-install-icon">
          <img src="${webRoot}assets/img/favicon/favicon-32x32.png" alt="Abacoos Logo" width="24" height="24">
        </div>
        <div class="pwa-install-text">
          <strong>Install Abacoos App</strong>
          <span>Faster access & standalone experience</span>
        </div>
      </div>
      <div class="pwa-install-actions">
        <button id="pwa-btn-install" class="pwa-btn-primary">Install</button>
        <button id="pwa-btn-dismiss" class="pwa-btn-dismiss" title="Dismiss">&times;</button>
      </div>
    `;

    document.body.appendChild(banner);

    // Fade in
    setTimeout(function () {
      banner.classList.add('visible');
    }, 200);

    // Event listeners
    document.getElementById('pwa-btn-install').addEventListener('click', function () {
      if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then(function (choiceResult) {
          if (choiceResult.outcome === 'accepted') {
            console.log('[PWA] User accepted the install prompt');
          }
          deferredPrompt = null;
          hideInstallPromptBanner();
        });
      }
    });

    document.getElementById('pwa-btn-dismiss').addEventListener('click', function () {
      // Dismiss for 7 days
      localStorage.setItem('abacoos_pwa_dismissed', Date.now() + 7 * 24 * 60 * 60 * 1000);
      hideInstallPromptBanner();
    });
  }

  function hideInstallPromptBanner() {
    var banner = document.getElementById('pwa-install-banner');
    if (banner) {
      banner.classList.remove('visible');
      setTimeout(function () {
        if (banner.parentNode) {
          banner.parentNode.removeChild(banner);
        }
      }, 300);
    }
  }

  // Inject PWA styles dynamically
  var pwaStyle = document.createElement('style');
  pwaStyle.textContent = `
    .pwa-toast {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: #e6e7ee;
      color: #44476A;
      padding: 12px 20px;
      border-radius: 12px;
      box-shadow: 6px 6px 12px #b8b9be, -6px -6px 12px #ffffff;
      font-size: 0.88rem;
      font-weight: 600;
      z-index: 99999;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      display: flex;
      align-items: center;
      gap: 10px;
      pointer-events: none;
    }
    .pwa-toast.show {
      opacity: 1;
      transform: translateY(0);
    }
    .pwa-toast-success { border-left: 4px solid #28a745; }
    .pwa-toast-warning { border-left: 4px solid #f0ad4e; }
    .pwa-toast-info { border-left: 4px solid #2D4CC8; }

    .pwa-install-banner {
      position: fixed;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%) translateY(40px);
      background: #e6e7ee;
      border-radius: 16px;
      padding: 12px 18px;
      box-shadow: 8px 8px 16px #b8b9be, -8px -8px 16px #ffffff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      z-index: 99998;
      opacity: 0;
      transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
      max-width: 90vw;
      width: 420px;
    }
    .pwa-install-banner.visible {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
    .pwa-install-content {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .pwa-install-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: #e6e7ee;
      box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .pwa-install-text {
      display: flex;
      flex-direction: column;
    }
    .pwa-install-text strong {
      font-size: 0.88rem;
      color: #31344B;
      font-weight: 700;
    }
    .pwa-install-text span {
      font-size: 0.75rem;
      color: #7e879b;
    }
    .pwa-install-actions {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .pwa-btn-primary {
      background: #e6e7ee;
      color: #2D4CC8;
      border: none;
      padding: 7px 16px;
      border-radius: 10px;
      font-size: 0.82rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #ffffff;
      transition: all 0.2s ease;
    }
    .pwa-btn-primary:active {
      box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff;
    }
    .pwa-btn-dismiss {
      background: transparent;
      border: none;
      color: #7e879b;
      font-size: 1.25rem;
      line-height: 1;
      padding: 4px 8px;
      cursor: pointer;
    }
    .pwa-btn-dismiss:hover {
      color: #31344B;
    }
  `;
  document.head.appendChild(pwaStyle);
})();
