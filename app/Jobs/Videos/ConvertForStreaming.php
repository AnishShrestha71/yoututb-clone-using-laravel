<?php

namespace App\Jobs\Videos;


use FFMpeg\Format\Video\x264;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as SupportFFMpeg;

class ConvertForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $video;
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $low = (new X264('aac'))->setKiloBitrate(100);
        $mid = (new X264('aac'))->setKiloBitrate(250);
        $high = (new X264('aac'))->setKiloBitrate(500);
 
        SupportFFMpeg::fromDisk('local')
             ->open($this->video->path)
             ->exportForHLS()
             ->onProgress(function ($percentage){
                 $this->video->update([
                     'percentage'=> $percentage
                 ]);
             })
             ->addFormat($low)
             ->addFormat($mid)
             ->addFormat($high)
             ->save("public/videos/{$this->video->id}/{$this->video->id}.m3u8");
    }
}
