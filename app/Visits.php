<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Visits
{
    protected $thread;

    public function __construct(Thread $thread) {
        $this->thread = $thread;
    }

    public function reset() 
    {
        Redis::del($this->cacheKey());
    
    }

    public function count() 
    {
        
        return Redis::get($this->cacheKey()) ?? 0;
    }

    
    public function record() 
    {
        
        Redis::incr($this->cacheKey());
    }

    protected function cacheKey() 
    {
        return "threads.{$this->thread->id}.visits";
    
    }

}
