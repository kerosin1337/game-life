<?php

namespace App\Http\Controllers;

use App\Http\Requests\Animal\CreateAnimalRequest;
use App\Http\Requests\Animal\CreateMoreAnimalRequest;
use App\Models\Animal;
use App\Models\Game;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Animal\CreateAnimalRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function create(CreateAnimalRequest $request)
    {
        return response()->json([
            'data' => Animal::create($request->validated()),
            'message' => 'Created.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Animal\CreateMoreAnimalRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function createMore(CreateMoreAnimalRequest $request): \Illuminate\Http\JsonResponse
    {
        $animals = [];
        $game = Game::find($request->get('game_id'));
        for ($i = 0; $i < $request->get('numbers_of_animal'); $i++) {
            $validateData = $request->except('numbers_of_animal');
            $validateData['x'] = random_int(0, $game->size_x - 1);
            $validateData['y'] = random_int(0, $game->size_y - 1);
            $animals[] = Animal::create($validateData);
        }
        return response()->json([
            'data' => $animals,
            'message' => 'Created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
