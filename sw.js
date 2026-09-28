const CACHE_NAME = 'abacoos-pwa-v1';
const OFFLINE_URL = 'offline.html';

// Pre-cached critical assets
const PRECACHE_ASSETS = [
  './',
  'offline.html',
  'manifest.json',
  'assets/img/favicon/favicon-32x32.png',
  'assets/img/favicon/android-chrome-192x192.png',
  'assets/img/favicon/android-chrome-512x512.png',
  'assets/img/favicon/apple-touch-icon.png',
  'css/neumorphism.css',
  'css/style.css',
  'assets/js/neumorphism.js',
  'vendor/jquery/dist/jquery.min.js'
];

// Install Event - Pre-cache core shell & offline page
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      // Use catch for individual items to avoid entire install failing if a single resource is missing
      return Promise.allSettled(
        PRECACHE_ASSETS.map((url) =>
          cache.add(url).catch((err) => {
            console.warn('[SW] Could not precache resource:', url, err);
          })
        )
      );
    }).then(() => self.skipWaiting())
  );
});

// Activate Event - Clean up stale cache versions
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames
          .filter((name) => name !== CACHE_NAME)
          .map((name) => caches.delete(name))
      );
    }).then(() => self.clients.claim())
  );
});

// Fetch Event - Dynamic routing strategy
self.addEventListener('fetch', (event) => {
  const request = event.request;

  // 1. Only process GET requests (POST, PUT, DELETE should never be intercepted or cached)
  if (request.method !== 'GET') {
    return;
  }

  // 2. Ignore browser extension or non-http/https schemes
  if (!request.url.startsWith('http')) {
    return;
  }

  const url = new URL(request.url);

  // 3. Navigation requests (HTML pages) -> Network-First with Offline Fallback
  if (request.mode === 'navigate' || request.headers.get('accept')?.includes('text/html')) {
    event.respondWith(
      fetch(request)
        .then((networkResponse) => {
          return networkResponse;
        })
        .catch(async () => {
          // Fall back to pre-cached offline page
          const cache = await caches.open(CACHE_NAME);
          const cachedOffline = await cache.match(OFFLINE_URL) || await cache.match('./offline.html');
          if (cachedOffline) {
            return cachedOffline;
          }
          return new Response('You are offline. Please reconnect to continue.', {
            status: 503,
            statusText: 'Service Unavailable',
            headers: { 'Content-Type': 'text/plain' }
          });
        })
    );
    return;
  }

  // 4. Static assets (Images, CSS, JS, Fonts, Favicons) -> Stale-While-Revalidate
  const isStaticAsset =
    url.pathname.endsWith('.css') ||
    url.pathname.endsWith('.js') ||
    url.pathname.endsWith('.png') ||
    url.pathname.endsWith('.jpg') ||
    url.pathname.endsWith('.jpeg') ||
    url.pathname.endsWith('.svg') ||
    url.pathname.endsWith('.ico') ||
    url.pathname.endsWith('.woff2') ||
    url.pathname.endsWith('.woff');

  if (isStaticAsset) {
    event.respondWith(
      caches.match(request).then((cachedResponse) => {
        const fetchPromise = fetch(request)
          .then((networkResponse) => {
            if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
              const responseToCache = networkResponse.clone();
              caches.open(CACHE_NAME).then((cache) => {
                cache.put(request, responseToCache);
              });
            }
            return networkResponse;
          })
          .catch(() => cachedResponse);

        return cachedResponse || fetchPromise;
      })
    );
    return;
  }

  // 5. Default: Network with Cache Fallback
  event.respondWith(
    fetch(request).catch(() => caches.match(request))
  );
});
