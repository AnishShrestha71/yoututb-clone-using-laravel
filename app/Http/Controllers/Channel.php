<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateChannel;
use App\Models\Channel as ModelsChannel;
use Illuminate\Http\Request;

class Channel extends Controller
{

    public function show(ModelsChannel $id)
    {
        // dd($id);
        $videos = $id->videos()->paginate(5);
        return view('channel.show',[
            'channel' => $id,
            'videos' => $videos
        ]);
       
    }
    public function update(UpdateChannel $request, ModelsChannel $id)
    {


        if($request->hasFile('channelImage'))
        {
            $id->clearMediaCollection('channelImage');
            $id->addMediaFromRequest('channelImage')
            ->toMediaCollection('channelImage');
        }
    
       
        $id->name = $request->name;
        $id->description = $request->channelDescription;
        $id->save();

        return back();
    }
}
