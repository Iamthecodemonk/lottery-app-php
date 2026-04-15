const CACHE_NAME = "blueextra-lotto-v3";
const CORE_ASSETS = [
  "/lt/",
  "/lt/offline.html",
  "/lt/manifest.json",
  "/lt/admin",
  "/lt/admin/login",
  "/lt/admin/account",
  "/lt/agent",
  "/lt/agent/login",
  "/lt/agent/account",
  "/lt/public/assets/css/styles.css",
  "/lt/public/assets/js/app.js",
  "/lt/public/assets/js/platform.js",
  "/lt/public/assets/img/logo_1.png"
];

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches
      .open(CACHE_NAME)
      .then((cache) => cache.addAll(CORE_ASSETS))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches
      .keys()
      .then((keys) =>
        Promise.all(
          keys.map((key) => (key === CACHE_NAME ? null : caches.delete(key)))
        )
      )
      .then(() => self.clients.claim())
  );
});

self.addEventListener("fetch", (event) => {
  const { request } = event;
  if (request.method !== "GET") return;

  const url = new URL(request.url);
  if (url.origin !== self.location.origin) return;
  if (url.pathname.startsWith("/lt/api/")) return;

  if (request.mode === "navigate") {
    event.respondWith(
      fetch(request).catch(() => caches.match("/lt/offline.html"))
    );
    return;
  }

  event.respondWith(
    caches.match(request).then((cached) => {
      if (cached) return cached;
      return fetch(request).then((response) => {
        const cloned = response.clone();
        caches.open(CACHE_NAME).then((cache) => cache.put(request, cloned));
        return response;
      });
    })
  );
});
