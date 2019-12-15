<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{

    public function handle(ThreadReceivedNewReply $event)
    {
        $mentionedUsers = User::whereIn('name', $event->reply->mentionedUsers())->get();

        foreach ($mentionedUsers as $user) {
            $user->notify(new YouWereMentioned($event->reply));
        }
    }
}
