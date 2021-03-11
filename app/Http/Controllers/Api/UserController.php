<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\User;

class UserController extends Controller
{
    public function login()
    {
        if (Auth::attempt(
            [
                'email' => request('email'),
                'password' => request('password')
            ]
        )) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['user'] = $user->name;

            return response()->json([
                'status'=>'success',
                'content'=>'thanh cong',
                'data'=>$success
            ],200);
        }
        else {
            return response()->json([
                'status'=>'error',
                'content'=>'that bai',
                'data'=>'Đăng nhập thất bại'
            ],401);
        }
    }  

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                // 'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'permission' => 'required',
                // 'c_password' => 'required|same:password',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status'=>'error',
                'content'=>'that bai',
                'data'=>$validator->errors()->all()
            ],401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        if($user){
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;
    
            return response()->json([
                'status'=>'success',
                'content'=>'thanh cong',
                'data'=>$success 
            ],200);
        }
        return response()->json([
            'status'=>'error',
            'content'=>'that bai',
            'data'=>'Đăng kí thất bại'
        ],401);
    }

    public function details()
    {
        $user = Auth::user();
        if($user){
            return response()->json([
                'status'=>'success',
                'content'=>'thanh cong',
                'data'=>$user
            ],200);
        }

    }
}
