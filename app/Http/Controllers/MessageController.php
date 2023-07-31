<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessage;
use App\Models\Blacklist;
use App\Models\Guest;
use App\Models\Message;
use App\Models\Room;
use App\Support\RequestClient;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    /**
     * Store message
     *
     * @param StoreMessage $request
     * @return Message
     */
    public function store(StoreMessage $request)
    {
        $data = $request->validated();
        $room = Room::findOrFail($data['room_id']);
        $guest = Guest::where('key', $data['key'])->firstOrFail();

        // Update guest IP
        $ip = RequestClient::ip();
        $guest->ip = $ip;
        $guest->save();

        // Blacklisted
        if ($blacklist = Blacklist::where('ip', $ip)->first()
            and (!$blacklist->free_at or strtotime($blacklist->free_at) > time())
        ) {
            throw ValidationException::withMessages([
                'reason' => 'Bạn đã bị quản trị viên cấm chat với lý do: '.
                    ($blacklist->reason ?: 'Chưa rõ')
                    .'. Bạn sẽ được chat lại sau: '
                    .($blacklist->free_at?->diffForHumans() ?: 'Chưa rõ thời hạn')
            ]);
        }

        // Chat 2 fast
        if (Message::where('guest_id', $guest->id)->where('created_at', '>=', now()->subSeconds(10))->count() >= 3) {
            throw ValidationException::withMessages([
                'text' => [
                    'Bạn chat quá nhanh!'
                ]
            ]);
        }

        // Room is full
        if ($room->guest_count >= $room->guest_limit
            and intval($guest->room_id) !== intval($room->id)
        ) {
            throw ValidationException::withMessages([
                'room_id' => [
                    'Không thể gửi tin nhắn vì phòng đã đầy. Hãy thử lại sau.'
                ]
            ]);
        }

        // Create new message
        $message = new Message();
        $message->room_id = $room->id;
        $message->guest_id = $guest->id;
        $message->text = $data['text'];
        $message->save();

        return $message;
    }
}
