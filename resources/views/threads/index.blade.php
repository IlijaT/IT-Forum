

@extends('layouts.app')

@section('content')
<div class="container">
    @include('threads._list')
    <div class="row">
        <div class="col-md-8 offset-2">
            {{ $threads->links() }}

        </div>
    </div>
</div>
@endsection
