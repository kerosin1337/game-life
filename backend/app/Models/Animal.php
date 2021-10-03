<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animals';

    protected $fillable = [
        'id',
        'type',
        'game_id',
        'x',
        'y'
    ];


    /**
     * @param $id
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public static function checkAnimalsInGame($id)
    {
        $numberOfHares = self::whereGameId($id)->whereType('wolf')->count();
        $numberOfWolves = self::whereGameId($id)->whereType('hare')->count();
        $error[] = $numberOfHares > 0 ? null : 'The number of hares is not enough for the game.';
        $error[] = $numberOfWolves > 0 ? null : 'The number of wolves is not enough for the game.';
        $error = array_values(array_diff($error, [false]));
        if (!empty($error)) {
            throw new HttpResponseException(response()->json([
                'animals' => array_values(array_diff($error, []))
            ], 422));
        }
    }
}
