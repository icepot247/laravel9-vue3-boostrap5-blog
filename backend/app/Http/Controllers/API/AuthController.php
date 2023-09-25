<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $messages) {
                return $this->sendError(901, $messages[0]);
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        return $this->sendSuccess('Registration successfully done.', [ 'token' => $user->getToken($user), 'token_type' => 'Bearer', 'user' => $user ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $messages) {
                return $this->sendError(901, $messages[0]);
            }
        }elseif (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError(901, 'Invalid user access information');
        }else{
            $user = User::where('email', $request['email'])->firstOrFail();
            return $this->sendSuccess('Login successfully done.', [ 'token' => $user->getToken($user), 'token_type' => 'Bearer', 'user' => $user ]);
        }
    }

    public function profile(Request $request)
    {
        try{
//            $user = auth()->user();
            $user = $request->user()->data();
            return $this->sendSuccess('Data found.', $user);
        }catch (\Exception $e){
            return $this->sendError(99, 'Something went wrong. Please try again later', $e->getMessage());
        }

    }

    public function logout(Request $request)
    {
        try{
            $request->user()->tokens()->where('id',  auth()->user()->currentAccessToken()->id)->delete();
            //auth()->user()->tokens()->where('tokenable_id',  auth()->user()->id)->delete();
            return $this->sendSuccess('You have successfully logged out and the token was successfully deleted.', []);
        }catch (\Exception $e){
            return $this->sendError(99, 'You have successfully logged out and the token was successfully deleted', $e->getMessage());
        }
    }

}
