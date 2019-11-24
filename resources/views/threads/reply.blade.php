<reply-component :attributes="{{ $reply }}" inline-template v-cloak>

  <div id="reply-{{ $reply->id }}" class="card mb-2">
      <div class="card-header">
        <div class="d-flex align-items-center">
            <h5 class="flex-fill">
              <a href="{{ route('profile', [$reply->owner->name]) }}">{{ $reply->owner->name }}</a>
                said {{$reply->created_at->diffForHumans()}}...
            </h5>

            @auth
              <div>
                <favorite :reply="{{ $reply }}"></favorite>
              </div>
            @endauth
        </div>

      </div>
     
      <div class="card-body">
          <div v-if="editing">
              <div class="form-group">
                <textarea class="form-control" rows="5" v-model="body"></textarea>
              </div>
              <button class="btn btn-xs btn-primary"  @click="update">Update</button>
              <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>

          </div>
          <div v-else v-text="body"></div>
      </div>

      @can ('update', $reply)
        <div class="card-footer d-flex">
          <button @click="editing = true" class="btn btn-default btn-secondary mr-1">Edit</button>
          <button type="submit" class="btn btn-danger btn-xs" @click="destroy">Delete</button>
        </div>
      @endcan

  </div>

</reply-component>