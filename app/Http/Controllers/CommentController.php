<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Video $video){
    //    $comment =Comment::find('6b0d1f17-13bc-46ba-908b-3f27c059f21c');
    //   dd($comment->replies);
        return $video->comment()->paginate(10);
    }

    public function show(Comment $comment)
    {
        return $comment->replies()->paginate(10);
    }

    public function store(Request $request, Video $video)
    {
        $user = User::find(Auth::user()->id);

       return $user->comment()->create([
            'body' =>$request->body,
            'video_id' => $video->id,
            'comment_id' => $request->comment_id

        ])->fresh();
        
    }
}
