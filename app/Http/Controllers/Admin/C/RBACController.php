<?php

/**
 * 权限管理
 */

namespace App\Http\Controllers\Admin\C;

use App\Permission;
use App\PermissionClassification;
use App\PermissionRole;
use App\Role;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RBACController extends Controller
{

    /**
     * 获取所有权限
     */
    public function getAllPermission()
    {
        return Permission::select('id', 'name', 'display_name', 'description', 'created_at')
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * 按name获取权限
     * @param $name
     * @return mixed
     */
    public function getPermissionByName($name)
    {
        return Permission::where('name', $name . '-%')
            ->select('id', 'name', 'display_name', 'description', 'created_at')
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * 按权限分类获取所有权限
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissionByClassification()
    {
        $permissionClassifications = PermissionClassification::all();
        $permissionList = array();
        foreach ($permissionClassifications as $permissionClassification) {
            $permissions = DB::table('pp_classifications')
                ->join('permissions', 'permissions.id', '=', 'permission_id')
                ->select(
                    'permissions.id',
                    'permissions.name',
                    'permissions.display_name',
                    'permissions.description',
                    'permissions.created_at'
                )
                ->where('pp_classifications.permission_classification_id', $permissionClassification->id)
                ->get();
            $item = null;
            $item['permissionClassification'] = $permissionClassification->name;
            $item['permissions'] = $permissions;
            array_push($permissionList, $item);
        }

        return response()->json($permissionList);

    }

    /**
     * 获取所有角色， 分页
     * @return mixed
     */
    public function index(Request $request)
    {
        return Role::select('id', 'name', 'display_name', 'description', 'created_at')
            ->paginate(10);
    }

    /**
     * 获取所有角色，不分页
     * @return mixed
     */
    public function getAllRoles()
    {
        return Role::select('id', 'name', 'display_name', 'description', 'created_at')
            ->get();
    }

    /**
     * 新增角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'permissionIds' => 'required',
        ]);

        $name = $request->input('name');
        $displayName = $request->input('display_name');
        $description = $request->input('description');
        $permissionIds = $request->input('permissionIds');

        // 权限id必须有
        if (sizeof($permissionIds) == 0) {
            return response()->json('permissionIds must!');
        }

        $role = new Role();
        $role->name = $name;
        $role->display_name = $displayName;
        $role->description = $description;
        $role->save();

        foreach ($permissionIds as $permissionId) {
            $permission = Permission::find($permissionId);
            if ($permission != null) {
                $role->attachPermission($permission);
            }
        }

        return response()->json($role->id);

    }

    /**
     * 获取待编辑的角色信息
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $role = Role::where('id', $id)
            ->select('id', 'name', 'display_name', 'description', 'created_at')
            ->first();
        if ($role == null) {
            return response()->json('role doesn\'t exist!');
        }
        $permissionIds = PermissionRole::where('role_id', $role->id)
            ->select('permission_id')
            ->get();
        $permissionIdsArray = array();
        foreach ($permissionIds as $permissionId) {
            array_push($permissionIdsArray, $permissionId->permission_id);
        }
        $role->permissionIds = $permissionIdsArray;
        return response()->json($role);
    }

    /**
     * 更新角色信息
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'display_name' => 'required',
            'permissionIds' => 'required',
        ]);

        $name = $request->input('name');
        $displayName = $request->input('display_name');
        $description = $request->input('description');
        $permissionIds = $request->input('permissionIds');

        // 不能重名
        $theSame = Role::where('name', $name)
            ->where('id', '<>', $id)
            ->first();
        if ($theSame != null) {
            return response()->json('The name has already been taken.');
        }


        // 权限id必须有
        if (sizeof($permissionIds) == 0) {
            return response()->json('permissionIds must!');
        }

        $role = Role::find($id);
        if ($role == null) {
            return response()->json('role doesn\'t exist!');
        }
        $role->name = $name;
        $role->display_name = $displayName;
        $role->description = $description;
        $role->save();

        PermissionRole::where('role_id', $role->id)
            ->delete();

        foreach ($permissionIds as $permissionId) {
            $permission = Permission::find($permissionId);
            if ($permission != null) {
                $role->attachPermission($permission);
            }
        }

        return response()->json('true');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {

        $deleted = DB::delete('delete from roles where roles.id = ?', [$id]);

        PermissionRole::where('role_id', $id)
            ->delete();

        RoleUser::where('role_id', $id)
            ->delete();

    }

    /**
     * 获取用户所拥有的所有的角色的id
     * @param $id
     * @return array
     */
    public function getUserRole($id)
    {
        $roles = RoleUser::where('user_id', $id)
            ->get();
        $roleIds = array();
        foreach ($roles as $role) {
            array_push($roleIds, $role->role_id);
        }
        return $roleIds;
    }

    /**
     * 用户绑定角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userBindRole(Request $request)
    {
        $userId = $request->input('userId');
        $roleIds = $request->input('roleIds');

        $user = User::find($userId);
        if ($user == null) {
            return response()->json('user doesn\'t exist');
        }

        // 获取对应的角色
        $roles = Role::whereIn('id', $roleIds)
            ->get();

        // 去掉原来所有的角色
        RoleUser::where('user_id', $userId)
            ->delete();

        // 添加新角色
        foreach ($roles as $role) {
            $user->attachRole($role);
        }

        return response()->json('true');

    }

}
