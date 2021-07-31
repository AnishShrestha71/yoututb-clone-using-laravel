<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use App\Models\vote;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote($entityId, $type)
    {
       
        $user = User::find(Auth::user()->id);
        $entity = $this->getEntity($entityId);
        return $user->getToggleVote($entity, $type);
    }
    public function deleteVote($vote, $type)
    {
        vote::where('voteable_id',$vote)->where('user_id', Auth::user()->id)->delete();
        return response()->json([]);
    }

    public function getEntity($entityId)
    {
        $video = Video::find($entityId);
        if($video) return $video;

        $comment = Comment::find($entityId);
        if($comment) return $comment;

        throw new ModelNotFoundException('entity not found');
    }
}
