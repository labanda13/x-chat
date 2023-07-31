<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetGuest;
use App\Http\Requests\StoreGuest;
use App\Models\Guest;
use App\Models\Room;
use App\Support\RequestClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class GuestController extends Controller
{
    /**
     * New guest
     *
     * @param StoreGuest $request
     * @return array
     */
    public function store(StoreGuest $request)
    {
        $data = $request->validated();

        // Make new guest
        $guest = Guest::firstOrNew([
            'nickname' => $data['nickname']
        ]);
        if ($guest->id and $guest->ip !== RequestClient::ip()) {
            throw ValidationException::withMessages([
                'nickname' => 'Nickname này đã có người khác dùng mất rồi.'
            ]);
        }

        $guest->age = $data['age'];
        $guest->gender = $data['gender'];
        $guest->ip = RequestClient::ip();
        $guest->key = sha1(Str::random());
        $guest->save();

        return [
            'key' => $guest->key
        ];
    }

    /**
     * Get guest
     *
     * @param GetGuest $request
     * @return mixed
     */
    public function me(GetGuest $request)
    {
        $data = $request->validated();
        $guest = Guest::where('key', $data['key'])->first();
        if (!$guest) {
            abort(404, 'Guest profile not found');
        }

        if ($roomId = @$data['room_id']
            and $room = Room::find($roomId)
            and $room->guest_limit > $room->guest_count
        ) {
            $guest->room_id = $room->id;
        }

        $guest->touch();
        return $guest;
    }
}
