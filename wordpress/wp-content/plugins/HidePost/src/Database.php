<?php

namespace HidePost;

class Database
{

    public static function add_rule(int $post_id, bool $hide) : int
    {
        global $wpdb;

        $wpdb->insert($wpdb->prefix . "hp_rules", array('post_id' => $post_id, 'hide_post' => intval($hide)));
        return $wpdb->insert_id;
    }

    public static function get_rules_for_id(int $post_id) : array
    {
        global $wpdb;

        $res = $wpdb->get_results("SELECT hide_post FROM " . $wpdb->prefix . "hp_rules WHERE post_id = " . $post_id);
        return $res;
    }

    public static function get_all_rules() : array
    {
	    global $wpdb;

	    $res = $wpdb->get_results("SELECT post_id FROM " . $wpdb->prefix . "hp_rules");
	    return $res;
    }

    public static function remove_rule(int $post_id) : void
    {
        global $wpdb;

        $wpdb->delete($wpdb->prefix . "hp_rules", array('post_id' => $post_id));
    }

    public static function initialize() : void
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE `{$wpdb->base_prefix}hp_rules` (
            id int NOT NULL AUTO_INCREMENT,
            post_id int NOT NULL,
            hide_post tinyint NOT NULL,
            PRIMARY KEY (id)    
        ) $charset_collate;";

        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public static function remove() : void
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->base_prefix . "hp_rules");
    }

}