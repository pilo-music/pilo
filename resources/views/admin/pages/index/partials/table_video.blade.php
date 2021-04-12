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
