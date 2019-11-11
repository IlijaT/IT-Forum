

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Thread</div>

                <div class="card-body">
                  <form method="POST" action="/threads">
                    @csrf

                    <div class="form-group">
                      <label for="title">Choose a channel:</label>
                      <select name="channel_id" id="channel_id" class="form-control" required>
                          <option value="">Choose a channel...</option>
                        	@foreach ($channels as $channel)
                            <option value="{{$channel->id}}"
                              {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{$channel->name}}</option> 
                          @endforeach
                      </select>

                    </div>

                    <div class="form-group">
                      <label for="title">Title:</label>
                      <input name="title" type="text" class="form-control" id="title" value="{{ old('name') }}" required>
                    </div> 
                    <div class="form-group">
                      <label for="body">Body:</label>
                      <textarea class="form-control" id="body" name="body" rows="8"  value="{{ old('body') }}" required></textarea>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Publish</button>
                    </div>

                    @if (count($errors))
                      <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                          <li>{{$error}}</li>
                        @endforeach
                      </ul>
                    @endif

                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
