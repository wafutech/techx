<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JobPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
     public $job_id;

     public $hire_manager_id;
   
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($job_id, $hire_manager_id)
    {
         $this->job_id=$job_id;
         $this->hire_manager_id =$hire_manager_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
