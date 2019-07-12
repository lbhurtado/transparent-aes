@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-sm">
                <tbody>
                @foreach($positions as $position)
                    <tr>
                        <td colspan="3">{{ $position->name }}</td>
                    </tr>
                    <?php $i = 0; ?>
                    @foreach($position->candidates->sortByDesc('votes') as $candidate)
                        <tr>
                            <td>{{ ++$i }}.</td>
                            <td>{{ $candidate->code }}</td>
                            <td class="text-right">{{ $candidate->votes->count() }}</td>
                        </tr>

                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
