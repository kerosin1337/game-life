<?php

namespace App\Listeners;

use App\Events\NextStepGameEvent;
use App\Models\Animal;
use App\Models\Game;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;

class NextStepGameListener
{
    /**
     * @var array
     */
    public $second = [];
    /**
     * @var Collection
     */
    public $animals = [];
    /**
     * @var array
     */
    public $messages = [];

    /**
     * @var string[]
     */
    public $listOfDirections = [
        1 => 'on_one_cage',
        2 => 'on_right_cell',
        3 => 'on_left_cell',
        4 => 'on_top_cell',
        5 => 'on_bottom_cell',
        6 => 'on_top_left_cell',
        7 => 'on_bottom_left_cell',
        8 => 'on_top_right_cell',
        9 => 'on_bottom_right_cell',
    ];

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
        $this->animals = $game->animals;
        foreach ($this->animals as $key => $animal) {
            $this->stepDirection($animal, $game, $key);
        }
        for ($x = 0; $x < $game->size_x; $x++) {
            for ($y = 0; $y < $game->size_y; $y++) {
                $wolves = $this->animals->where('x', $x)->where('y', $y)->where('type', 'wolf')->all();
                if ($this->animals->where('x', $x)->where('y', $y)->where('type', 'hare')->count() > 0 && count($wolves) > 0) {
                    $first['on_one_cage'] = [

                        'hares' => $this->animals->where('x', $x)
                            ->where('y', $y)
                            ->where('type', 'hare')
                            ->values(),
                        'wolves' => array_values($wolves)

                    ];
                }
                if ($this->animals->where('x', $x + 1)->where('y', $y)->where('type', 'hare')->count() > 0 && count($wolves) > 0) {
                    $first['on_right_cell'] = [

                        'hares' => $this->animals->where('x', $x + 1)
                            ->where('y', $y)
                            ->where('type', 'hare')
                            ->values(),
                        'wolves' => array_values($wolves)

                    ];
                }
                if ($this->animals->where('x', $x - 1)->where('y', $y)->where('type', 'hare')->count() > 0 && count($wolves) > 0) {
                    $first['on_left_cell'] = [

                        'hares' => $this->animals->where('x', $x - 1)
                            ->where('y', $y)
                            ->where('type', 'hare')
                            ->values(),
                        'wolves' => array_values($wolves)

                    ];
                }
                if ($this->animals->where('x', $x)->where('y', $y + 1)->where('type', 'hare')->count() > 0 && count($wolves) > 0) {
                    $first['on_top_cell'] = [

                        'hares' => $this->animals->where('x', $x)
                            ->where('y', $y + 1)
                            ->where('type', 'hare')
                            ->values(),
                        'wolves' => array_values($wolves)

                    ];
                }
                if ($this->animals->where('x', $x)->where('y', $y - 1)->where('type', 'hare')->count() > 0 && count($wolves) > 0) {
                    $first['on_bottom_cell'] = [

                        'hares' => $this->animals->where('x', $x)
                            ->where('y', $y - 1)
                            ->where('type', 'hare')
                            ->values(),
                        'wolves' => array_values($wolves)

                    ];
                }
                if ($this->animals->where('x', $x - 1)->where('y', $y + 1)->where('type', 'hare')->count() > 0 && count($wolves) > 0) {
                    $first['on_top_left_cell'] = [

                        'hares' => $this->animals->where('x', $x - 1)
                            ->where('y', $y + 1)
                            ->where('type', 'hare')
                            ->values(),
                        'wolves' => array_values($wolves)

                    ];
                }
                if ($this->animals->where('x', $x - 1)->where('y', $y - 1)->where('type', 'hare')->count() > 0 && count($wolves) > 0) {
                    $first['on_bottom_left_cell'] = [

                        'hares' => $this->animals->where('x', $x - 1)
                            ->where('y', $y - 1)
                            ->where('type', 'hare')
                            ->values(),
                        'wolves' => array_values($wolves)

                    ];
                }
                if ($this->animals->where('x', $x + 1)->where('y', $y + 1)->where('type', 'hare')->count() > 0 && count($wolves) > 0) {
                    $first['on_top_right_cell'] = [

                        'hares' => $this->animals->where('x', $x + 1)
                            ->where('y', $y + 1)
                            ->where('type', 'hare')
                            ->values(),
                        'wolves' => array_values($wolves)

                    ];
                }
                if ($this->animals->where('x', $x + 1)->where('y', $y - 1)->where('type', 'hare')->count() > 0 && count($wolves) > 0) {
                    $first['on_bottom_right_cell'] = [

                        'hares' => $this->animals->where('x', $x + 1)
                            ->where('y', $y - 1)
                            ->where('type', 'hare')
                            ->values(),
                        'wolves' => array_values($wolves)

                    ];
                }

                if (!empty($first)) {
                    $this->second[] = $first;
                    $first = [];
                }
            }

        }
//        if (!empty($this->second)) {
//            $this->eatingHares($this->second);
//        }
        if (empty($this->messages)) {
            $this->messages[] = 'As long as everyone is alive';
        }
        $this->second['messages'] = $this->messages;
        throw new HttpResponseException(response()->json($this->second, 422));
    }

    /**
     * @param $haresNearWolves
     */
    public function eatingHares($haresNearWolves)
    {
        foreach ($haresNearWolves as $hareNearWolf) {

        }
    }


    /**
     * @param Animal $animal
     * @param Game $game
     * @param int $key
     * @throws \Exception
     */
    public function stepDirection(Animal $animal, Game $game, int $key)
    {
        while (true) {
            switch (random_int(0, 3)) {
                case 0:
                    if (($animal->x + 1) >= $game->size_x) {
                        break;
                    }
                    $animal->x++;
                    break 2;
                case 1:
                    if (($animal->y + 1) >= $game->size_y) {
                        break;
                    }
                    $animal->y++;
                    break 2;
                case 2:
                    if ($animal->x == 0) {
                        break;
                    }
                    $animal->x--;
                    break 2;
                case 3:
                    if ($animal->y == 0) {
                        break;
                    }
                    $animal->y--;
                    break 2;
            }
        }
        if ($animal->type === 'wolf') {
            $animal->counter++;
            if ($animal->counter === $game->steps_to_die) {
                $this->messages[] = "Wolf #$animal->id starved to death";
                $this->animals->forget($key);
                $animal->delete();
            } else {
                $animal->save();
            }

        } else {
            $animal->save();
        }

    }
}
