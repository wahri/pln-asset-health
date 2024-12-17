<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManajemenUsersController extends Controller
{
    public function index()
    {
        $users = User::all();



        return view('pages.manajemen-users.index', compact('users'));
    }
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'admin'
            ]);
            return back()->with('success', 'Data has been created successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'email' => 'unique:users,email,' . $id,
            ]);




            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->password) {
                $user->password = bcrypt($request->password);
            }

            $user->save();


            return back()->with('success', 'Data has been updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {

            User::destroy($id);
            return back()->with('success', 'Data has been deleted successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
