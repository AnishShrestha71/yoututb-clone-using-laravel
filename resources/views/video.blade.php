@extends('layouts.app')
@section('content')
    <div class="container">
        @if ($video->editable())

            <form action="{{ route('update.video', $video->id) }}" method="POST">
                @csrf
                @method('PUT')
        @endif
        <div>
            <h1> {{ $video->title }}</h1>
        </div>
        <div>
            <video-js id="video" class="vjs-default-skin" controls preload="auto" width="640" height="268">
                <source src='{{ asset(Storage::url("videos/{$video->id}/{$video->id}.m3u8")) }}'
                    type="application/x-mpegURL">
            </video-js>
            {{-- <img src="{{asset(Storage::url("/thumbnail/2ab584b5-4aa4-4e22-9ee8-2addeb93eaf8.png"))}}" alt=""> --}}
        </div>
        <div class="flex justify-between mt-2">
            <div>
                @if ($video->editable())
                    <input type="text" name="title" value="{{ $video->title }}" />
                @else
                    <h5>{{ $video->title }}</h5>
                @endif

                <p>{{ $video->views }} {{ Illuminate\Support\Str::plural('view', $video->views) }}</p>
            </div>
            <hr>



            <votes :default_votes='{{ $video->votes }}' entity_id="{{$video->id}}" entity_owner='{{$video->channel->user_id }}'/>
        </div>
        <hr>
        @if ($video->editable())
            <textarea name="description" class="w-full" id="">{{ $video->description }} </textarea>
            <button class="mb-4 ">
                Update
            </button>
        @else
            <p>{{ $video->description }}
            </p>
        @endif

        <div class="flex justify-between">
            <div>
                <h4>{{ $video->channel->name }}</h4>
                <p>published on : {{ $video->created_at->toFormattedDateString() }}</p>

            </div>
            <div class="w-4/12 ml-12 text-right">
                <subscribe-button :channel="{{ $video->channel }}"
                    :initial-subscriptions="{{ $video->channel->subscription }}" />
            </div>

        </div>
        @if ($video->editable())

            </form>
        @endif
       <comments :video="{{$video}}">

       </comments>
        

    </div>

@endsection
@section('styles')
    <link href="//vjs.zencdn.net/7.10.2/video-js.min.css" rel="stylesheet">
   
@endsection
@section('scripts')
    <script src="//vjs.zencdn.net/7.10.2/video.min.js"></script>
    <script>
        window.CURRENT_VIDEO = '{{ $video->id }}'
    </script>
    <script src="{{ asset('js/player-js.js') }}">

    </script>


@endsection
