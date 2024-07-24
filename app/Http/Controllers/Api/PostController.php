<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

        $data['posts'] = Post::all();

        // Return successful response
        return response()->json([
            'status' => true,
            'message' => 'All post data !',
            'post' => $data
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Failed to retrieve posts',
            'error' => $e->getMessage()
        ], 500);
    }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        
            $validatorPost = Validator::make(
                $request->all(),
                [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'required|image|mimes:png,jpg,jpeg,gif',
            ]);
            // Check if validation fails
            if ($validatorPost->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validatorPost->errors()->all(),
                ], 401);
            }

            $imagePath = null;

            if ($request->hasFile('image')) {
                // Handle the image upload
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension(); // Get file extension
                // Generate a unique name for the image
                $uniqueName = time() . '-' . uniqid() . '.' . $extension;
                // Define the directory path
                $directoryPath = public_path('images');

                // Check if the directory exists, and create it if it does not
                if (!is_dir($directoryPath)) {
                    mkdir($directoryPath, 0755, true);
                }
                // Move the file to the 'public/images' directory
                $image->move($directoryPath, $uniqueName);
                // Store image path relative to public path
                $imagePath = $uniqueName;
            }

            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
            ]);

            // Return successful response
            return response()->json([
                'status' => true,
                'message' => 'Post created successfully',
                'post' => $post
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        // Return successful response
        return response()->json([
            'status' => true,
            'message' => 'Post fetched successfully',
            'post' => $post
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            return response()->json([
                'status'=>false,
                'message' => 'Post not found !'
            ], 404);
        }

        $validatorPost = Validator::make(
            $request->all(),
            [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif',
        ]);
        // Check if validation fails
        if ($validatorPost->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validatorPost->errors()->all(),
            ], 401);
        }

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            $path = public_path() . '/images/';
            // Delete the old image if it exists and is within the 'images' directory
            if ($post->image && $post->image != null) {
                $old_image = $path . $post->image;
                if(file_exists($old_image)){
                    unlink($old_image);
                }
            }

            // Handle the image upload
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // Get file extension
            // Generate a unique name for the image
            $uniqueName = time() . '-' . uniqid() . '.' . $extension;
            // Define the directory path
            $directoryPath = public_path('images');
            // Move the file to the 'public/images' directory
            $image->move($directoryPath, $uniqueName);
            // Store image path relative to public path
            $imagePath = $uniqueName;
        }

        // Update the post
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post updated successfully',
            'post' => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Delete the image file if it exists
        if ($post->image) {
            $path = public_path() . '/images/';
            // Delete the old image if it exists and is within the 'images' directory
            if ($post->image && $post->image != null) {
                $old_image = $path . $post->image;
                if(file_exists($old_image)){
                    unlink($old_image);
                }
            }
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
