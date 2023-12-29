<?php

namespace App\Helpers;

use App\Models\AccessLevel;
use App\Models\Board;
use App\Models\User;

class CheckBoard
{

    /**
     * @param User $user
     * @param Board $board
     * @param string $accessTitle
     * @return bool
     */
    public static function hasAccessTo(User $user, Board $board, string $accessTitle): bool
    {
        $accessLevel = AccessLevel::whereTitle($accessTitle)->first();
        if ($board->user_id == $user->id || $board->members()->whereAccessLevelId($accessLevel->id ?? null)->whereUserId($user->id)->exists())
            return true;
        return false;
    }

    /**
     * @param User $user
     * @param Board $board
     * @return bool
     */
    public static function isMember(User $user, Board $board): bool
    {
        if ($board->user_id == $user->id || $board->members()->where('user_id', $user->id)->exists())
            return true;
        return false;
    }
}
