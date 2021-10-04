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
     * @var array
     */
    public $second = [];

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
        }
        for ($x = 0; $x < $game->size_x; $x++) {
            for ($y = 0; $y < $game->size_y; $y++) {
                $wolf = $animals->where('x', $x)->where('y', $y)->where('type', 'wolf')->all();
                if ($animals->where('x', $x)->where('y', $y)->where('type', 'hare')->count() > 1 && count($wolf) > 0) {
                    $this->pushArray('on_one_cage', $animals->where('x', $x)
                        ->where('y', $y)
                        ->where('type', 'hare')
                        ->all(), $wolf);
                }
                if ($animals->where('x', $x + 1)->where('y', $y)->where('type', 'hare')->count() > 1 && count($wolf) > 0) {
                    $this->pushArray('on_right_cell', $animals->where('x', $x + 1)
                        ->where('y', $y)
                        ->where('type', 'hare')
                        ->all(), $wolf);
                }
                if ($animals->where('x', $x - 1)->where('y', $y)->where('type', 'hare')->count() > 1 && count($wolf) > 0) {
                    $this->pushArray('on_left_cell', $animals->where('x', $x - 1)
                        ->where('y', $y)
                        ->where('type', 'hare')
                        ->all(), $wolf);
                }
                if ($animals->where('x', $x)->where('y', $y + 1)->where('type', 'hare')->count() > 1 && count($wolf) > 0) {
                    $this->pushArray('on_top_cell', $animals->where('x', $x)
                        ->where('y', $y + 1)
                        ->where('type', 'hare')
                        ->all(), $wolf);
                }
                if ($animals->where('x', $x)->where('y', $y - 1)->where('type', 'hare')->count() > 1 && count($wolf) > 0) {
                    $this->pushArray('on_bottom_cell', $animals->where('x', $x)
                        ->where('y', $y - 1)
                        ->where('type', 'hare')
                        ->all(), $wolf);
                }
            }
//            if ($first) {
//                array_push(this->second, $first);
//            }
            $first = null;
        }
        throw new HttpResponseException(response()->json($this->second, 422));
    }

    public function pushArray($shove, $queue, $wolf)
    {
        $this->second[$shove] = ['wolf' => array_values($wolf), 'hares' => array_values($queue)];
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
        }
        $animal->save();
    }


}
