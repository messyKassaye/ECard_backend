<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\CardRequest;
class NewCardRequest implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $newCardRequest;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CardRequest $newCardRequest)
    {
        //
        $this->newCardRequest = $newCardRequest;
    }

    

    public function broadcastOn()
    {
        return ['card-request-sent'];
    }


    public function broadcastAs()
    {
      return 'card-request';
    }

    public function broadcastWith(){
        return [
            'id'=>$this->newCardRequest->id,
            'requester_id'=>$this->newCardRequest->requester_id,
            'amount'=>$this->newCardRequest->amount,
            'card_type'=>$this->newCardRequest->cardType
        ];
    }
}
