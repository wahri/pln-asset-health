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


            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return back()->with('success', 'Data has been created successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;

            if($request->password) {
                $user->password = bcrypt($request->password);
            }

            $user->save();
            
          
            return back()->with('success', 'Data has been updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong!');
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
