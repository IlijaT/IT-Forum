<div class="card mb-2" v-if="editing">
  <div class="card-header">
    <div class="d-flex align-items-center">
      <div  class="flex-fill">
          <h5 class="flex-fill">
             <input type="text" value="{{$thread->title}}" class="form-control">
          </h5>
      </div>
    </div>
  
  </div>

    <div class="card-body">
      <div class="form-group">

        <textarea class="form-control" name="" rows="5">{{ $thread->body }}</textarea>
      </div>
    </div>

    <div class="card-footer d-flex align-items-center">
      <div>
        <button type="submit" class="btn btn-success">Update</button>
        <button type="submit" class="btn btn-dark" @click="editing = false">Cancel</button>

      </div>

      @can('update',$thread)
        <div class="ml-auto">
          <form action="{{$thread->path()}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Thread</button>
          </form>
        </div>
        
      @endcan
    </div>

</div>

<div class="card mb-2" v-else>
  <div class="card-header">
    <div class="d-flex align-items-center">
      <div  class="flex-fill">
          <h5 class="flex-fill">
            <img src="{{ asset( $thread->creator->avatar_path)  }}" alt="avatar" width="25" height="25" class="mr-2">
            <a href="{{ route('profile', [$thread->creator->name]) }}"> {{ $thread->creator->name }}</a> posted:
            {{$thread->title}}
          </h5>
      </div>

    </div>
  
  </div>

    <div class="card-body">
      {{ $thread->body }}
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-success" @click="editing = true">Edit</button>
    </div>

</div>