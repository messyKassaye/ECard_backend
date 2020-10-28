<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;
use App\User;
class LoginController extends Controller
{
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['phone', 'password']);

        try {
            $token = Auth::guard()->attempt($credentials);

            if(!$token) {
                throw new AccessDeniedHttpException();
                //return  response()->json(['status'=>false,'message'=>'Unauthorized user.incorrect email or password is used']);
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        $role_id = User::find(Auth::guard()->user()->id)->role[0];
        return response()
            ->json([
                'status' => true,
                'role'=>$role_id,
                'token' => $token,
                'expires_in' => Auth::guard()->factory()->getTTL() * 60
            ]);

    }
}
