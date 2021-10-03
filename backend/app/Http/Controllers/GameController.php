<?php

namespace App\Http\Controllers;

use App\Events\NextStepGameEvent;
use App\Http\Requests\Game\CreateGameRequest;
use App\Http\Requests\Game\ShowGameByIdRequest;
use App\Models\Animal;
use App\Models\Game;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
     * @param \App\Http\Requests\Game\CreateGameRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateGameRequest $request)
    {
        return response()->json([
            'data' => Game::create($request->validated()),
            'message' => 'Created.'
        ]);
    }


    public function show($id, ShowGameByIdRequest $request): \Illuminate\Http\JsonResponse
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
     * Display the specified resource.
     * @param \App\Http\Requests\Game\ShowGameByIdRequest $request
     * @param int $id
     */
    public function nextStep($id, ShowGameByIdRequest $request)
    {
        Animal::checkAnimalsInGame($id);
        event(new NextStepGameEvent(Game::find($id)));
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
