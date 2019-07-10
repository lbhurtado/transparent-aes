<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function dropView(): string
    {
        return <<<SQL
DROP VIEW IF EXISTS tallies;
SQL;
    }

    private function createView(): string
    {
        return <<<SQL
CREATE VIEW tallies AS 
    select p.name as position, c.name as candidate, cast(sum(bc.votes) as unsigned) as votes, p.seats from ballot_candidate bc
    inner join candidates c on c.id = bc.candidate_id
    inner join positions p on p.id = c.position_id
    group by bc.candidate_id
    order by p.id, votes  desc
SQL;
    }
}
