
@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="pb-2 mt-4 mb-2 border-bottom">
            <h4>
              {{ $profileUser->name }}
            </h4>

            @can('update', $profileUser)
            <form  method="POST" action="{{ route('avatar', $profileUser) }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="avatar">
                <div class="mt-1">

                  <button type="submit" class="btn btn-primary">Add Avatar</button>
                </div>
              </form>
            @endcan
            <img src="{{ asset('storage/'.$profileUser->avatar_path) }}" alt="avatar" width="80" height="80">
          </div>
        
          @forelse ($activities as $date => $activity)
            <h3 class="page-header">{{ $date }}</h3>
            @foreach ($activity as $record)
              @if (view()->exists("profiles.activities.{$record->type}"))
                @include("profiles.activities.{$record->type}", ['activity' => $record])
              @endif
            @endforeach
          @empty
             There is no activity for this user yet! 
          @endforelse

    </div>
  </div>
  
</div>

@endsection