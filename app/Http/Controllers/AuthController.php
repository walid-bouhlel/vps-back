<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Str;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\OpenStackService;

class AuthController extends Controller
{
    //
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        

       $request->validated($request->all());
       
       if(!Auth::attempt($request->only(['email','password'])))
       {
           return $this->error('','Credentials do not match',401);
       }
      $user = User::where('email',$request->email)->first();
        return $this->succes([
             'user'=> $user,
             'token' => $user->createToken('Api token of '. $user->name)->plainTextToken
            ]);
      
    }

    public function register(StoreUserRequest $request, OpenStackService $openStackService)
    {   
        $request->validated($request->all());
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),         
        ]);

        $keyPair = $openStackService->createKeyPair('vpsuser'.$user->id);
        $user->saveKeyPairInformation($keyPair);

        

        return $this->succes([
            'user' => $user,
            'token' => $user-> createToken('API token of'. $user->name)->plainTextToken
        ]);
    }

    public function logout()
    {
      // Revoke the token that was used to authenticate the current request...
        Auth::user()->currentAccessToken()->delete();
        return $this->succes([
            'message'=>'You have successfully been logout'
        ]);
      return response()->json('this is my logout method');
    }

    public function check()
    {
       //return Auth::user();
       $user=Auth::user();
       return $this->succes([
        'user'=> $user,
        'token' => str_replace('Bearer ','',apache_request_headers()['Authorization'])
       ]);
    }

}
