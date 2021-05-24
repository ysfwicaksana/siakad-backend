<?php

namespace App\Http\Controllers;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login(Request $request){
      
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422); 
        }

        $user = User::where('email',$request->email)->first();

        if($user){

            if(Hash::check($request->password, $user->password)){


                $pushRoles = [];
                $roles = User::where('email',$request->email)->first()->roles;
                foreach($roles as $role) {
                    array_push($pushRoles,$role->role);
                }

                $userData = [
                    'email' => $user->email,
                    'nama'  => $user->nama,
                    'level'  => $user->level,
                    'roles'  => implode("|",$pushRoles),
                    'iat' => Carbon::now(),
                    'exp' => Carbon::now()->addMinutes(120)
                ];

                $token = JWT::encode($userData,env('JWT_SECRET'));

                return response()->json([
                    'msg' => 'login success',
                    'token' => $token,
                    'user' => [
                        'email' => $user->email,
                        'nama' => $user->nama,
                        'level' => $user->level,
                        'exp' => $userData['exp'],
                        'roles' => implode("|",$pushRoles)
                    ]
                ],200); 
            } 

            return response()->json([
                'msg' => 'email atau password salah',
            ],400); 

        } else {
            return response()->json([
                'msg' => 'email atau password salah',
            ],400); 
        }

    }

    public function tes()
    {
        return response()->json([
            'msg' => 'tes',
        ],200); 
    }
}
