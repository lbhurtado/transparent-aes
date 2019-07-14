@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-sm">
                <tbody>
                @foreach($groups as $position_name => $tallies)
                    <tr>
                        <td colspan="2">{{ $position_name }}</td>
                        <td>Votes</td>
                    </tr>
                    <?php $i = 0; ?>
                    @foreach($tallies as $tally)
                        <tr>
                            <td>rank {{ ++$i }}</td>
                            <td>{{ mb_convert_case($tally->candidate->name, MB_CASE_TITLE) }} (#{{$tally->candidate->sequence}})</td>
{{--                            <td>{{ $tally->votes }}</td>--}}
                            <td class="tally_font">{{ $tally->tara }}</td>
                        </tr>

                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
