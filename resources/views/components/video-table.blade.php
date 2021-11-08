<x-table title="{{$title}}" link="{{route('videos.index')}}">
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
    @foreach($items as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>
                <img src="{{get_image($item)}}" alt="" width="50" height="50" class="rounded img-fluid">
            </td>
            <td class="text-muted">{{$item->title_en}}</td>
            <td class="text-muted">{{$item->artist->name_en}}</td>
            <td class="text-muted">{{$item->stored_at}}</td>
            <td>
                <a href="#">Edit</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</x-table>

@if($items instanceof \Illuminate\Pagination\LengthAwarePaginator )
    {{$items->links()}}
@endif

