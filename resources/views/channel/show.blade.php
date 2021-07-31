@extends('layouts.app')
@section('content')

    <div class="ml-8 w-1/2">

        @if ($channel->editable())

            <a href="{{ route('upload.channel', $channel->id) }}">Upload Video</a>
            <form action="{{ route('update.channel', $channel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-col space-y-2 justify-center items-center ">

                    <img onclick="document.getElementById('channelImage').click()" id="preview-image"
                        class="transition duration-500 ease-in-out w-2/12 h-24 shadow-2xl border-2 border-blue-900 cursor-pointer  transform hover:-translate-y-1 hover:scale-110"
                        src="{{ $channel->image() !== null ? asset('storage/' . $channel->image()->id . '/' . $channel->image()->file_name) : null }}"
                        alt="">
                    <label for="channelImage shadow-lg ">Channel Image</label>
                    <input type="file" name="channelImage" id="channelImage" class="hidden">

                </div>
                <div class="flex flex-col space-y-2 mt-2">
                    <label for="channelName shadow-lg">Channel Name</label>
                    <input type="text"
                        class="shadow-lg appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:ring-2
                                                                                                 focus:ring-purple-200 focus:border-transparent focus:outline-none focus:shadow-outline"
                        name="name" id="channelName" value="{{ $channel->name }}">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <div class="flex flex-col space-y-2 mt-2">
                    <label for="channelDescription shadow-lg">Channel Description</label>
                    <textarea name="channelDescription"
                        class="shadow-lg appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:ring-2
                                                                                            focus:ring-purple-200 focus:border-transparent focus:outline-none focus:shadow-outline"
                        id="channelDescription">{{ $channel->description }}</textarea>
                    @error('channelDescription')
                        {{ $message }}
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="mt-4 shadow-xl bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Button
                    </button>
                </div>
            </form>
        @else
            <div class=" text-center">
                <div class="flex flex-col space-y-2 justify-center items-center ">

                    <img class="transition duration-500 ease-in-out w-2/12 h-24 shadow-2xl border-2 border-blue-900 cursor-pointer  transform hover:-translate-y-1 hover:scale-110"
                        src="{{ $channel->image() !== null ? asset('storage/' . $channel->image()->id . '/' . $channel->image()->file_name) : null }}"
                        alt="">
                    <label for="channelImage shadow-lg ">Channel Image</label>
                    <input type="file" name="channelImage" id="channelImage" class="hidden">

                </div>





                <div class="flex flex-col space-y-2 mt-2">
                    <label for="channelName shadow-lg">Channel Name: {{ $channel->name }}</label>


                </div>
                <div class="flex flex-col space-y-2 mt-2">
                    <label for="channelDescription shadow-lg">Channel Description: {{ $channel->description }}</label>

                </div>


            </div>
        @endif
        <div class="mt-10">
            <table>
                <thead>
                    <th>sn</th>
                    <th>Title</th>
                    <th>View</th>
                    <th>Status</th>
                    <th>sn</th>
                </thead>
                <tbody>
                    @foreach ($videos as $video)
                        <tr>
                            <td><img src="{{$video->thumbnail}}"  class="w-42 h-24" / ></td>
                            <td>{{$video->title}}</td>
                            <td>{{$video->views}}</td>
                            <td>{{$video->percentage === 100 ? 'Live' : 'Processing'}}</td>
                            <td><a href="{{route('video.show',$video->id)}}">view</a></td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
            <div>
                {{$videos->links()}}
            </div>
        </div>
        <subscribe-button :channel="{{ $channel }}" :initial-subscriptions="{{ $channel->subscription }}" />





    </div>

@endsection
