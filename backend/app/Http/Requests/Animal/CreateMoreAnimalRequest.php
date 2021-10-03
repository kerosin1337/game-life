<?php

namespace App\Http\Requests\Animal;


use App\Http\Requests\APIRequest;

class CreateMoreAnimalRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|string|in:hare,wolf',
            'numbers_of_animal' => 'required|integer|min:1',
            'game_id' => 'required|integer|exists:games,id'
        ];
    }

}
