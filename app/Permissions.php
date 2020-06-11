<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class Permissions {
    static private $list_permissions = [
        "admin_index" => [
            "roles" => [1],
            "route_redirect_error" => "login_page"
        ],
        "user_index" => [
            "roles" => [2],
            "route_redirect_error" => "login_page"
        ]
    ];
    static function checkPermission($name_page, &$route_redirect) {
        if (!Auth::check()) {
            $route_redirect = 'login_page';
            return false;
        }
        if (!self::$list_permissions["{$name_page}"]) {
            $route_redirect = 'login_page';
            return false;
        }
        $role_id = Auth::user()->role_id;
        foreach(self::$list_permissions["{$name_page}"]['roles'] as $roleItem) {
            if (intval($roleItem) === $role_id) {
                return true;
            }
        }
        $route_redirect = 'login_page';
        return false;
    }
}