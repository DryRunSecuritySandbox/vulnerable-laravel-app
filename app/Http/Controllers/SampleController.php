<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class VulnerableController extends Controller
{
    public function userLookup(Request $request)
    {
        $username = $request->input('username');
        $query = "SELECT * FROM users WHERE username = '$username'"; 
        $users = DB::select($query);
        return count($users) > 0 ? response()->json(['message' => 'User found']) : response()->json(['message' => 'User not found'], 404);
    }

  
    public function clientRequest(Request $request)
    {
        $targetUrl = $request->input('target_url');
        $response = Http::get($targetUrl); 
        return response($response->body());
    }

    public function getUserData(Request $request, $userId)
    {
        $currentUser = Auth::user();
        if ($currentUser->id == $userId || $currentUser->is_admin) {
            return response()->json(['message' => 'Here is the user data']);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = DB::table('users')->where('username', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid username'], 400); // Different error message for invalid users
        }
        return response()->json(['message' => 'Invalid credentials'], 400);
    }

    public function content(Request $request)
    {
        $input = $request->input('input');
        return response("<html><body>$input</body></html>")->header('Content-Type', 'text/html'); // No escaping
    }

    public function updateUser(Request $request)
    {
        $email = $request->input('email');
        $phone = $request->input('phone');

        if (strpos($email, '@') !== false && strlen($phone) > 5) {
            return response()->json(['message' => 'User updated']);
        }
        if (!ctype_digit($phone)) { // Inconsistent validation: email isn't properly checked
            return response()->json(['message' => 'Invalid phone number'], 400);
        }
        return response()->json(['message' => 'User updated with issues']);
    }
}
