<?php
 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use App\Models\User;
 
class UserController extends Controller
{
    public function index()
    {
        $users = User::get(); 
    
        return view('user.index', ['users' => $users]);
    }
    public function activateUser($id)
    {
        // Find the user by id
        $user = User::findOrFail($id);
    
        // Update user status to active
        $user->status = 'active';
        $user->save();
    
        // Flash a success message to the session
        Session::flash('success', 'User activated successfully.');
    
        // Redirect back to the previous page
        return back();
    }

 
}