<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Trending;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use Illuminate\Support\Facades\Redis;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Recaptcha $recaptcha)
    {

        request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id',
            'g-recaptcha-response' => ['required', $recaptcha] 
        ]);

        $thread = Thread::create([
            'title' => request('title'),
            'body' => request('body'),
            'channel_id' => request('channel_id'),
            'user_id' => auth()->id(),
        ]);

        if (request()->wantsJson()) {
            return response($thread, 201);
        }

        return redirect($thread->path())->with('flash', 'Your thread has been published');
    }

    public function show($channel, Thread $thread, Trending $trending)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        Redis::zincrby('trending_threads', 1, json_encode([
            'title' => $thread->title,
            'path' => $thread->path()
        ]));

        $thread->increment('visits');

        return view('threads.show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        //
    }

    public function update($chanel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->update(request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]));

        return $thread;
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        $thread->delete();

        return redirect('/threads');
    }

    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        return $threads->paginate(10);
    }
}
