/**
 *
 * main service worker file
 * @package     GZip Plugin
 * @copyright   Copyright (C) 2005 - 2018 Thierry Bela.
 *
 * dual licensed
 *
 * @license     LGPL v3
 * @license     MIT License
 */

// @ts-check

/*  */

// build build-id build-date
/* eslint wrap-iife: 0 */
/* global */
// validator https://www.pwabuilder.com/
// pwa app image generator http://appimagegenerator-pre.azurewebsites.net/

"use strict;";
"{IMPORT_SCRIPTS}";

const undef = null; //

/**
 *
 * @var {SWType}
 */
const SW = Object.create(undef);
const CACHE_NAME = "{CACHE_NAME}";
const CRY = "😭";
const scope = "{scope}";
// const defaultStrategy = "{defaultStrategy}";

//console.log(self);
