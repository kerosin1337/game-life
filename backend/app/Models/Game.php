<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'id',
        'size_x',
        'size_y',
        'steps_to_die'
    ];


    public function animals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Animal::class);
    }

}
