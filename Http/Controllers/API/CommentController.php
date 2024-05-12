<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
{
    Log::info('Request data:', $request->all());
    
    $validator = Validator::make($request->all(), [
        'post_id' => 'required|exists:posts,id', // Validate post_id
        'content' => 'required|string',
        'user_id' => 'required|exists:users,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $post = Post::find($postId);

    if (!$post) {
        return response()->json(['error' => 'Post not found'], 404);
    }

    $comment = new Comment();
    $comment->post_id = $postId; // Assign post_id
    $comment->content = $request->input('content');
    $comment->user_id = $request->input('user_id');

    // Save the comment
    $post->comments()->save($comment);

    return response()->json(['message' => 'Comment added successfully'], 201);
}

public function getPostComments($postId)
{
    try {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $comments = $post->comments()->with('user')->get(); // Assuming you have a 'user' relationship in your Comment model

        return response()->json(['comments' => $comments], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to fetch comments', 'error' => $e->getMessage()], 500);
    }
}

public function update(Request $request, $commentId)
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        // You can perform additional checks if required, e.g., user authorization

        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $comment->content = $request->input('content');
        $comment->save();

        return response()->json(['message' => 'Comment updated successfully'], 200);
    }

public function destroy($commentId)
{
    try {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete comment', 'message' => $e->getMessage()], 500);
    }
}
}





