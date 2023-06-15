<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::latest()->simplePaginate(100);
        menuSubmenu('users','all-users');
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        menuSubmenu('users','create-users');
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return $request->all();
        $this->validate($request,[
           'name'=>'required|string',
           'username'=>'required|string|regex:/^\S*$/u|unique:users,username',
           'email'=>'required|email|unique:users,email',
           'mobile'=>'nullable|string|unique:users,mobile',
           'password'=>'required|string|min:4',
        ]);
        User::UserCreate($request);
//        menuSubmenu('users','all-users');
        return redirect()->route('users.index')->with('success','Successfully Created User');
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
        $user=User::find($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
//        return $request->all();
        $this->validate($request,[
            'name'=>'required|string',
            'username'=>Rule::unique('users')->ignore(User::find($id)),
            'email'=>Rule::unique('users')->ignore(User::find($id)),
            'mobile'=>Rule::unique('users')->ignore(User::find($id)),
        ]);
//        return $request->all();
        User::UserUpdate($request,$id);
        return redirect()->route('users.index')->with('success','Successfully Updated User');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
//        return $id;
        User::DestroyUser($id);
        return redirect()->back()->with('success','Successfully Deleted');
    }
}
