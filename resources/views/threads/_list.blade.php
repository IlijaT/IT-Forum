    @forelse ($threads as $thread)

        <div class="card mb-3">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">

                        <h4 >
                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    <a href="{{$thread->path()}}">{{ $thread->title }}</a>
                                </strong>
                            @else
                                <a href="{{$thread->path()}}">{{ $thread->title }}</a>
                            @endif
                        </h4>
                        <h5>Posted by: <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a></h5>

                    </div>
                        
                    <a href="{{$thread->path()}}">{{ $thread->replies_count }} {{ Str::plural ('reply', $thread->replies_count) }}</a>
                </div>
            </div>

            <div class="card-body">
                <div class="body"> {{ $thread->body }}</div>
            </div>

            <div class="card-footer">
                <p>{{ $thread->visits() }} Visits</p>
            </div>

        </div>


    @empty
       There are no relevant results at this time 
    @endforelse
