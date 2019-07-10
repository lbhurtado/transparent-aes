<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tally extends Model
{
    public function getCandidateAttribute($value)
    {
        return Str::title($value);
    }
}
