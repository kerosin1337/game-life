<?php

namespace App\Listeners;

use App\Events\NextStepGameEvent;
use App\Models\Animal;
use App\Models\Game;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Queue\InteractsWithQueue;

class NextStepGameListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param NextStepGameEvent $event
     * @return void
     * @throws \Exception
     */
    public function handle(NextStepGameEvent $event)
    {

        /**
         * @var object $game
         */
        $game = $event->game;
        $animals = $game->animals;
        foreach ($animals as $animal) {
            $this->stepDirection($animal, $game);
//            $animal->update([
//                'x' => random_int(0, $game->size_x),
//                'y' => random_int(0, $game->size_y)
//            ]);
        }
        $second = [];
        $first = [];
        for ($x = 0; $x < $game->size_x; $x++) {
            for ($y = 0; $y < $game->size_y; $y++) {
                if ($animals->where('x', $x)->where('y', $y)->count() > 1) {
                    $first = $animals->where('x', $x)->where('y', $y)->all();
                }
            }
            if ($first) {
                array_push($second, array_values($first));
            }
            $first = null;
        }
        throw new HttpResponseException(response()->json($second, 422));
    }

    /**
     * @throws \Exception
     */
    public function stepDirection(Animal $animal, Game $game)
    {
        while (true) {
            switch (random_int(0, 3)) {
                case 0:
                    if (($animal->x + 1) > $game->size_x) {
                        break;
                    }
                    $animal->x++;
                    break 2;
                case 1:
                    if (($animal->y + 1) > $game->size_y) {
                        break;
                    }
                    $animal->y++;
                    break 2;
                case 2:
                    if (($animal->x - 1) < 0) {
                        break;
                    }
                    $animal->x--;
                    break 2;
                case 3:
                    if (($animal->y - 1) < 0) {
                        break;
                    }
                    $animal->y--;
                    break 2;
            }
//            $animal->x = $direction === 0 ? ++$animal->x : $animal->x;
//            $animal->y = $direction === 1 ? ++$animal->y : $animal->y;
//            $animal->x = $direction === 2 ? --$animal->x : $animal->x;
//            $animal->y = $direction === 3 ? --$animal->y : $animal->y;

        }
        $animal->save();
    }

}
