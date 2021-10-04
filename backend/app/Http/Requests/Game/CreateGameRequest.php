<?php

namespace App\Http\Requests\Game;

use App\Http\Requests\APIRequest;

class CreateGameRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'size_x' => 'required|integer|min:2|max:50',
            'size_y' => 'required|integer|min:2|max:50',
            'steps_to_die' => 'required|integer|min:1|max:100',
        ];
    }

}
