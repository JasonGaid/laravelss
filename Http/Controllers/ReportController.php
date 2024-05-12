<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;


class ReportController extends Controller
{
    public function userReport()
    {
        try {
            $users = User::where('name', '<>', 'admin')->get(); // Retrieve users except admin
            return view('report.user_report', ['users' => $users]);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function postReport()
    {
        try {
            $posts = Post::withCount('comments')->get(); // Fetch posts with count of comments
            return view('report.post_report', ['posts' => $posts]);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }
    
}
