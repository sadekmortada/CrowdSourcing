<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MyEvent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $message;
  public $channel;

  public function __construct($message,$channel)
  {
      $this->message = $message;
      $this->channel=$channel;
  }

  public function broadcastOn()
  {
      return [$this->channel];
  }

  public function broadcastAs()
  {
      return 'my-event';
  }
  public function broadcastWith()
{
    return [$this->message];
}
}