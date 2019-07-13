Election Return

Ballots processed: {!! str_pad($ballot_count, 10, ' ', STR_PAD_LEFT) !!}

@foreach($groups as $position_name => $tallies)
{!! $position_name !!}
<?php $i = 0; ?>
@foreach($tallies as $tally)
{!! mb_str_pad(str_pad(++$i . ".", 4, " ") . substr($tally->candidate->code, 0, 20), 25, ".", STR_PAD_RIGHT) !!}{!! str_pad($tally->votes, 4, " ", STR_PAD_LEFT) !!}
@endforeach

@endforeach

{{--@foreach($positions as $position)--}}
    {{--{!! $position->name !!}--}}
    {{--<?php $i = 0; ?>--}}
    {{--@foreach($position->candidates->sortByDesc('votes') as $candidate)--}}
        {{--{!! mb_str_pad(str_pad(++$i . ".", 4, " ") . $candidate->code, 18, ".", STR_PAD_RIGHT) !!}{!! str_pad($candidate->votes->count(), 4, " ", STR_PAD_LEFT) !!}--}}
    {{--@endforeach--}}

{{--@endforeach--}}
