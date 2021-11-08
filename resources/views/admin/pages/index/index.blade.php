@extends('admin.layouts.master')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Overview
                </div>
                <h2 class="page-title">
                    Dashboard
                </h2>
            </div>
        </div>
    </div>
    <div class="row row-deck row-cards">
        @include('admin.pages.index.partials.box',['title'=>'Musics','value'=>$music_count])
        @include('admin.pages.index.partials.box',['title'=>'Artists','value'=>$artist_count])
        @include('admin.pages.index.partials.box',['title'=>'Users','value'=>$user_count])
        @include('admin.pages.index.partials.box',['title'=>'Albums','value'=>$album_count])

        <x-music-table title="Last Musics ({{$music_count}})" :items="$musics" />
        <x-artist-table title="Last Artists ({{$artist_count}})" :items="$artists" />
        <x-album-table title="Last Albums ({{$album_count}})" :items="$albums" />
        <x-video-table title="Last Videos ({{$video_count}})" :items="$videos" />

    </div>
@endsection
