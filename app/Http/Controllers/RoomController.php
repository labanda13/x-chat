<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Get list public rooms
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return Room::where('visibility', Room::VISIBILITY_PUBLIC)
            ->where('status', Room::STATUS_ACTIVE)
            ->orderByDesc('guest_count')
            ->get();
    }

    /**
     * Get room
     *
     * @param Request $request
     * @param Room $room
     * @return array
     */
    public function show(Request $request, Room $room)
    {
        return array_merge($room->toArray(), [
            'messages' => array_reverse($room->messages()
                ->orderByDesc('id')
                ->take($room->message_limit)
                ->with('guest')
                ->get()
                ->toArray())
        ]);
    }
}
