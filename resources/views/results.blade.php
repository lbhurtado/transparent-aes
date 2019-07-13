@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-sm">
                <tbody>
                @foreach($groups as $position_name => $tallies)
                    <tr>
                        <td colspan="3">{{ $position_name }}</td>
                    </tr>
                    <?php $i = 0; ?>
                    @foreach($tallies as $tally)
                        <tr>
                            <td>{{ ++$i }}.</td>
                            <td>{{ mb_convert_case($tally->candidate->name, MB_CASE_TITLE) }}</td>
                            <td class="text-right">{{ $tally->votes }}</td>
                        </tr>

                    @endforeach
                @endforeach
                </tbody>
            </table>
            <div id="tally">
                <svg>
                    <path
                        d="M 200 0 s 1 0 0 6 2 8 0 12">
                    </path>
                    <path
                        d="M 207 0 s -1 0 0 3 -2 12 -1 15">
                    </path>
                    <path
                        d="M 214 0 s 0 2 0 3 -1 4 0 7 -1 8 -1 10">
                    </path>
                    <path
                        d="M 220 0 s 1 0 0 6 2 8 0 12">
                    </path>
                    <path
                        d="M 193 -1 s 10 8 13 8 30 9 25 10">
                    </path>
                </svg>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="512" height="128">
                    <path fill="#000" d="M1,7l9-6l3,118l-9,6zm60,0l9-6l3,118l-9,6zm22
0l9-6l3,118l-9,6zm60,0l9-6l3,118l-9,6zm22,0l9-6l3,118l-9,6zm22
0l9-6l3,118l-9,6zm60,0l9-6l3,118l-9,6zm22,0l9-6l3,118l-9,6zm22
0l9-6l3,118l-9,6zm22,0l9-6l3,118l-9,6zm87,0l9-6l3,118l-9,6zm22
0l9-6l3,118l-9,6zm22,0l9-6l3,118l-9,6zm22,0l9-6l3,118l-9,6zm44
94-7,7-132-85 7-7z"/>
                </svg>
            </div>
        </div>
    </div>
@endsection
