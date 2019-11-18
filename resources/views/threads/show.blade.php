

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-2">

        {{-- Left Side --}}
        <div class="col-md-8">
            <div class="card mb-2">
              <div class="card-header">
                <div class="d-flex align-items-center">
                  <div  class="flex-fill">
                      <a href="{{ route('profile', [$thread->creator->name]) }}"> {{ $thread->creator->name }}</a> posted:
                      {{$thread->title}}
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

            @foreach ($replies as $reply)
              @include('threads.reply')
            @endforeach
            {{$replies->links()}}
    
            @auth
              <form action="{{ $thread->path() . '/replies'}}" method="post">
                @csrf
                <div class="form-group">
                  <textarea class="form-control" id="body" name="body" placeholder="Have something to say?" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
              </form>
            @else
              <p class="text-center">Please <a href="{{ route('login') }}">sign in </a>to participate in this discusion</p>
            @endauth
        </div>

        {{-- Right side --}}
        <div class="col md-4">
          <div class="card mb-2">
              <div class="card-body">
                This thread was published {{ $thread->created_at->diffForHumans() }}
                by <a href="#">{{ $thread->creator->name }}</a> and curently has {{ $thread->replies_count }}  {{ Str::plural ('comment', $thread->replies_count) }}.
              </div>
          </div>
        </div>
        

    </div>

</div>
@endsection
