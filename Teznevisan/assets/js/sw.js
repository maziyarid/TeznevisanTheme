/* ====================================
   Teznevisan Service Worker
   Progressive Web App Caching
   ==================================== */

const CACHE_VERSION = 'teznevisan-v1';
const CACHE_URLS = [
    '/',
    '/index.html',
    '/about.html',
    '/services.html',
    '/contact.html',
    '/assets/css/main.css',
    '/assets/css/components.css',
    '/assets/css/animations.css',
    '/assets/css/responsive.css',
    '/assets/js/main.js',
    '/assets/js/components.js',
    '/assets/images/logo.webp',
    '/assets/fonts/iransans/woff2/IRANSansWeb.woff2'
];

// Install event - cache resources
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_VERSION)
            .then((cache) => {
                console.log('Opened cache');
                return cache.addAll(CACHE_URLS);
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event - clean old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_VERSION) {
                        console.log('Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                // Cache hit - return response
                if (response) {
                    return response;
                }

                // Clone the request
                const fetchRequest = event.request.clone();

                return fetch(fetchRequest).then((response) => {
                    // Check if valid response
                    if (!response || response.status !== 200 || response.type !== 'basic') {
                        return response;
                    }

                    // Clone the response
                    const responseToCache = response.clone();

                    caches.open(CACHE_VERSION)
                        .then((cache) => {
                            cache.put(event.request, responseToCache);
                        });

                    return response;
                });
            })
            .catch(() => {
                // Offline fallback
                return caches.match('/offline.html');
            })
    );
});
