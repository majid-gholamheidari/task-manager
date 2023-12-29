<?php

namespace App\Http\Controllers\Api\V1;



use App\Helpers\CheckBoard;
use App\Http\Requests\Api\V1\Member\AddMemberRequest;
use App\Http\Resources\Api\V1\MemberResource;
use App\Models\AccessLevel;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MemberController extends MainController
{

    /**
     * Members list of board
     * @param $boardCode
     * @return JsonResponse
     */
    public function index($boardCode)
    {
        $board = Board::withBoardCode($boardCode)->first();
        if (!$board)
            return $this->easyResponse(false, [], 404, 'There is not any board with ' . $boardCode . ' board code!');
        $user = Auth::user();

        return $this->easyResponse(true, MemberResource::collection($board->members), 200, 'Your board updated successfully.');
    }

    public function store($boardCode, AddMemberRequest $request)
    {
        $board = Board::withBoardCode($boardCode)->first();
        if (!$board)
            return $this->easyResponse(false, [], 404, 'There is not any board with ' . $boardCode . ' board code!');

        if (!CheckBoard::hasAccessTo(Auth::user(), $board, 'AM'))
            return $this->easyResponse(false, [], 404, 'You have not permission to do this action!');

        $member = User::where('email', $request->get('email'))->first();
        if (!CheckBoard::isMember($member, $board))
            return $this->easyResponse(false, [], 404, 'The user exists in the board members.');

        $accessLevel = AccessLevel::whereTitle($request->get('access_level'))->first();
        $board->members()->create([
            'access_level_id' => $accessLevel->id,
            'user_id' => $member->id,
            ''
        ]);
    }
}
