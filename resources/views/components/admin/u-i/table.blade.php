<div>
    <div>
        @if($title)
            <h2 class="float-left">{{$title}}</h2>
        @endif
        @if($link)
            <a href="{{$link}}" class="float-right">show more</a>
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
