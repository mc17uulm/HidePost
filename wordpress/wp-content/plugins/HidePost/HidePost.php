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

use HidePost\ProtectionHandler;

add_action('pre_get_posts', function($query) {
   ProtectionHandler::run($query);
});

/*add_action('enqueue_block_editor_assets', function() {
	wp_enqueue_script(
		'hide-post-gutenberg',
		plugins_url('dist/hp_gutenberg.js', __FILE__),
		array('wp-plugins', 'wp-edit-post', 'wp-i18n', 'wp-element')
	);
});*/

add_action('add_meta_boxes', function() {
	add_meta_box(
		'hide_post_metabox',
		'Hide Post Plugin',
		'hide_post_metabox_render',
		'post',
		'normal',
		'default',
        array('__back_compat_meta_box' => true)
	);
});

function hide_post_metabox_render($post) {
    $is_active_front_page = get_post_meta($post->ID, '_hide_post_checkbox_front_page', true);
    wp_nonce_field('hide_post_update_metabox', 'hide_post_update_nonce');
	?>
	<p>
        <label>
            <input type="checkbox" name="hide_post_checkbox_front_page" value="true" <?= esc_attr($is_active_front_page) === "true" ? "checked='checked'" : ""; ?>>
            Hide on front page
        </label>
	</p>
	<?php
}

add_action('save_post', function($post_id, $post) {
   $edit_cap = get_post_type_object($post->post_type)->cap->edit_post;
   if(!current_user_can($edit_cap, $post_id)) {
       return;
   }
   if(!isset($_POST["hide_post_update_nonce"]) || !wp_verify_nonce($_POST["hide_post_update_nonce"], 'hide_post_update_metabox')){
       return;
   }
   update_post_meta(
       $post_id,
       '_hide_post_checkbox_front_page',
       sanitize_text_field($_POST['hide_post_checkbox_front_page'] ?? "false")
   );
}, 10, 2);

