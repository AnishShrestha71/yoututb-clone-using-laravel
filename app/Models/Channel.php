<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Channel extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    public function user()
    {

        return $this->belongsTo(User::class);
    }
    public function image()
    {
        if ($this->media->first()) {
            return $this->media->first();
        } else {
            return null;
        }
    }
    public function editable()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->user_id === Auth::user()->id;
    }

    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
