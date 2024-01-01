<?php

namespace App\Http\Controllers\Api\V1;



use App\Helpers\CheckBoard;
use App\Http\Requests\Api\V1\Member\AddMemberRequest;
use App\Http\Resources\Api\V1\MemberResource;
use App\Models\AccessLevel;
use App\Models\Board;
use App\Models\Member;
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

    /**
     * @param $boardCode
     * @param AddMemberRequest $request
     * @return JsonResponse
     */
    public function store($boardCode, AddMemberRequest $request)
    {
        $board = Board::withBoardCode($boardCode)->first();

        if (!CheckBoard::hasAccessTo(Auth::user(), $board, 'AM'))
            return $this->easyResponse(false, [], 403, 'You have not permission to do this action!');

        $member = User::where('email', $request->get('email'))->first();
        $isMember = CheckBoard::isMember($member, $board);
        if ($isMember)
            $board->members()->whereUserId($member->id)->update([
                'access_level' => $request->get('access_level'),
                'expiration' => $request->get('expiration', null)
            ]);
        else
            $board->members()->create([
                'access_level' => $request->get('access_level'),
                'expiration' => $request->get('expiration', null),
                'user_id' => $member->id
            ]);

        return $this->easyResponse(true, [], 200, $isMember ? 'The member updated successfully.' : 'New member joined to the board successfully.');
    }

    public function disable($boardCode, $memberId)
    {
        $member = Board::withBoardCode($boardCode)->members()->find($memberId);
        if (!$member)
            return $this->easyResponse(false, [], 404, 'The member not found!');
    }
}
