

@extends('layouts.app')

@section('content')
<div class="container">
    @forelse ($threads as $thread)
        <div class="row justify-content-center mb-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <p class="flex-fill">
                                <a href="{{ route('profile', [$thread->creator->name]) }}"> {{ $thread->creator->name }}</a> posted:
                                <a href="{{$thread->path()}}">{{ $thread->title }}</a>
                            </p>

                            <a href="{{$thread->path()}}">{{ $thread->replies_count }} {{ Str::plural ('reply', $thread->replies_count) }}</a>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="body"> {{ $thread->body }}</div>
                    </div>
                </div>
            </div>
        </div>
    @empty
       There are no relevant results at this time 
    @endforelse

</div>
@endsection
