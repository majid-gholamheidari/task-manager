<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Board extends Model
{

    const Active = "active";
    const Inactive = "inactive";

    protected $fillable = [
        'board_code',
        'title',
        'description',
        'status',
        'progress',
        'user_id'
    ];


    /**
     * generate unique and random board code
     * @return string
     */
    public static function generateBoardCode(): string
    {
        $boardCode = strtoupper(Str::random(8));
        if (Board::withBoardCode($boardCode)->exists())
            return self::generateBoardCode();
        return $boardCode;
    }

    /**
     * @param $query
     * @param $boardCode
     * @return mixed
     */
    public function scopeWithBoardCode($query, $boardCode): mixed
    {
        return $query->where('board_code', $boardCode);
    }

    /**
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeOfUser($query, $userId): mixed
    {
        return $query->where('user_id', $userId);
    }

    /**
     * @return BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Member::class);
    }
}
