<?php

namespace App\Http\Controllers;

use App\Jobs\Videos\ConvertForStreaming;
use App\Jobs\Videos\CreateVideoThumbnail;
use App\Models\Channel;
use Illuminate\Http\Request;

class UploadVideoController extends Controller
{
    public function show(Channel $channel)
    {
       
        return view('channel.upload',[
            'channel' => $channel
        ]);
    }
    public function store(Channel $channel)
    {
        $video = $channel->videos()->create([
            'title' =>request()->title,
            'path' => request()->video->store("channels/{$channel->id}")
        ]);

        $this->dispatch(new ConvertForStreaming($video));

        $this->dispatch(new CreateVideoThumbnail($video));
        return $video;
    }
}
