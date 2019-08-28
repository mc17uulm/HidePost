<?php

/**
 * Plugin Name: HidePost
 * Description: Hide Posts by simply setting a checkbox in the post edit site
 * Author: mc17uulm
 * Author URI: https://github.com/mc17uulm/
 * Version: 0.1
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Tags: post, hide, site
 *
 * === Plugin Information ===
 *
 * Version: 0.1
 * Date: 28.08.2019
 *
 */

if(!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . "/vendor/autoload.php";

use HidePost\Database;
use HidePost\ProtectionHandler;

register_activation_hook(__FILE__, function() {
    Database::initialize();
});

register_deactivation_hook(__FILE__, function() {
   Database::remove();
});

add_action('pre_get_posts', function($query) {
   ProtectionHandler::run($query);
});

add_action('enqueue_block_editor_assets', function() {
	wp_enqueue_script(
		'hide-post-gutenberg',
		plugins_url('dist/hp_gutenberg.js', __FILE__),
		array('wp-plugins', 'wp-edit-post', 'wp-i18n', 'wp-element')
	);
});

