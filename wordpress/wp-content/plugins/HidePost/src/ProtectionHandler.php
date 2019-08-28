<?php

namespace HidePost;

class ProtectionHandler
{

    public static function run($query) : void
    {
        $rules = Database::get_all_rules();
        if(count($rules) > 0) {
            echo "Rules:<br>";
            var_dump($rules);

            /*if($query->is_front_page() || $query->is_home()) {
                $query->set('post__not_in', $rules);
            }*/
        }
    }

}