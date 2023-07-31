<?php

namespace App\Nova\Actions;

use App\Models\Blacklist;
use App\Models\Guest;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class BlacklistGuest extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $guests)
    {
        $guests->each(function (Guest $guest) use ($fields) {
            $blacklist = Blacklist::firstOrNew([
                'ip' => $guest->ip
            ]);
            $blacklist->reason = $fields->reason;
            $blacklist->free_at = $fields->minutes ? now()->addMinutes($fields->minutes) : null;
            $blacklist->save();

            // Delete all msg
            Message::where('guest_id', $guest->id)->delete();
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Reason')->nullable(),
            Number::make('Minutes')->nullable()
        ];
    }
}
