# Roadmap

## High priority list

1. implement backgroundFetch API
2. make the custom pwa prompt optional and configurable. the user may choose to use the browser defaults.
3. merge javascript and css files using groups in order to leverage cache. for example we can merge common libraries in one bundle and other files which depend on the current page in another bundle
4. implement new manifest file [properties](https://developer.mozilla.org/en-US/docs/Web/Manifest)
5. customize image quality settings (jpeg image quality, jpeg optimization method)
6. improved LQIP for [jpeg files](https://www.smashingmagazine.com/2019/08/faster-image-loading-embedded-previews/)
7. better detect character encoding when manually editing the offline page HTML
8. modify service worker cache and network fallback and cache only to attempt an update after a specified time (it will behave like cache and network update with a delayed update)
9. [bug] When fetch remote scripts is off and a local copy is hosted locally, the local copy should not be used
10. [feature] Validate integrity data when the integrity attribute is provided for link and script before minifying / merging them together
11. Implement manual dns prefetch?
12. add support for the user action Log see [here](https://docs.joomla.org/J1.x:User_Action_Logs)
13. do not cache partial request?
14. intercept partial requests and return response from cache?
15. merge multiple google font < link > tag?
16. Fetch remote resources periodically (configurable) (css, javascript, fonts, ...). This can be usefull for analytic scripts and and hosted fonts.
17. Web push notifications with firebase?
18. prerender images using primitive.js svg generation [https://github.com/ondras/primitive.js/blob/master/js/app.js](https://github.com/ondras/primitive.js/blob/master/js/app.js)
19. Messaging API (broadcasting messages to and from all/single clients)
20. Remove < Link rel=preload > http header and use < link > HTML tag instead. see [here](https://jakearchibald.com/2017/h2-push-tougher-than-i-thought/)
21. CSS: deduplicate, merge properties, rewrite rules, etc
22. Disk quota management see [here](https://developer.chrome.com/apps/offline_storage) and [here](https://developer.mozilla.org/fr/docs/Web/API/API_IndexedDB/Browser_storage_limits_and_eviction_criteria) and [here](https://gist.github.com/ebidel/188a513b1cd5e77d4d1453a4b6d060b0)
23. Clear Site Data api see [here](https://www.w1.org/TR/clear-site-data/)
24. code refactoring: make helper properties protected or private and use wrapper methods instead
25. Implement expiring urls?

## Low priority list

1. handle < script nomodule > and < script type=module > ? see [here](https://developers.google.com/web/fundamentals/primers/modules)
1. Manage the service worker settings from the front end (notify when a new version is available, manually unregister, delete cache, etc ...)?
1. Manage user push notification subscription from the Joomla backend (link user to his Id, etc ...)?
1. Provide push notification endpoints (get user Id, notification clicked, notification closed, etc ...)
