

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-2">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <a href="http://"> {{ $thread->creator->name }}</a> posted:
                {{$thread->title}}
              </div>

                <div class="card-body">
                  {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-2">
      <div class="col-md-8">
        @foreach ($thread->replies as $reply)
          @include('threads.reply')
        @endforeach
      </div>
    </div>

    @auth
      <div class="row justify-content-center mb-2">
        <div class="col-md-8">
          <form action="{{ $thread->path() . '/replies'}}" method="post">
            @csrf
            <div class="form-group">
              <textarea class="form-control" id="body" name="body" placeholder="Have something to say?" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
          </form>
        </div>
      </div>
    @else
      <p class="text-center">Please <a href="{{ route('login') }}">sign in </a>to participate in this discusion</p>
    @endauth
</div>
@endsection
