<?php

namespace App\Http\Requests\Game;

use App\Http\Requests\APIRequest;

class ShowGameByIdRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:games,id'
        ];
    }

    public function all($keys = null): array
    {
        $request = parent::all();
        $request['id'] = $this->route('id');
        return $request;
    }
}
