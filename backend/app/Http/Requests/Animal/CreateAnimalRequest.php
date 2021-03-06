<?php

namespace App\Http\Requests\Animal;

use App\Http\Requests\APIRequest;
use App\Models\Game;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateAnimalRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (!$this->get('game_id')) {
            $this->returnThrow('The game_id field is required.');
        } elseif (!is_numeric($this->get('game_id'))) {
            $this->returnThrow('The game id must be an integer.');
        } elseif (!$game = Game::find($this->get('game_id'))) {
            $this->returnThrow('The selected game id is invalid.');
        }
        return [
            'game_id' => 'required|integer|exists:games,id',
            'type' => 'required|string|in:hare,wolf',
            'x' => 'required|integer|min:1|max:' . $game->size_x,
            'y' => 'required|integer|min:1|max:' . $game->size_y
        ];
    }


    public function returnThrow($message)
    {
        throw new HttpResponseException(response()->json([
            'game_id' => [
                $message
            ]
        ], 422));
    }
}
