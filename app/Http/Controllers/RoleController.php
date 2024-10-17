<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\role\StoreRoleRequest;
use App\Http\Requests\role\UpdateRoleRequest;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::latest('id')->paginate(5);

        return view('admin.pages.roles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $data = $request->all();
        // dd($data);
        try {
            Role::query()->create($data);

            return back()->with('success', 'Thêm mới vai trò thành công');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Thêm mới vai trò thất bại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.pages.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $request->all();
        // dd($data);
        try {
            $role->update($data);

            return back()->with('success', 'Cập nhật vai trò thành công');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Cập nhật vai trò thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();

            return back()->with('success', 'Xoá vai trò thành công');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Xoá vai trò thất bại');
        }
    }
}
