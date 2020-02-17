

@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-view :initial-replies-count="{{$thread->replies_count}}" inline-template>
  <div class="container">
      <div class="row mb-2">

          {{-- Left Side --}}
          <div class="col-md-8">
              <div class="card mb-2">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <div  class="flex-fill">
                        <h5 class="flex-fill">
                          <img src="{{ asset( $thread->creator->avatar_path)  }}" alt="avatar" width="25" height="25" class="mr-2">
                          <a href="{{ route('profile', [$thread->creator->name]) }}"> {{ $thread->creator->name }}</a> posted:
                          {{$thread->title}}
                        </h5>
                    </div>

                    @can('update',$thread)
                      <form action="{{$thread->path()}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Thread</button>

                      </form>
                    @endcan
                  </div>
                
                </div>

                  <div class="card-body">
                    {{ $thread->body }}
                  </div>
              </div>

              <replies 
                  @removed="repliesCount--"
                  @added="repliesCount++">
              </replies>

          </div>

          {{-- Right side --}}
          <div class="col md-4">
            <div class="card mb-2">
                <div class="card-body">
                  This thread was published {{ $thread->created_at->diffForHumans() }}
                  by <a href="#">{{ $thread->creator->name }}</a> and curently has 
                  <span v-text="repliesCount"></span> {{ Str::plural ('comment', $thread->replies_count) }}.
                  <p>
                    <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                    <button class="btn btn-success">Lock</button>
                  </p>
                </div>
            </div>
          </div>
          

      </div>

  </div>
</thread-view>
@endsection
