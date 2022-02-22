<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function signUpForm()
    {
        $user = Auth::user();

        $initialLikelihood = $user->likelihood ?? null;
        $initialFriends = $user->friends ?? "";

        return Inertia::render('User/SignUp', compact("initialLikelihood", "initialFriends"));
    }

    public function signUp(Request $request)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $validated = $request->validate([
            "likelihood" => "required|numeric|min:1|max:3",
            "friends" => "",
        ]);

        $user = Auth::user();

        if ($user->signed_up) {
            session()->flash('flash', [
                'type' => 'success',
                'text' => "Signup edited!",
            ]);
        } else {
            session()->flash('flash', [
                'type' => 'success',
                'text' => "Successfully signed up!",
            ]);
        }

        $user->likelihood = $validated["likelihood"];
        $user->friends = $validated["friends"];
        $user->signed_up = true;
        $user->save();


        return redirect()->route("home");
    }
}
