Election Return

Ballots processed: {!! str_pad($ballot_count, 3, ' ', STR_PAD_LEFT) !!}

@foreach($positions as $position)
{!! $position->name !!}
<?php $i = 0; ?>
@foreach($position->candidates->sortByDesc('votes') as $candidate)
{!! mb_str_pad(str_pad(++$i . ".", 4, " ") . $candidate->code, 18, ".", STR_PAD_RIGHT) !!}{!! str_pad($candidate->votes->count(), 4, " ", STR_PAD_LEFT) !!}
@endforeach

@endforeach
