

@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-view :thread="{{$thread}}" inline-template>
  <div class="container">
      <div class="row mb-2">

          {{-- Left Side --}}
          <div class="col-md-8" v-cloak>

            @include('threads._question')

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
                    <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>
                    @if (auth()->check() && auth()->user()->isAdmin())
                      <button class="btn btn-success" @click="toggleLock" v-text="locked ? 'Unlock' : 'Lock'"></button>
                    @endif
                  </p>
                </div>
            </div>
          </div>
          

      </div>

  </div>
</thread-view>
@endsection
