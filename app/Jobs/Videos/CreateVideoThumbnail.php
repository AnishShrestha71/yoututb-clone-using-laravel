<?php

namespace App\Jobs\Videos;

use App\Models\Video;
use FFMpeg\FFMpeg;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as SupportFFMpeg;

class CreateVideoThumbnail implements ShouldQueue
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
        SupportFFMpeg::fromDisk('local')
        ->open($this->video->path)
        ->getFrameFromSeconds(1)
        ->export()
        ->toDisk('local')
        ->save("public/thumbnail/{$this->video->id}.png");

        $this->video->update([
            'thumbnail' => Storage::url("public/thumbnail/{$this->video->id}.png")
        ]);

    }
}
