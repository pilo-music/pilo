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
            <!-- Page title actions -->
            <div class="col-auto ml-auto d-print-none">
                <span class="d-none d-sm-inline">
                  <a href="#" class="btn btn-white">
                    New view
                  </a>
                </span>
                <a href="#" class="btn btn-primary ml-3 d-none d-sm-inline-block" data-toggle="modal"
                   data-target="#modal-report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Create new report
                </a>
                <a href="#" class="btn btn-primary ml-3 d-sm-none btn-icon" data-toggle="modal"
                   data-target="#modal-report" aria-label="Create new report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="row row-deck row-cards">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Musics</div>
                    </div>
                    <div class="h1 mb-3">{{$music_count}}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Artists</div>
                    </div>
                    <div class="h1 mb-3">{{$artist_count}}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Users</div>
                    </div>
                    <div class="h1 mb-3">{{$user_count}}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Albums</div>
                    </div>
                    <div class="h1 mb-3">{{$album_count}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Traffic summary</h3>
                    <div id="chart-development-activity" class="mt-4"></div>
                </div>
            </div>
        </div>
        <div>
            <h2 class="float-left">List of last {{count($musics)}} musics</h2>
            <a href="{{route('musics.index')}}" class="float-right">show more</a>
        </div>
        <div class="box">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Artist</th>
                            <th>Stored at</th>
                            <th class="w-1"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($musics as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td><img src="{{get_image($item,'image')}}" alt="" width="50" height="50"
                                         class="rounded img-fluid"></td>
                                <td class="text-muted">{{$item->title_en}}</td>
                                <td class="text-muted">{{$item->artist->name_en}}</td>
                                <td class="text-muted">{{$item->stored_at}}</td>
                                <td>
                                    <a href="#">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <h2 class="float-left">List of last {{count($artists)}} artists</h2>
            <a href="{{route('artists.index')}}" class="float-right">show more</a>
        </div>
        <div class="box">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Stored at</th>
                            <th class="w-1"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($artists as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td><img src="{{get_image($item,'image')}}" alt="" width="50" height="50"
                                         class="rounded img-fluid"></td>
                                <td class="text-muted">{{$item->name_en}}</td>
                                <td class="text-muted">{{$item->stored_at}}</td>
                                <td>
                                    <a href="{{route('artists.edit',['artist'=>$item->id])}}">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <h2 class="float-left">List of last {{count($albums)}} albums</h2>
            <a href="{{route('albums.index')}}" class="float-right">show more</a>
        </div>
        <div class="box">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Artist</th>
                            <th>Stored at</th>
                            <th class="w-1"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($albums as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td><img src="{{get_image($item,'image')}}" alt="" width="50" height="50"
                                         class="rounded img-fluid"></td>
                                <td class="text-muted">{{$item->title_en}}</td>
                                <td class="text-muted">{{$item->artist->name_en}}</td>
                                <td class="text-muted">{{$item->stored_at}}</td>
                                <td>
                                    <a href="#">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <h2 class="float-left">List of last {{count($videos)}} videos</h2>
            <a href="{{route('videos.index')}}" class="float-right">show more</a>
        </div>
        <div class="box">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Artist</th>
                            <th>Stored at</th>
                            <th class="w-1"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($videos as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td><img src="{{get_image($item,'image')}}" alt="" width="50" height="50"
                                         class="rounded img-fluid"></td>
                                <td class="text-muted">{{$item->title_en}}</td>
                                <td class="text-muted">{{$item->artist->name_en}}</td>
                                <td class="text-muted">{{$item->stored_at}}</td>
                                <td>
                                    <a href="#">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
