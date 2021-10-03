<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGameRequest;
use App\Models\Animal;
use App\Models\Game;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateGameRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateGameRequest $request)
    {
        return response()->json([
            'data' => Game::create($request->validated()),
            'message' => 'Created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $game['field'] = Game::find($id);
        $game['hare'] = Animal::where('game_id', $id)->where('type', 'hare')->get();
        $game['wolf'] = Animal::where('game_id', $id)->where('type', 'wolf')->get();
        return response()->json([
            'data' => $game,
            'message' => 'Received.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
