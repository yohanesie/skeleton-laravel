<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'       => User::count(),
            'roles'       => Role::count(),
            'permissions' => Permission::count(),
            'active'      => User::active()->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
