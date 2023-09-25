<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {

        $user = auth()->user();

        $email = $user->email;

        DB::table('users')->where('email', $email)->update(['session_id' => null]);

        Session::flush();

        auth()->logout();

        return redirect('/login');
    }
}
