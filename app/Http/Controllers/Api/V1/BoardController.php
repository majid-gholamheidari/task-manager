<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Paginator;
use App\Http\Requests\Api\V1\Board\SaveBoardRequest;
use App\Http\Resources\Api\V1\BoardResource;
use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BoardController extends MainController
{

    /**
     * List of user boards
     * @return JsonResponse
     */
    public function index()
    {
        $boards = Paginator::paginate(Auth::user()->boards());
        $boards['items'] = BoardResource::collection($boards['items']);
        return $this->easyResponse(true, $boards, 200, $boards['meta']['total_items'] > 0 ? 'Check your boards.' : 'Create your first board.');
    }

    /**
     * Create new board
     * @param SaveBoardRequest $request
     * @return JsonResponse
     */
    public function store(SaveBoardRequest $request)
    {
        $board = Auth::user()->boards()->create([
            'board_code' => Board::generateBoardCode(),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'progress' => 0,
        ]);
        return $this->easyResponse(true, new BoardResource($board), 200, 'Your board created successfully.');
    }

    /**
     * Update specific board
     * @param $boardCode
     * @param SaveBoardRequest $request
     * @return JsonResponse
     */
    public function update($boardCode, SaveBoardRequest $request)
    {
        $board = Board::withBoardCode($boardCode)->ofUser(auth()->id())->first();
        if (!$board)
            return $this->easyResponse(false, [], 404, 'You Have not any board with ' . $boardCode . ' board code!');
        $board->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
        ]);
        return $this->easyResponse(true, new BoardResource($board), 200, 'Your board updated successfully.');
    }
}
