<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use LBHurtado\Ballot\Models\{Position, Candidate};

class Tally extends Model
{
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function getTaraAttribute()
    {
        $value = $this->attributes['votes'];
        $multiples = intdiv($value,5);
        $remainder = $value % 5;

        $retval = '';
        for ($i=1; $i<= $multiples; $i++){
            $retval .= 'e';
        }
        switch ($remainder) {
            case 1:
                $retval .= 'a';
                break;
            case 2:
                $retval .= 'b';
                break;
            case 3:
                $retval .= 'c';
                break;
            case 4:
                $retval .= 'd';
                break;
        }

        return $retval;
    }

}
