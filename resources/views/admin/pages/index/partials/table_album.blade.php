<x-ui-table title="List of last {{count($albums)}} albums" link="{{route('albums.index')}}">
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
</x-ui-table>
