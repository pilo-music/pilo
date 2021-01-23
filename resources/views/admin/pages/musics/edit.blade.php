@extends('admin.layouts.edit')
@section('title')
    Edit Artist
@endsection

@section('form')
    <form method="post" action="{{route('artists.update',['artist'=>$data->id])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group mb-3">
                <label class="form-label">Name En<span class="form-required">*</span></label>
                <input type="text" name="name_en" class="form-control" value="{{$data->title_en}}"/>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Name<span class="form-required">*</span></label>
                <input name="name" type="text" class="form-control" value="{{$data->title}}"/>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Link128<span class="form-required">*</span></label>
                <input name="name" type="text" class="form-control" value="{{$data->link128}}"/>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Link320<span class="form-required">*</span></label>
                <input name="name" type="text" class="form-control" value="{{$data->link320}}"/>
            </div>
            <div class="form-group mb-3">
                <div class="form-label">Image</div>
                <div class="form-file">
                    <input type="file" class="form-file-input" name="image">
                    <label class="form-file-label" for="customFile">
                        <span class="form-file-text">Choose file...</span>
                        <span class="form-file-button">Browse</span>
                    </label>
                </div>
                <div class="mt-1">
                    <label for="">Image Null</label>
                    <input type="checkbox" value="1" name="image_null">
                </div>
                <div class="mt-3">
                    <img class="img-fluid rounded" src="{{get_image($data,'image')}}" alt="" width="100" height="100">
                </div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="1" {{ $data->status == 1 ? 'selected' : ''}}>Active</option>
                    <option value="0" {{$data->status == 0 ? 'selected' : ''}}>Draft</option>
                </select>
            </div>
        </div>
        <div class="card-footer text-right">
            <div class="d-flex">
                <a href="{{route('artists.index')}}" class="btn btn-link">Cancel</a>
                <button type="submit" class="btn btn-primary ml-auto">Send data</button>
            </div>
        </div>
    </form>
@endsection
