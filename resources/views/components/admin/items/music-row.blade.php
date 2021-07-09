<div>
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
</div>
