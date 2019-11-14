

@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($threads as $thread)
        <div class="row justify-content-center mb-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="flex-fill">
                                <a href="{{$thread->path()}}">{{ $thread->title }}</a>
                            </h4>

                            <a href="{{$thread->path()}}">{{ $thread->replies_count }} {{ Str::plural ('reply', $thread->replies_count) }}</a>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="body"> {{ $thread->body }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
@endsection
