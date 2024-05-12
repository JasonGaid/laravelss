<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Create and save the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return a success response
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * Authenticate a user and generate a token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Attempt to authenticate the user
        if (auth()->attempt($request->only('email', 'password'))) {
            // Authentication successful, generate token
            $user = auth()->user();
            $token = $user->createToken('AuthToken')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user // Return user information
            ], 200);
        }
    
        // Authentication failed, return error response
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

        public function report($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->increment('report_count');
            return response()->json(['message' => 'User report count incremented successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to increment report count', 'error' => $e->getMessage()], 500);
        }
}

public function fetchReportCount($userId)
{
    try {
        // Retrieve the user from the database
        $user = User::findOrFail($userId);

        // Return the user's report count
        return response()->json(['report_count' => $user->report_count], 200);
    } catch (\Exception $e) {
        // Handle any exceptions (e.g., user not found)
        return response()->json(['error' => $e->getMessage()], 404);
    }
}

public function show($id)
{
    try {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['report_count' => $user->report_count], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to fetch user report count', 'message' => $e->getMessage()], 500);
    }
}

 /**
 * Get the status for the specified user.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function getBanStatus($id)
{
    try {
        // Find the user by ID
        $user = User::findOrFail($id);
        
        // Check if the user is banned
        if ($user->status === 'ban') {
            return response()->json(['message' => 'Your account is banned.'], 200);
        } else {
            return response()->json(['message' => 'Your account is active.'], 200);
        }
    } catch (\Exception $e) {
        // Handle the case where the user is not found
        return response()->json(['error' => 'User not found.'], 404);
    }
}


    
}

