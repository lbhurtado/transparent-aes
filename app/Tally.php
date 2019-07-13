<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use LBHurtado\Ballot\Models\{Position, Candidate};

class Tally extends Model
{
//    public function getCandidateAttribute($value)
//    {
//        return Str::lower($value);
////        return Str::title($value);
//    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

}
