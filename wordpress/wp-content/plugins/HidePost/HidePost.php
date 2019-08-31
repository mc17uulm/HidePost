<?php

/**
 * Plugin Name: HidePostWP
 * Description: The HidePost WordPress Plugin allows you to hide specific posts on your front and home page.
 * Author: mc17uulm
 * Author URI: https://github.com/mc17uulm/
 * Version: 0.1.1
 * Text Domain: hp_lang
 * Domain Path: /lang
 * License: MIT
 * License URI: https://github.com/mc17uulm/HidePost/blob/master/LICENSE
 * Tags: post, hide, site
 *
 * === Plugin Information ===
 *
 * Version: 0.1.1
 * Date: 31.08.2019
 *
 * If there are problems, bugs or errors, please report on GitHub: https://github.com/mc17uulm/HidePost
 *
 */

if(!defined('ABSPATH')) {
    exit;
}

add_action('pre_get_posts', function($query) {
    global $wpdb;

    $rules = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = '_hide_post_checkbox_front_page' AND meta_value = 'true'");
    if(count($rules) > 0) {
        if($query->is_front_page() || $query->is_home()) {
            $query->set('post__not_in', array_map(function($el) {
                return intval($el->post_id);
            }, $rules));
        }
    }
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
		function($post) {
            $is_active_front_page = get_post_meta($post->ID, '_hide_post_checkbox_front_page', true);
            wp_nonce_field('hide_post_update_metabox', 'hide_post_update_nonce');
            ?>
            <p>
                <label>
                    <input type="checkbox" name="hide_post_checkbox_front_page" value="true" <?= esc_attr($is_active_front_page) === "true" ? "checked='checked'" : ""; ?>>
                    <?= __('Hide on front page', 'hp_lang'); ?>
                </label>
            </p>
            <?php
        },
		'post',
		'normal',
		'default',
        array('__back_compat_meta_box' => true)
	);
});

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

add_action('init', function() {
    register_meta('post', "_hide_post_checkbox_front_page", array(
        "show_in_rest" => true,
        "type" => "string",
        "single" => "true",
        "sanitize_callback" => "sanitize_text_field",
        "auth_callback" => function() {
            return current_user_can('edit_posts');
        }
   ));
});

add_action('plugins_loaded', function() {
   load_plugin_textdomain('hp_lang', FALSE, basename(dirname(__FILE__)) . '/lang/');
});

