<?php

use Illuminate\Database\Seeder;

use LBHurtado\Ballot\Models\{Ballot, Position, Candidate};

class BallotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ballots = factory(Ballot::class, 100)->create();
        $ballots->each(function ($ballot) {
            $positions = Position::all();
            $positions->each(function ($position) use ($ballot) {
               for ($i=1; $i<= $position->seats; $i++) {
                   $candidate = Candidate::where('position_id', $position->id)->get()->random();
                   $ballot->updatePivot($candidate, $i);
               }
            });
        });
    }
}
