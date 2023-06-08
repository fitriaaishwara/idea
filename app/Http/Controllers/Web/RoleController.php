<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Data Role|Create Role|Edit Role|Delete Role', ['only' => ['index']]);
        $this->middleware('permission:Create Role', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Role', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('pages.role.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $Role = Role::with(['permissions'])
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Role::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->get();

        $RoleCounter = Role::when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%' . $keyword . '%');
        })
            ->count();
        $response = [
            'status'          => true,
            'code'            => '',
            'message'         => '',
            'draw'            => $request['draw'],
            'recordsTotal'    => Role::count(),
            'recordsFiltered' => $RoleCounter,
            'data'            => $Role,
        ];
        return $response;
    }
    public function create()
    {
        $permissions = Permission::orderBy('id', 'ASC')->get();

        $groupPermission = [];
        foreach ($permissions as $row) {
            $groupName = $row->group_permission;
            $groupPermission[$groupName][] = $row;
        }
        return view('pages.role.create', compact('groupPermission'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Role failed to create'];
            $createRole = Role::create([
                'name'          => $request['name'],
                'description'   => $request['description'],
                'guard_name'    => 'web',
            ]);

            $createPermissionToRole = $createRole->syncPermissions($request->permission);
            if ($createPermissionToRole) {
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Role Successfully created'];
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }

        return $data;
    }
    public function edit($id)
    {
        $role = Role::findById($id);
        $permissions = Permission::orderBy('id', 'ASC')->get();

        $groupPermission = [];
        foreach ($permissions as $row) {
            $groupName = $row->group_permission;
            $groupPermission[$groupName][] = $row;
        }

        $hasPermission = DB::table('role_has_permissions')
            ->select('permission_id')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_id', $id)->pluck('permission_id')->all();

        return view('pages.role.edit', compact('role', 'groupPermission', 'hasPermission'));
    }
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Role failed to update'];
            $role              = Role::findById($id);
            $role->name        = $request->name;
            $role->description = $request->description;
            $role->save();

            $createPermissionToRole = $role->syncPermissions($request->permission);
            if ($createPermissionToRole) {
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Role updated successfully'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Role failed to delete'];

            $delete = Role::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Role deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
