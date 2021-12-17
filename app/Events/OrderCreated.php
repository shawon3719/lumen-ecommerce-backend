<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['notifications'];
    }

    public function broadcastAs()
    {
        return 'orderCreated';
    }

    public function broadcastWith()
    {
        return ["order" => $this->order];
    }
}