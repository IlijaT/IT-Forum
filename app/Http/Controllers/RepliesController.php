<?php

namespace App\Http\Controllers;

use App\User;
use App\Reply;
use App\Thread;
use Illuminate\Support\Facades\Gate;
use App\Notifications\YouWereMentioned;
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

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);

        $names = $matches[1];

        foreach ($names as $name) {
            $user = User::whereName($name)->first();

            if ($user) {
                $user->notify(new YouWereMentioned($reply));
            }
        }
        return $reply->load('owner');
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
        try {
            request()->validate(['body' => 'required|spamfree']);
            $this->authorize('update', $reply);
        } catch (\Exception $e) {
            return response('Sorry, your reply could not be saved at this time', 422);
        }

        $reply->update(request(['body']));
    }
}
