<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Str;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function register(StoreUserRequest $request)
    {   
        $request->validated($request->all());
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),         
        ]);

        $this->generateSSHKeys($user);

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
       return Auth::user();
    }

   // Function to generate SSH keys for a user
   protected function generateSSHKeys(User $user)
   {
       // Generate a unique identifier for the user
       $identifier = Str::random(32);

       // Set the path where the SSH keys will be stored
       $path = storage_path("app/ssh-keys/{$identifier}");

       // Create the directory if it doesn't exist
       if (!file_exists($path)) {
           mkdir($path, 0777, true);
       }

       
       

       // Generate an OpenSSL key pair
       $config = [
           'private_key_bits' => 4096,
           'private_key_type' => OPENSSL_KEYTYPE_RSA,
       ];
       $resource = openssl_pkey_new($config);

       // Extract the private key
       openssl_pkey_export($resource, $privateKey);

       // Extract the public key
       $details = openssl_pkey_get_details($resource);
       $publicKey = $details['key'];

       // Save the keys in the user record
       $user->update([
           'public_key' => $publicKey,
           'private_key' => $privateKey,
           'public_key_path' => 'id_rsa.pub',
           'private_key_path' => 'id_rsa',
       ]);

       
   }



 
    
    

}
