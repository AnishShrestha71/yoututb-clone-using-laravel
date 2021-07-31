<?php

namespace App\Http\Controllers;

use App\Http\Requests\Video\UpdateVideo;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Video $video)
    {
        if (request()->wantsJson()) {
            return $video;
        }
        // dd($video->comment->first()->replies);
        return view(
            'video',
            [
                'video' => $video
            ]
        );
    }

    public function updateViews(Video $video)
    {
        $video->increment('views');
        return response()->json([]);
    }

    public function updateVideo( Video $video, updateVideo $request)
    {
    
        $video->update($request->only(['title', 'description']));


        return redirect()->back();
    }
}
