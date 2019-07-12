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
    protected $description = 'Generate Ballot OMR Mapping';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Storage::put('generated-omr.json', $this->getOMRMapping());

        $this->info('OMR map written!');
    }

    protected function getOMRMapping()
    {
        $config = [
            'expectedwidth' => self::A4_WIDTH,
            'expectedheight' => self::A4_HEIGHT,
            'groups' => $this->groupings()
        ];
        $mapping = json_encode($config, JSON_PRETTY_PRINT);

        return $mapping;
    }

    protected function groupings()
    {
        $groups = [];
        $positions = Position::all()->sortBy('id');
        $positions->whereIn('id', [1,2,3,4,5,6,7,8,9,10,11])->each(function ($position) use (&$groups) {
            $mapping = config('ballot-image.mapping');
            for ($seat = 1; $seat <= $position->seats; $seat++) {
                $group['groupname'] = $position->seats > 1 ? "{$position->name}:{$seat}": $position->name;
                $points = $mapping[$group['groupname']];
                $group['grouptargets'] = [];
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
                $groups[] = $group;
            }
        });

        return $groups;
    }
}
