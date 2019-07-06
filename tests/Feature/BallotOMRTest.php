<?php

namespace Tests\Feature;

use App\Image;
use Tests\TestCase;
use Illuminate\Support\Arr;
use LBHurtado\Ballot\Models\Ballot;
use LBHurtado\BallotOMR\Facades\BallotOMR;

class BallotOMRTest extends TestCase
{
    /** @test */
    public function OMR_works()
    {
        /*** arrange ***/
        $ballot = Ballot::first();
        $image = Image::where('qr_code', $ballot->code)->first();

        /*** assert ***/
        $this->assertTrue(file_exists($image->path));

        /*** act */
        $omr = tap(BallotOMR::setImage($image->path))->process();

        /*** arrange ***/
        $map = json_decode(file_get_contents($omr->omr->getMapPath()), true);
        $mapGroups = Arr::pluck($map['groups'], 'groupname');
        $resultGroups = Arr::pluck($omr->omr->omr->getResult(), 'groupname');

        /*** assert ***/
        $this->assertEquals($mapGroups, $resultGroups);
    }
}
