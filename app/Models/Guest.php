<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname'
    ];

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';
    public const GENDER_GAY = 'gay';
    public const GENDER_LESS = 'less';

    public static function getGenders()
    {
        return [
            static::GENDER_MALE,
            static::GENDER_FEMALE,
            static::GENDER_GAY,
            static::GENDER_LESS
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'room_id' => $this->room_id,
            'nickname' => $this->nickname,
            'age' => $this->age,
            'gender' => $this->gender
        ];
    }
}
