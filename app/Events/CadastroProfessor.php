<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CadastroProfessor
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nomeProfessor;
    public $emailProfessor;
    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $nomeProfessor, string $emailProfessor, int $userId)
    {
        $this->nomeProfessor = $nomeProfessor;
        $this->emailProfessor = $emailProfessor;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
