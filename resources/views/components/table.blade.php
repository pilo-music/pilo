<div>
    <div class="d-flex justify-content-between align-items-center">
        @if($title)
            <h2>{{$title}}</h2>
        @endif
        @if($link)
            <a href="{{$link}}">show more</a>
        @endif
    </div>
    <div class="box">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    {{$slot}}
                </table>
            </div>
        </div>
    </div>
</div>
