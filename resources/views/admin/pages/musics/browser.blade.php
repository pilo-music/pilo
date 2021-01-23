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
                <a href="{{route('musics.create')}}" class="btn btn-primary ml-3 d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Create new item
                </a>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="box">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Stored at</th>
                            <th>Created_at at</th>
                            <th class="w-1"></th>
                            <th class="w-1"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    <img src="{{get_image($item,'image')}}" alt="" width="50" height="50"
                                         class="rounded img-fluid">
                                </td>
                                <td class="text-muted">{{$item->title_en}}</td>
                                @if($item->status == 1)
                                    <td>
                                        <span class="badge bg-success text-white">Active</span>
                                    </td>
                                @else
                                    <td>
                                        <span class="badge bg-danger text-white">Draft</span>
                                    </td>
                                @endif
                                <td>
                                    {{$item->stored_at}}
                                </td>
                                <td>
                                    {{$item->stored_at}}
                                </td>
                                <td>
                                    <a class="btn btn-dark"
                                       href="{{route('musics.edit',['music'=>$item->id])}}">Edit</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-danger" data-toggle="modal"
                                       data-target="#modal-small-{{$item->id}}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div>
        {{$data->render()}}
    </div>

    @foreach($data as $item)
        <div class="modal modal-blur fade" id="modal-small-{{$item->id}}" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-title">Are you sure?</div>
                        <div>Are you sure, you want delete <span class="text-danger">{{$item->title_en}}</span>.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel
                        </button>
                        <form action="{{route('musics.destroy',['music'=>$item->id])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Yes, delete all my data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
