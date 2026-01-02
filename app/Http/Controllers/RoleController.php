<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * @method void middleware(string|array $middleware, array $options = [])
 */

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:View roles', ['only' => ['index']]);
        $this->middleware('permission:Create roles', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Give permissions roles', ['only' => ['addPermissionToRole', 'givePermissionToRole']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::get();

        return view('spatie.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('spatie.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Rol Creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {

        return view('spatie.role.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,' . $role->id
            ]
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Rol Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addPermissionToRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::get();

        // $rolePermissions = DB::table('role_has_permissions')
        // ->where('role_has_permissions.role_id',$role->id)
        // ->pluck('role_has_permissions_id','role_has_permissions'.'permission_id')
        // ->all();

        $rolePermissions = $role->permissions->pluck('id')->toArray();


        return view('spatie.role.add-permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    public function givePermissionToRole(Request $request, $roleId)
    {

        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);

        $role->syncPermissions($request->permission);



        return redirect()->back()->with('status', 'Permiso agregado al Rol ' . $role->name);
    }
}
