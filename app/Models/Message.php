<?php

namespace App\Models;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\matches;

class Message extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Convert model to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'guest_id' => $this->guest_id,
            'room_id' => $this->room_id,
            'text' => $this->text,
            'guest' => $this->relationLoaded('guest') ? $this->guest : null,
            'time_diff' => $this->created_at?->diffForHumans()
        ];
    }
}
