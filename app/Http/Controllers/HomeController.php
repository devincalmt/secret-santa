<?php

namespace App\Http\Controllers;

use App\Models\SecretSanta;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showLoginForm()
    {
        $users = User::all();
        return view('login', compact('users'));
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|exists:users,name', // Pastikan nama ada di database
            'code' => 'required|string' // Pastikan code terisi
        ]);

        $user = User::where('name', $request->name)
                    ->where('code', $request->code)
                    ->first();

        if ($user) {
            return redirect()->route('dashboard', ['id' => $user->id]);
        }

        return back()->withErrors(['code' => 'Kode tidak sesuai dengan nama pengguna']);
    }

    // Redirect setelah login berhasil
    public function redirectAfterLogin($id)
    {
        $loggedInUser = User::find($id);
        $users = User::all();
        
        $receiver = $loggedInUser->givenSecretSanta->receiver;

        $receiverName = $receiver->name;

        $receiverWishlist = $receiver->wishlists;

        $myWishlists = $loggedInUser->wishlists;

        if ($loggedInUser) {
            // Logika setelah login, misalnya halaman dashboard
            return view('dashboard', compact('loggedInUser', 'users', 'receiverName', 'receiverWishlist', 'myWishlists'));
        }

        return abort(404); // Jika user tidak ditemukan
    }
}
