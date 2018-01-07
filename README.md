## Page Optimizer Plugin

This plugin is complementary to [HTML Minifier](/projects/WO/repos/html-minifier/) plugin. It performs advanced page optimizations which drastically improve the page performance score over various tools. Here are some of them:

# Known issue

It looks like subresources integrity is broken when service worker is enabled

# General improvements

* Sub-resources integrity check: computed for script and link (for now). see [here](https://hacks.mozilla.org/2015/09/subresource-integrity-in-firefox-43/)
* Push resources (require http 2 protocol). you can configure which resources will be pushed
* Efficiently cache resources using http caching headers. This requires apache mod_rewite. I have not tested on other web servers
* Range requests are supported for cached resources

# Javascript Improvements

* Fetch remote javascript files locally
* Merge javascript files
* Ignore javascript files that match a pattern
* Remove javascript files that match a pattern
* Move javascript at the bottom of the page

# CSS Improvements

* Fetch remote css files, images and fonts and store them locally
* Merge css files (this process @import directive)
* Do not process css files that match a pattern
* Remove css files that match a pattern
* Load css files in a non blocking way

# Critical CSS Path

See [here](https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery) for more info. The critical path enable instant page rendering by providing classes used to render the page before the stylesheets are loaded.
Any selector that affects the page rendering is a good candidate (set dimensions, define positioning, fonts, sections background color, etc..). There is no automatic extraction and you must provide these settings to extract css classes.

* CSS class definitions for critical css path
* A list of selectors to extract from the page css
* The web fonts are extracted automatically and preloaded

# Progressive Web App

Offline mode capabilities using one of these PWA network strategy

### Network cache strategies

0. Cache only (currently disabled in the settings page)
1. Network only
1. Cache first, falling back to network
1. Network first, falling back to cache
1. Cache, with network update - stale while revalidate <- this is the default

### PWA preloaded resources

You can provide the list of url to load when the service worker is installed like icons, logo, css files, web pages, etc ...

### Installable web app

1. The app can be installed as a standalone web app with google chrome on android via the menu “Menu / Add to home page”. You need to configure the manifest file and provide icons first.
2. The app can be installed as a standalone desktop application (tested on wndows 10) with google chrome as long as you provide a 512x512 icon.
3. Alternative links to native mobile apps can be provided and the preference can be configured

## Roadmap

1. Insert scripts and css that have 'data-position="head"' attribute in head instead of the footer
1. Investigate service worker and SRI issue
1. Service worker cache expiration api (using localforage or another lightweight indexDb library)
1. Background Sync see [here](https://developers.google.com/web/updates/2015/12/background-sync)
1. Messaging API (broadcasting messages to and from all/single clients)
1. Remove <Link rel=preload> http header and use <link> HTML tag instead. see [here](https://jakearchibald.com/2017/h2-push-tougher-than-i-thought/)
1. IMAGES: read this [here](https://kinsta.com/blog/optimize-images-for-web/)
1. IMAGES: Implement progressive images loading [here](https://jmperezperez.com/medium-image-progressive-loading-placeholder/)
1. IMAGES: Implement images delivery optimization see [here](https://www.smashingmagazine.com/2017/04/content-delivery-network-optimize-images/) and [here](https://developers.google.com/web/updates/2015/09/automating-resource-selection-with-client-hints)
1. IMAGES: Implement support for <pictures> element see [here](https://www.smashingmagazine.com/2013/10/automate-your-responsive-images-with-mobify-js/)
1. CORS for PWA:https://filipbech.github.io/2017/02/service-worker-and-caching-from-other-origins | https://developers.google.com/web/updates/2016/09/foreign-fetch | https://stackoverflow.com/questions/35626269/how-to-use-service-worker-to-cache-cross-domain-resources-if-the-response-is-404
1. CSS: deduplicate, merge properties, rewrite rules, etc
1. PWA: Web Push Notification. see [here](https://serviceworke.rs/web-push.html)
1. Disk quota management see [here](https://developer.chrome.com/apps/offline_storage) and [here](https://developer.mozilla.org/fr/docs/Web/API/API_IndexedDB/Browser_storage_limits_and_eviction_criteria) and [here](https://gist.github.com/ebidel/188a513b1cd5e77d4d1453a4b6d060b0)
1. Clear Site Data api see [here](https://www.w3.org/TR/clear-site-data/)

## May be implemented

These a low priority tasks.

1. Mobile apps deep link?
1. PWA: Deep links in pwa app or website. see [here](http://blog.teamtreehouse.com/registering-protocol-handlers-web-applications) and [here](https://developer.mozilla.org/en-US/docs/Web-based_protocol_handlers)
1. Integrate https://www.xarg.org/project/php-facedetect/ and https://onthe.io/learn/en/category/analytic/How-to-detect-face-in-image-with-PHP for better image optimization ?

## Change History

# V2.1

0. Added pwa manifest. The app is installable as a standalone application (tested on google chrome/android)

# V2.0

0. PWA: implement network strategies:

* Cache only (disabled)
* Network only
* Cache first, falling back to network
* Network first, falling back to cache
* Cache, with network update

# V1.1

0. CSS: preload web fonts
