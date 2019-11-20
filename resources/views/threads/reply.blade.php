<div id="reply-{{ $reply->id }}" class="card mb-2">
    <div class="card-header">
      <div class="d-flex align-items-center">
          <h5 class="flex-fill">
            <a href="{{ route('profile', [$reply->owner->name]) }}">{{ $reply->owner->name }}</a>
              said {{$reply->created_at->diffForHumans()}}...
          </h5>

          <div>
            <form action="/replies/{{$reply->id}}/favorites" method="post">
                @csrf
                <button type="submit" class="btn btn-success" {{ $reply->isFavorited() ? 'disabled' : ''}}>
                    {{ $reply->favorites_count }} {{ Str::plural ('Favorite', $reply->favorites_count ) }}
                </button>
            </form>
          </div>
      </div>

    </div>
    <div class="card-body">
      {{ $reply->body }}
    </div>
</div>