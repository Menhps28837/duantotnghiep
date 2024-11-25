<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Redirect;
class GoogleLoginController extends Controller {
    public function redirectToGoogle(): RedirectResponse  {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(): RedirectResponse {
        $user = Socialite::driver('google')->user();
        $existingUser = User::where('google_id', $user->id)->first();
        if ($existingUser) { // Log in the existing user.
            auth()->login($existingUser, true);
            $ability = ['web'];
        } else { // Create a new user.
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->google_id = $user->id;
            $newUser->password = bcrypt(Str::random()); // Set some random password
            $newUser->save();
            // Log in the new user.
            auth()->login($newUser, true);
            $ability = ['web'];
        }
        return Redirect::to('http://127.0.0.1:8000/');
    }


    // public function handleGoogleCallback()
    // {
    //     $user = Socialite::drive('google')->user();
    //     $users = User::where("google_id",$user->id)->first();
    //     if(empty($users)){
    //         Auth::login($users);
    //         return redirect('home');
    //     }else{
    //         $users = User::create([
    //             "name" => $user->name,
    //             "email" => $user->email,
    //             "google_id" => $user->google_id,
    //         ]);
    //         Auth::login($users);
    //         return redirect('home');
    //     }
    // }
}