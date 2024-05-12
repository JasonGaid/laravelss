<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\API\ViolationController;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private $violationController; // Instance variable for ViolationController

    // Constructor to initialize the ViolationController instance
    public function __construct(ViolationController $violationController)
    {
        $this->violationController = $violationController;
    }

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image upload
        ]);
    
        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                // Modify the image path to reflect the public URL
                $imagePath = 'storage/' . $imagePath;
            }
    
            // Create a new post
            $post = new Post();
            $post->fill($validatedData);
            $post->image = $imagePath; // Save modified image path
            $post->save();
    
            // Check for violations and report if necessary
            $this->violationController->checkAndReportViolations($validatedData['title'], $validatedData['content'], $validatedData['user_id']); // Call the method from ViolationController
    
            // Return success response with the URL of the image
            return response()->json(['message' => 'Post created successfully', 'image_url' => asset($imagePath)], 201);
        } catch (\Exception $e) {
            // Return error response if something went wrong
            return response()->json(['message' => 'Failed to create post', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Post $post)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'sometimes|string|max:255',
                'content' => 'sometimes|string',
                'category_id' => 'sometimes|integer|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            // If image is provided, handle image update separately
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($post->image) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $post->image));
                }
    
                // Store the new image
                $imagePath = $request->file('image')->store('images', 'public');
                // Modify the image path to reflect the public URL
                $validatedData['image'] = 'storage/' . $imagePath;
            }
    
            // Update the post with the validated data
            $post->update($validatedData);
    
            // Check for violations and report if necessary
            $this->violationController->checkAndReportViolations($post->title, $post->content, $post->user_id);
    
            // Get the updated post data from the database
            $post = $post->refresh();
    
            // Return the updated post data with the correct image URL
            return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Failed to update post: ' . $e->getMessage());
    
            // Return error response in case of any exception
            return response()->json(['message' => 'Failed to update post', 'error' => $e->getMessage()], 500);
        }
    }
    

    public function delete(Post $post)
    {
        try {
            $post->delete();
            // Return success response
            return response()->json(['message' => 'Post deleted successfully'], 200);
        } catch (\Exception $e) {
            // Return error response if something went wrong
            return response()->json(['message' => 'Failed to delete post', 'error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $posts = Post::with('user')->latest()->get(); // Fetch posts in descending order of creation
        return response()->json($posts);
    }
}
