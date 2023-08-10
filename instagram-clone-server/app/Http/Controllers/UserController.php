<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follower;

class UserController extends Controller
{
    public function searchUser($keyword = null)
    {
        if ($keyword) {
            $users = User::where('username', 'like', '%' . $keyword . '%')
                ->orWhere('first_name', 'like', '%' . $keyword . '%')
                ->orWhere('last_name', 'like', '%' . $keyword . '%')
                ->get();
        } else {
            return response()->json([
                "status" => "Enter the keyword",
                "data" => []
            ]);
        }

        return response()->json([
            "status" => "success",
            "data" => $users
        ]);
    }
   
    public function follow($id_following ="null")
    {

        if ($id_following != "null") {
            $follow = new Follower;
            $follow->user_id_following = $id_following;
            $follow->user_id = auth()->user()->id;
            $follow->save();

            return response()->json([
                "status" => "success",
                "message" => 'User followed successfully'
            ]);
        }

        return response()->json([
            "status" => "error",
            "message" => 'Invalid request'
        ]);
    }

    public function unfollow($id_following = null)
    {
        if ($id_following) {
            $follower = Follower::where('user_id_following', $id_following)
                ->where('user_id', auth()->user()->id)
                ->first();
    
            if ($follower) {
                $follower->delete();
    
                return response()->json([
                    "status" => "success",
                    "message" => 'User unfollowed successfully'
                ]);
            }
        }
    
        return response()->json([
            "status" => "error",
            "message" => 'Invalid request'
        ]);
    }
}