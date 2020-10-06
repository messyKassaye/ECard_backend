<?php

namespace App\Api\V1\Controllers;

use Config;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Role;
use Auth;
class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        if($request->role_id == 1){
            return response()->json(['status'=>false,
                'message'=>"We don't have role with id 1. We provide role id for Agent=3 and Retailer=4. please choose your role"]);
        }else{
            $userCheck = User::where('email', $request->email)->get();
            $phoneChecker = User::where('phone', $request->phone)->get();
            if (count($userCheck) <= 0 && count($phoneChecker) <= 0) {
 
                $user = new User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->user_name = 'messy123';
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = $request->password;
                if($user->save()){
                    $role = Role::find($request->role_id);
                    $user->role()->sync($role);
 
                    //login after sign up
                    $credentials = $request->only(['email', 'password']);
                    $token = Auth::guard()->attempt($credentials);
                    $role_id = User::find(Auth::guard()->user()->id)->role[0];
                    return response()->json([
                        'status' => true,
                        'role'=>$role_id,
                        'token' => $token
                    ], 201);
                }
 
            } else {
                if (count($userCheck) > 0) {
                    //throw new HttpException(409);
                    return response()->json(['status' => false, 'message' => 'Some one already registered by this email address'], 409);
                } else if (count($phoneChecker) > 0) {
                    return response()->json(['status' => false, 'message' => 'Some one already registered by this Phone number'], 409);
                } else {
                    return response()->json(['status' => false, 'message' => 'these email address and phone number are used by some one'], 409);
                }
            }
        }
 
    }
}
