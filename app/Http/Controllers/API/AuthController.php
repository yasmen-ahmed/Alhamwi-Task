<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);
    
            if($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'Registration successful'], 201);

        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
        
    }

 
    
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
    
        if ($request->input('device') === 'on') {
            DB::table('users')->where('email', $request->input('email'))->update(['session_id' => null]);
        }
    
        $user = DB::table('users')->where('email', $request->input('email'))->first();
    
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $newSessId = Session::getId();
    
            if ($user->session_id != '') {
                $lastSession = Session::getHandler()->read($user->session_id);
    
                if ($lastSession) {
                    Auth::logout();
                    return response()->json(['error' => 'This user is logged in from another device.'], 401);
                }
            }
    
            DB::table('users')->where('id', $user->id)->update(['session_id' => $newSessId]);
    
            $user = Auth::user();
    
            return response()->json(['data' => $user]);
        }
    
        return response()->json(['error' => 'Your email and password are incorrect.'], 401);
    }

}
