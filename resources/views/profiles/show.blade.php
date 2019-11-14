
@extends('layouts.app')

@section('content')

<div class="container">
  <div class="pb-2 mt-4 mb-2 border-bottom">
    <h4>
      {{ $profileUser->name }}
      Since {{ $profileUser->created_at->diffForHumans()}}
    </h4>
  </div>

  @foreach ($threads as $thread)
    <div class="card mb-2">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <div class="flex-fill">
              {{$thread->title}}
          </div>

          <div>
            {{$thread->created_at->diffForHumans()}}
          </div>

        </div>
       
      </div>

        <div class="card-body">
          {{ $thread->body }}
        </div>
    </div>
      
  @endforeach
  {{$threads->links()}}
</div>

@endsection