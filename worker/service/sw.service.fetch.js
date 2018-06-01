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
/* global CACHE_NAME, CRY */

/**
 * @param {FetchEvent} event
 */

self.addEventListener("fetch", (event) => {
	const router = SW.route.getRouter(event);

	if (router != undef) {
		event.respondWith(
			router.handler.handle(event).catch((error) => {
				console.error(CRY, error);
				return fetch(event.request);
			})
		);
	}
	//	}
});
