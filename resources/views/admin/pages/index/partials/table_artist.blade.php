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
                        <td><img src="{{empty(get_image($item))? asset('resources/client/img/artist_placeholder.svg') :  get_image($item) }}" alt="" width="50" height="50"
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
