<?php
namespace App\Events;

use App\Models\Appeal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AppealUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $appeal;

    public function __construct(Appeal $appeal)
    {
        $this->appeal = $appeal;
    }

    public function broadcastOn()
    {
        return new Channel('amendments');
    }
}