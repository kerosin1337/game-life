<?php

namespace App\Http\Requests;

use App\Models\Game;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (!$this->get('game_id')) {
            throw new HttpResponseException(response()->json([
                'game_id' => [
                    'The game_id field is required'
                ]
            ], 422));
        }
        $game = Game::find($this->get('game_id'));
        return [
            'game_id' => 'required|integer|exists:games,id',
            'type' => 'required|string|in:hare,wolf',
            'x' => 'required|integer|min:1|max:' . $game->size_x,
            'y' => 'required|integer|min:1|max:' . $game->size_y
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
