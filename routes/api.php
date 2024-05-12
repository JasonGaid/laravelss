<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\CommentController;
use Illuminate\Support\Facades\Storage;


/*  
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication routes
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

// Category routes
Route::get('/categories', [CategoryController::class, 'index']); // Fetch all categories

Route::post('/categories', [CategoryController::class, 'save']); // Add a new category
Route::get('/categories/{id}', [CategoryController::class, 'show']); // Fetch a single category by ID
Route::put('/categories/{id}', [CategoryController::class, 'update']); // Update an existing category
Route::delete('/categories/{id}', [CategoryController::class, 'delete']);

Route::post('create-post', [PostController::class, 'store']);
Route::get('/posts', [PostController::class, 'index']);
Route::put('/posts/{post}', [PostController::class, 'update']);
Route::delete('/posts/{post}', [PostController::class, 'delete']);

Route::prefix('api')->group(function () {
    Route::post('/posts/{postId}/report-violation', [PostController::class, 'reportViolation'])
        ->name('posts.reportViolation');
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('posts/{post}/violations', [ViolationController::class, 'reportViolation']);


Route::get('/images/{filename}', function ($filename) {
    $path = storage_path('app/images/' . $filename);

    if (!Storage::exists($path)) {
        abort(404);
    }

    $file = Storage::get($path);
    $type = Storage::mimeType($path);

    return response($file, 200)->header('Content-Type', $type);
});
Route::post('/posts/{postId}/comments', [CommentController::class, 'store']);
Route::get('posts/{postId}/comments', function ($postId) {
    $commentController = new CommentController();
    return $commentController->getPostComments($postId);
});


Route::put('/comments/{commentId}', [CommentController::class, 'update']);
Route::delete('/comments/{commentId}', [CommentController::class, 'destroy']);

Route::resource('users', UserController::class)->only([
    'index', 'show'
]);

Route::get('/users/{user}/report-count', [UserController::class, 'fetchReportCount']);
Route::get('/users/{id}/ban-status', [UserController::class, 'getBanStatus']);
