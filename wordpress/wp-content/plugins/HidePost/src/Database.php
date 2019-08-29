<?php

namespace HidePost;

class Database
{

    public static function get_all_rules() : array
    {
        global $wpdb;

        $res = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = '_hide_post_checkbox_front_page' AND meta_value = 'true'");
        return $res;
    }

}