@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Ballot Id# {{ __($ballot->code) }} ({{ __($ballot->id) }} / {{ __($ballot->count()) }})</div>
                    @foreach($positions as $position)
                        <div class="card-header">{{ __($position->name) }} (choose {{ $position->seats }})</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('ballot-candidate') }}">
                                @csrf
                                <input type="hidden" name="ballot_code" value="{{ __($ballot->code) }}">
                                <div class="btn-group-vertical btn-block">
                                    @php
                                        $count = $position->candidates()->whereHas('votes', function ($q) use ($ballot) {
                                            $q->where('votes', 1)->where('ballot_id', $ballot->id);
                                        })->count();
                                        $seat_id = $count%$position->seats + 1;
                                    @endphp
                                    {{ $count }} / {{ $position->seats }}
                                    @foreach($position->candidates as $candidate)
                                        @if($candidate->votes()->whereHas('ballot', function ($q) use ($ballot) {$q->where('id', $ballot->id);})->count() === 1 )
                                            @php
                                                $style='btn-primary';

                                            @endphp
                                        @else
                                            @php
                                                $style='btn-secondary';
                                            @endphp
                                        @endif
                                        <input type="hidden" name="seat_id" value="{{ $seat_id }}">
                                        <button type="submit" class="btn {{ $style }} btn-block" name="candidate_code" value="{{ __($candidate->code) }}">
                                            {{ __($candidate->code) }}
                                        </button>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
