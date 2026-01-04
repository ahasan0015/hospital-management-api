<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'success'=>true,
            'users'=> $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // ✅ Validation
        $request->validate([
            'fname'    => 'required|string|max:255',
            'lname'    => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|min:6',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role_id'  => 'required|integer',
            'status'   => 'required|in:active,inactive',
        ]);

        // ✅ Image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/users'), $imageName);
        }

        // ✅ Create User
        $user = User::create([
            'fname'    => $request->fname,
            'lname'    => $request->lname,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'image'    => $imageName,
            'role_id'  => $request->role_id,
            'status'   => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user'    => $user
        ], 201);
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   $users = User::find($id);

        if($users){
            return response()->json([
                'success' => true,
                'user' => $users
            ]);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Users not found'
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'error' =>true,
                'message' => 'User not found'
            ],404);
        }else{
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User deleted Successfully'
            ]);
        }
    }
}
