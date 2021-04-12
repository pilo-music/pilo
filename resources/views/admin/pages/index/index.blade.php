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
        @include('admin.pages.index.partials.table_music')
        @include('admin.pages.index.partials.table_artist')
        @include('admin.pages.index.partials.table_album')
        @include('admin.pages.index.partials.table_video')

    </div>
@endsection
