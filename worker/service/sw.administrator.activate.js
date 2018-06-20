/**
 *
 * @package     GZip Plugin
 * @copyright   Copyright (C) 2005 - 2018 Thierry Bela.
 *
 * dual licensed
 *
 * @license     LGPL v3
 * @license     MIT License
 */

// @ts-check
/* global CACHE_NAME, SW */

self.addEventListener("activate", (event) => {
	// delete old app owned caches
	event.waitUntil(self.clients.claim());
});
