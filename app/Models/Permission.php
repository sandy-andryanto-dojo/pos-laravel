<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission {

    public static function defaultPermissions(){
        $result = array();
        $modules = [
           "dashboards",
           "brands",
           "categories",
           "customers",
           "suppliers",
           "types",
           "users",
           "roles",
           "products",
           "sales",
           "purchases",
           "reports",
           "profiles"
        ];
        asort($modules);
        $actions = ["view", "add", "edit", "delete"];
        foreach($modules as $m){
            foreach($actions as $a){
                $result[] = $a."_".$m;
            }
        }
        return $result;
    }

 }