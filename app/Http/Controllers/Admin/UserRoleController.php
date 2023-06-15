<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_roles= UserRole::latest()->simplePaginate(100);
        menuSubmenu('user-roles','all-user-roles');
        return view('admin.user_role.index',compact('user_roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users=User::latest()->get();
        menuSubmenu('user-roles','create-user-roles');
        return view('admin.user_role.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'user_id'=>'required|numeric',
            'role_name'=>'required|string',
        ]);
//        return $request->all();
        UserRole::CreateUserRole($request);
        return redirect()->route('user-roles.index')->with('success','Successfully Created User Role');
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
    public function edit(string $id)
    {
//        return $id;
        $user_role=UserRole::find($id);
        $users=User::latest()->get();
        menuSubmenu('user-roles','all-user-roles');
        return view('admin.user_role.edit',compact(['user_role','users']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
//        return $request->all();
        $this->validate($request,[
            'user_id'=>'required|numeric',
            'role_name'=>'required|string',
//            'role_value'=>'required|string',
        ]);

        UserRole::UpdateUserRole($request,$id);
        return redirect()->route('user-roles.index')->with('success','Successfully Updated User Role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
//        return $id;
        UserRole::DestroyUser($id);
        return redirect()->back()->with('success','Successfully Deleted User');
    }
}
