<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\LikePost;



class PostController extends Controller
{
    function getPosts($id = null){
        if($id){
            $posts = Post::find($id);
        }else{
            $posts = Post::all();
        }
        
        return response()->json([
            "status" => "success",
            "data" => $posts
        ]);
    
    }

    public function addPost(Request $request)
    {
        
        // Validate the request data
        $request->validate([
            'picture' => 'required'
                ]);
        
        if ( $request->file('picture') ) {
            
            $validator = Validator::make($request->all(),[ 
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
              ]);   
       
            if($validator->fails()) {          
                  
                return response()->json(['error'=>$validator->errors()], 401);                        
               }  

            // Store the uploaded file
            $file = $request->file('picture');
            $path = $file->store('uploads/posts'); // Choose the desired storage path

               
          }
      

        // Create a new post
        $post = new Post;
        $post->image = $path;
        $post->number_of_likes = 0;
        $post->user_id = auth()->user()->id;
        $post->save();

        return response()->json([
            "status" => "success",
            "message" => "Post created successfully",
            "data" => $post
        ]);
    }

    

    
    public function likePost($id = null)
    {
        // Check if the authenticated user has already liked the post
       $like = LikePost::where('user_liker', auth()->user()->id)
       ->where('post_id', $id)->first();


        if (!empty($like)) {
            return response()->json([
                "status" => "error",
                "message" => "You have already liked this post"
            ]);
        }

        // Create a new like for the post
        $likes = new likepost;
        $likes->post_id = $id;
        $likes->user_liker = auth()->user()->id;
        $likes->save();

        return response()->json([
            "status" => "success",
            "message" => "Post liked successfully"
        ]);
    }

    public function unlikePost($id = null)
    {
        if ($id) {
            $liker = LikePost::where('post_id', $id)
                ->where('user_liker', auth()->user()->id)
                ->first();
    
            if ($liker) {
                $liker->delete();
    
                return response()->json([
                    "status" => "success",
                    "message" => 'User unlike the post successfully'
                ]);
            }
        }
    
        return response()->json([
            "status" => "error",
            "message" => 'Invalid request'
        ]);    
    }
}