

@extends('layouts.app')

@section('content')
 <div class="container">

     <div class="row mb-2">
        <div class="col-md-8">
            @include('threads._list')
            {{ $threads->links() }}

        </div>

        <div class="col-md-4">
            @if (count($trending))
            <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="flex-fill">
                                <h4 >
                                   Trending threads
                                </h4>
                            </div>
                        </div>
                    </div>
        
                    <div class="card-body">
                        @foreach ($trending as $thread)
                            
                            <div class="body"> 
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="{{ url($thread->path) }}">{{ $thread->title }}</a>
                                    </li>
                                </ul>
                                 
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        
        </div>
          
     </div>
      
 </div>
         
 
   
</div>
@endsection
