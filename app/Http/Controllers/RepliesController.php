<?php

namespace App\Http\Controllers;

use App\User;
use App\Reply;
use App\Thread;
use App\Http\Requests\CreatePostRequest;

class RepliesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }

    public function store($channelId, Thread $thread, CreatePostRequest $postForm)
    {
        if($thread->locked) {
            return response('Thread is locked', 422);
        }
        
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ])->load('owner');
    }

    public function destroy(Reply $reply)
    {

        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }

    public function update(Reply $reply)
    {
        request()->validate(['body' => 'required|spamfree']);
        $this->authorize('update', $reply);
        $reply->update(request(['body']));
    }
}
