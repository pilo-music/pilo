@extends('admin.layouts.master')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
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
        <x-music-table title="Last Musics" :items="$data" />
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
