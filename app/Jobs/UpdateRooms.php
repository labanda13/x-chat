<?php

namespace App\Jobs;

use App\Events\RoomsUpdated;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateRooms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Skip if just updated recently
        if ($firstRoom = Room::orderBy('updated_at')->first()
            and strtotime($firstRoom->updated_at) >= time() - 3
        ) {
            return;
        }

        // Remove unactive guests from rooms
        Guest::whereNotNull('room_id')
            ->where('updated_at', '<', now()->subMinutes(5))
            ->update([
                'room_id' => null
            ]);

        // Remove unactive guests
        Guest::where('updated_at', '<', now()->subHours(72))->delete();

        // Update room guest count
        $rooms = Room::all();
        $rooms->each(function (Room $room) {
            $room->guest_count = rand(50, 150) + $room->guests()->count();
            $room->touch();

            // Delete room old messages
            $latestMessage = $room->messages()->orderByDesc('id')->skip($room->message_limit)->first();
            if ($latestMessage) {
                $room->messages()->where('id', '<', $latestMessage->id)->delete();
            }
        });

        // Broadcast
        RoomsUpdated::dispatch($rooms);

        // Update rooms after 5s
        static::dispatch()->delay(now()->addSeconds(5));
    }
}
