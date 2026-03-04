<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
   
    public function index()
    {
        $permissions = Permission::orderBy('group')->orderBy('label')->paginate(20);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $groups = Permission::distinct()->pluck('group')->filter()->sort()->values();
        return view('admin.permissions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:100', 'unique:permissions,name', 'regex:/^[a-z_.]+$/'],
            'label' => ['required', 'string', 'max:100'],
            'group' => ['nullable', 'string', 'max:100'],
        ]);

        Permission::create($data);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        $groups = Permission::distinct()->pluck('group')->filter()->sort()->values();
        return view('admin.permissions.edit', compact('permission', 'groups'));
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:100', Rule::unique('permissions')->ignore($permission), 'regex:/^[a-z_.]+$/'],
            'label' => ['required', 'string', 'max:100'],
            'group' => ['nullable', 'string', 'max:100'],
        ]);

        $permission->update($data);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
