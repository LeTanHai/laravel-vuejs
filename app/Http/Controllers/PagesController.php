<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Permissions;
use App\Role;

class PagesController extends Controller
{
    private $route_redirect;

    public function loginPage() {
        $data_init = [
            "errors" => [
                "email" => "",
                "password" => "",
                "all" => ""
            ],
            "fields_values" => [
                "email" => "",
                "password" => "",
            ],
            "url_post" => route("login_post")
        ];
        return view('login', ['data_init' => $data_init]);
    }
    
    public function loginPost(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role->id == 1) {
                return redirect()->route('admin_index');
            }
            return redirect()->route('user_index');
        }
        $data_init = [
            "errors" => [
                "email" => "",
                "password" => "",
                "all" => "pages.admin_login.errors.error_all_server"
            ],
            "fields_values" => [
                "email" => $request->email,
                "password" => $request->password,
            ],
            "url_post" => route("login_post")
        ];
        return view('login', ['data_init' => $data_init]);
    }

    public function adminIndex() {
        if (!Permissions::checkPermission('admin_index', $this->route_redirect)) {
            return redirect()->route($this->route_redirect);
        }
        return view("admin_index");
    }

    public function userIndex() {
        if (!Permissions::checkPermission('user_index', $this->route_redirect)) {
            return redirect()->route($this->route_redirect);
        }
        $data_init = [
            "id" => null,
            "type" => "none"
        ];
        return view("user_index", ['data_init' => $data_init]);
    }
}
