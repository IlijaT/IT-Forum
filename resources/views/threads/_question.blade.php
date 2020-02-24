<div class="card mb-2" v-if="editing">
  <div class="card-header">
    <div class="d-flex align-items-center">
      <div  class="flex-fill">
          <h5 class="flex-fill">
             <input type="text" class="form-control" v-model="form.title">
          </h5>
      </div>
    </div>
  
  </div>

    <div class="card-body">
      <div class="form-group">

        <textarea class="form-control" rows="5" v-model="form.body"></textarea>
      </div>
    </div>

    <div class="card-footer d-flex align-items-center">
      <div>
        <button type="submit" class="btn btn-success" @click="update">Update</button>
        <button type="submit" class="btn btn-dark" @click="resetForm">Cancel</button>

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
            <span v-text="title"></span>
          </h5>
      </div>

    </div>
  
  </div>

    <div class="card-body" v-text="body">
      
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-success" @click="editing = true" v-if="authorize('owns', thread)">Edit</button>
    </div>

</div>