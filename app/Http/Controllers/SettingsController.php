<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SettingsController extends Controller
{
    public function index(){
       return view('pages.settings.index');
    }
    public function updateAccount(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),  // Pastikan email unik kecuali untuk user yang sedang login
            'password' => 'required|min:8|confirmed',  // Pastikan password minimal 8 karakter dan dikonfirmasi
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Update email
        $user->email = $request->email;

        // Update password (di-hash)
        $user->password = Hash::make($request->password);

        // Simpan perubahan
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Your account has been updated successfully.');
    }
}
