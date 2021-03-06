<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;
use Hash;

class SocialiteAuthController extends Controller
{
    public function googleRedirect() { 

        try { 
            return Socialite::driver('google')->redirect();
        
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Facebook login authentication
     *
     * @return void
     */
    public function loginWithGoogle() {

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user       = User::where('google_id', $googleUser->id)->first();

            if($user){
                Auth::login($user);
                return redirect('/home');
            }

            else{
                $createUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'role_id' => 2,
                    'password' => Hash::make('123456')
                ]);

                Auth::login($createUser);
                return redirect('/home');
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}