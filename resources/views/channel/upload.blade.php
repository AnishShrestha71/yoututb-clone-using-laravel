@extends('layouts.app')
@section('content')
    <upload-video inline-template :channel="{{ $channel }}">
        <div class="flex justify-center">
            <div class="w-full">
                <div v-if="!selected">
                    <input type="file" name="video" multiple id="select-video" class="hidden" ref="videos" @change="upload">
                    <h5 onclick="document.getElementById('select-video').click()" class="text-center">Upload Video</h5>
                </div>
                <div v-else class="w-8/12 mx-auto ">
                    <div v-for="video in videos">
                        <div class="mt-2 bg-gray-600 rounded-full">
                            <div class="mt-2 bg-purple-900 py-0 rounded-full"
                                :style="{ width: `${progress[video.name]}%` }">
                                <div class=" text-white text-sm h-6 text-center px-2 rounded-full flex justify-center">
                                    @{{ video . percentage ? video . percentage === 100 ? 'Video Processing completed.' : 'Processing' : progress[video . name] ? progress[video . name] + '%' : 'Wait' }}
                                </div>
                            </div>

                        </div>

                        <div>
                            <div v-if="!video.thumbnail">
                                Loading thumbnail ...
                            </div>
                            <img v-else :src="video.thumbnail" style="width: 50%; heigh:40%;" alt="">
                        </div>
                        <div>
                            <a v-if="video.percentage && video.percentage === 100" target="_blank"
                            :href="`/video/${video.id}`">
                            @{{ video . title }}
                            </a>
                            <p v-else>@{{ video . name || video . title }}</p>
                        </div>

                    </div>


                </div>
            </div>
        </div>

    </upload-video>
@endsection
