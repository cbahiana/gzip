<?php

/**
 * @package     GZip Plugin
 * @subpackage  System.Gzip *
 * @copyright   Copyright (C) 2005 - 2018 Thierry Bela.
 *
 * dual licensed
 *
 * @license     LGPL v3
 * @license     MIT License
 */

namespace Gzip\Helpers;

use Gzip\GZipHelper;

class UrlHelper {

	/**
	 * perform url rewriting, distribute resources across cdn domains, generate HTTP push headers
	 * @param string $html
	 * @param array $options
	 * @return string
	 * @since 1.0
	 */
	public function postProcessHTML ($html, array $options = []) {

		$accepted = GZipHelper::accepted();
		$hashFile = GZipHelper::getHashMethod($options);

		$replace = [];
		$html = preg_replace_callback('#<!--.*?-->#s', function ($matches) use(&$replace) {

			$hash = '--ht' . crc32($matches[0]) . 'ht--';
			$replace[$hash] = $matches[0];

			return $hash;

		}, $html);

		$html = preg_replace_callback('#(<script(\s[^>]*)?>)(.*?)</script>#s', function ($matches) use(&$replace) {

			$hash = '--ht' . crc32($matches[3]) . 'ht--';
			$replace[$hash] = $matches[3];

			return $matches[1].$hash.'</script>';
		}, $html);

		$html = preg_replace_callback('#(<style(\s[^>]*)?>)(.*?)</style>#s', function ($matches) use(&$replace) {

			$hash = '--ht' . crc32($matches[3]) . 'ht--';
			$replace[$hash] = $matches[3];

			return $matches[1].$hash.'</style>';
		}, $html);

		// TODO: parse url() in styles
		$pushed = [];
		$types = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' && isset($options['h2push']) ? array_flip($options['h2push']) : [];

		$base = \JUri::root(true) . '/';

		$hashmap = array(
			'style' => 0,
			'font' => 1,
			'script' => 2
		);

		$checksum = !empty($options['checksum']) ? $options['checksum'] : false;

		$domains = [];

		$html = preg_replace_callback('#<([a-zA-Z0-9:-]+)\s([^>]+)>#s', function ($matches) use($checksum, $hashFile, $accepted, &$domains, &$pushed, $types, $hashmap, $base, $options) {

			$tag = $matches[1];
			$attributes = [];

			if (preg_match_all(GZipHelper::regexAttr, $matches[2],$attrib)) {

				foreach ($attrib[2] as $key => $value) {

					$attributes[$value] = $attrib[6][$key];
				}

				$url_attr = isset($options['parse_url_attr']) ? array_keys($options['parse_url_attr']) : ['href', 'src', 'srcset'];

				foreach ($url_attr as $attr) {

					if (isset($attributes[$attr]) && ($attr == 'srcset' || $attr == 'data-srcset')) {

						$return = [];

						foreach (explode(',', $attributes[$attr]) as $chunk) {

							$parts = explode(' ', $chunk);

							$name = trim($parts[0]);

							$return[] = (GZipHelper::isFile($name) ? GZipHelper::url($name) : $name).' '.$parts[1];
						}

						$attributes[$attr] = implode(',', $return);
					}

					if (isset($attributes[$attr]) && isset($options['parse_url_attr'][$attr])) {

						$file = GZipHelper::getName($attributes[$attr]);

						if (GZipHelper::isFile($file)) {

							$name = preg_replace('~[#?].*$~', '', $file);

							$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

							if (isset(GZipHelper::$static_types[$ext]) && empty($attributes['crossorigin'])) {

								$attributes['crossorigin'] = 'anonymous';
							}

							$push_data = empty($types) ? false : GZipHelper::canPush($name, $ext);

							if (!empty($push_data)) {

								if (!isset($types['all']) && (empty($push_data['as']) || empty($types[$push_data['as']]))) {

									unset($push_data);
								}

								else {

									if (isset($push_data['as']) && isset($hashmap[$push_data['as']])) {

										$push_data['score'] = $hashmap[$push_data['as']];
									} else {

										$push_data['score'] = count($hashmap);
									}

									$push_data['href'] = GZipHelper::getHost($file);
									$pushed[$base . $file] = $push_data;
								}
							}

							if (isset($accepted[$ext])) {

								unset($pushed[$base . $file]);

								$checkSumData = GZipHelper::getChecksum($name, $hashFile, $checksum, $tag == 'script' || ($tag == 'link' && $ext == 'css'));

								$file = GZipHelper::getHost(\JURI::root(true).'/'.GZipHelper::$route.GZipHelper::$pwa_network_strategy . $checkSumData['hash'] . '/' . $file);

								if (!empty($push_data)) {

									$push_data['href'] = $file;
									$pushed[$file] = $push_data;
								}

								$attributes[$attr] = $file ;

								if(!empty($checksum) && $checksum != 'none') {

									if ($tag == 'script' || ($tag == 'link' && $ext == 'css')) {

										$attributes['integrity'] = $checkSumData['integrity'];
										$attributes['crossorigin'] = 'anonymous';
									}
								}
							}
						}

						if (preg_match('#^(https?:)?(//[^/]+)#', $file, $domain)) {

							if (empty($domain[1])) {

								$domain[1] = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https:' : 'http:';
							}

							$domains[$domain[1].$domain[2]] = $domain[1].$domain[2];
						}

					}
				}
			}

			$result = '<'.$tag;

			foreach ($attributes as $key => $value) {

				$result .= ' '.$key.($value === '' ? '' : '="'.$value.'"');
			}

			return $result .'>';

		}, $html);

		//    $profiler->mark('end parse urls');

		//    $profiler->mark('push urls');

		if (!empty($pushed)) {

			usort($pushed, function ($a, $b) {

				if ($a['score'] != $b['score']) {

					return $a['score'] - $b['score'];
				}

				return $a['href'] < $b['href'] ? -1 : 1;
			});


			foreach ($pushed as $push) {

				$header = '';

				$file = $push['href'];

				unset($push['href']);
				unset($push['score']);

				foreach ($push as $key => $var) {

					$header .= '; ' . $key . '=' . $var;
				}

				// or use html <link rel=preload> -> remove header
				header('Link: <' . $file . '> ' . $header, false);
			}
		}

		if (!empty($domains)) {

			unset($domains[(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME']]);
			unset($domains['http://get.adobe.com']);

			if (!empty($domains)) {

				$replace['<head>'] = '<head><link rel="preconnect" crossorigin href="'.implode('"><link rel="preconnect" crossorigin href="', $domains).'">';
			}
		}

		if (!empty($replace)) {

			return str_replace(array_keys($replace), array_values($replace), $html);
		}

		return $html;
	}
}