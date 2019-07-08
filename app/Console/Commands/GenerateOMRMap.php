<?php

namespace App\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use LBHurtado\Ballot\Models\{Position, Candidate};

class GenerateOMRMap extends Command
{
    const A4_WIDTH = 2480;
    const A4_HEIGHT = 3508;
    const MARKER_WIDTH = 42;
    const MARKER_HEIGHT = 24;
    const MARKER_TYPE = 'rectangle';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ballot-omr:generate:map';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Ballot OMR Map';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $omr = [
            'expectedwidth' => self::A4_WIDTH,
            'expectedheight' => self::A4_HEIGHT,
            'groups' => $this->groups()
        ];

        $map = json_encode($omr, JSON_PRETTY_PRINT);

        Storage::put('generated-omr.json', $map);

        $this->info('OMR map written!');
    }

    protected function groups()
    {
        $ar = [
            'President' => [
                [66,  366],
                [144, 366],
                [222, 366],
                [300, 366],
                [378, 366],
                [456, 366],
            ],
            'Vice-President' => [
                [66,  528],
                [144, 528],
                [222, 528],
                [300, 528],
            ],
            'Board Member:1' => [
                [66,  1000],
                [144, 1000],
                [222, 1000],
            ],
            'Board Member:2' => [
                [66,  2000],
                [144, 2000],
                [222, 2000],
            ],
            'Board Member:3' => [
                [66,  3000],
                [144, 3000],
                [222, 3000],
            ],
        ];

        $retval = [];
        $group = [];
        $positions = Position::all()->sortBy('id');
        $positions->whereIn('id', [1,2,8])->each(function ($position) use (&$retval, $ar) {
            for ($seat = 1; $seat <= $position->seats; $seat++) { 
                $group['groupname'] = $seat > 1 ? "{$position->name}:{$seat}": $position->name;
                // $group['groupname'] = $position->name;
                $points = $ar[$position->name];
                $position->candidates->each(function ($candidate) use (&$group, &$points) {
                    $point = array_shift($points);
                    $group['grouptargets'][] = [
                        'x' => $point[0],  
                        'y' => $point[1], 
                        'width' => self::MARKER_WIDTH, 
                        'height' => self::MARKER_HEIGHT, 
                        'type' => self::MARKER_TYPE, 
                        'id' => $candidate->code
                    ];
                });
                $retval[] = $group;
            }

        });

        return $retval;
    }
}
