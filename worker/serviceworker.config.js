/**
 *
 * main service worker file
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
/* eslint wrap-iife: 0 */
/* global SW, scope, undef */
/** @var {string} scope */
/** @var {SWType} SW */

"use strict;";

// do not cache administrator content -> this can be done in the plugin settings / joomla addministrator
//SW.Filter.addRule(SW.Filter.Rules.Prefetch, function(request) {
//	return request.url.indexOf(scope + "/administrator/") != -1;
//});

//const excluded = "{exclude_urls}";

const strategies = SW.strategies;
const Router = SW.Router;
const route = SW.route;
const cacheExpiryStrategy = "{cacheExpiryStrategy}";
let entry;
let option;

let defaultStrategy = "{defaultStrategy}";

// excluded urls fallback on network only
for (entry of "{exclude_urls}") {
	route.registerRoute(
		new Router.RegExpRouter(new RegExp(entry), strategies.get("no"))
	);
}

// excluded urls fallback on network only
for (entry of "{network_strategies}") {
	option = entry[2] || cacheExpiryStrategy;

	//	console.log({option});

	route.registerRoute(
		new Router.RegExpRouter(
			new RegExp(entry[1], "i"),
			strategies.get(entry[0]),
			option == undef
				? option
				: {plugins: [new SW.expiration.CacheExpiration(option)]}
		)
	);
}

// register strategies routers
for (entry of strategies) {
	route.registerRoute(
		new Router.ExpressRouter(
			scope + "{ROUTE}/media/z/" + entry[0] + "/",
			entry[1]
		)
	);
}

if (!strategies.has(defaultStrategy)) {
	// default browser behavior
	defaultStrategy = "no";
}

route.setDefaultRouter(
	new Router.ExpressRouter("/", strategies.get(defaultStrategy))
);
