/*

var CACHE_VERSION = 'app-v1';

var CACHE_FILES = [
  '/',
  'index.html',
  '/svg/be-background.svg',
  'app.js',
  'vendor.js',
  'styles.css',
  'styles.css.map',
  'service-worker.js',
];

// Chrome's currently missing some useful cache methods,
// this polyfill adds them.
// importScripts('serviceworker-cache-polyfill.js');

// Here comes the install event!
// This only happens once, when the browser sees this
// version of the ServiceWorker for the first time.
/* self.addEventListener('install', function(event) {
  // We pass a promise to event.waitUntil to signal how
  // long install takes, and if it failed
  event.waitUntil(
    // We open a cache…
    caches.open('simple-sw-v1').then(function(cache) {
      // And add resources to it
      return cache.addAll(CACHE_FILES);
    })
  );
});
*/
// The fetch event happens for the page request with the
// ServiceWorker's scope, and any request made within that
// page
// self.addEventListener('fetch', function(event) {
  // Calling event.respondWith means we're in charge
  // of providing the response. We pass in a promise
  // that resolves with a response object
//  event.respondWith(
    // First we look for something in the caches that
    // matches the request
/*
    if (event.request.url === '/') {
      event.respondWith(new Response("Hello world!"))
      return;
    }
*/
//    caches.match(event.request).then(function(response) {
      // If we get something, we return it, otherwise
      // it's null, and we'll pass the request to
      // fetch, which will use the network.
//      console.log('request is being hijacked...', event)
//      return response || fetch(event.request);
//    })
//  );
// });