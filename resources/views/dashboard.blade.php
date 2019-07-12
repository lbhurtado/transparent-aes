@extends('layouts.screen')

@section('content')
    <div class="container">
        <div class="row no-gutters">
            <div class="col-sm-4">
                <div class="row no-gutters text-center">
                    <div class="col-sm-12"><h4><h1>{{ $ballot->code }}</h1></h4></div>
                </div>
                <div class="row no-gutters text-center">
                    <div class="col-sm-4"><h4>OK</h4></div>
                    <div class="col-sm-4"><h4>OK</h4></div>
                    <div class="col-sm-4"><h4>OK</h4></div>
                </div>
                <div class="row no-gutters small">
                    <div class="col-sm-4">
                        <table class="table table-sm">
                            <tbody>
                            @foreach($col_1 as $position)
                                @php
                                    $candidate = $position->pivot->candidate;
                                @endphp
                                @if(in_array($position->id, [1]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                    </tr>
                                @endif
                                @if(in_array($position->id, [2]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                    </tr>
                                @endif
                                @if(in_array($position->id, [3]))
                                    @if(in_array($position->pivot->seat_id, [1,3,5,7,9,11]))
                                        <tr class="bg-primary text-white">
                                            <td>{{ $position->name }} {{ $position->pivot->seat_id }}</td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tbody>
                            @foreach($col_2 as $position)
                                @php
                                    $candidate = $position->pivot->candidate;
                                @endphp
                                @if(in_array($position->id, [6]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                    </tr>
                                @endif
                                @if(in_array($position->id, [7]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                    </tr>
                                @endif
                                @if(in_array($position->id, [3]))
                                    @if(in_array($position->pivot->seat_id, [2,4,6,8,10,12]))
                                        <tr class="bg-primary text-white">
                                            <td>{{ $position->name }} {{ $position->pivot->seat_id }}</td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            @foreach($party_list as $position)
                                @php
                                    $candidate = $position->pivot->candidate;
                                @endphp
                                @if(in_array($position->id, [4]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }} {{ $position->pivot->seat_id }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->name }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tbody>
                            @foreach($board_members as $position)
                                @php
                                    $candidate = $position->pivot->candidate;
                                @endphp
                                @if(in_array($position->id, [8]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }} {{ $position->pivot->seat_id }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            @foreach($col_3 as $position)
                                @php
                                    $candidate = $position->pivot->candidate;
                                @endphp
                                @if(in_array($position->id, [5]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                    </tr>
                                @endif
                                @if(in_array($position->id, [9]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                    </tr>
                                @endif
                                @if(in_array($position->id, [10]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            @foreach($councilors as $position)
                                @php
                                    $candidate = $position->pivot->candidate;
                                @endphp
                                @if(in_array($position->id, [11]))
                                    <tr class="bg-primary text-white">
                                        <td>{{ $position->name }} {{ $position->pivot->seat_id }}</td>
                                    </tr>
                                    <tr>
                                        <td><font color="red">[{{ $candidate->sequence }}]</font> {{ $candidate->code }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <img class="img-fluid" src="{{ asset($ballot->image) }}">
            </div>
        </div>
    </div>
@endsection
