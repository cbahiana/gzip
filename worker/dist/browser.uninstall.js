/* do not edit! */
/**
 * Service worker browser client uninstall
 * @package     GZip Plugin
 * @copyright   Copyright (C) 2005 - 2018 Thierry Bela.
 *
 * dual licensed
 *
 * @license     LGPL v3
 * @license     MIT License
 */
// @ts-check
// build a484bf1 2020-09-20 11:24:40-04:00
if ("serviceWorker" in navigator && navigator.serviceWorker.controller) {
    navigator.serviceWorker.getRegistration().then((function(registration) {
        registration.unregister().then((function(result) {
            if (result) {
                console.info("The service worker has been successfully removed 😭");
            }
        }));
    }));
}
