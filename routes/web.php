<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use LBHurtado\Ballot\Models\{Ballot, Position};


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard/ballot/{code}', function ( $code) {
    $ballot = Ballot::whereCode($code)->first();
    $positions = Position::all();

    $col_1 = $ballot->positions->whereIn('id', [1,2,3])->where('pivot.votes','>',0)->sortBy('level')->sortBy('pivot.seat_id')->all();
    $col_2 = $ballot->positions->whereIn('id', [6,7,3,4])->where('pivot.votes','>',0)->sortBy('level')->sortBy('pivot.seat_id')->all();
    $party_list = $ballot->positions->whereIn('id', [4])->where('pivot.votes','>',0)->sortBy('pivot.seat_id')->sortBy('id')->all();
    $board_members = $ballot->positions->whereIn('id', [8])->where('pivot.votes','>',0)->sortBy('pivot.seat_id')->sortBy('id')->all();
    $col_3 = $ballot->positions->whereIn('id', [5,9,10])->where('pivot.votes','>',0)->sortBy('level')->all();
    $councilors = $ballot->positions->whereIn('id', [11])->where('pivot.votes','>',0)->sortBy('pivot.seat_id')->sortBy('id')->all();

    return view('dashboard', compact('ballot', 'positions', 'col_1', 'col_2', 'col_3', 'board_members', 'councilors', 'party_list'));
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/ballot', 'BallotController@index')->name('ballot');
Route::post('/ballot/candidate', 'BallotController@store')->name('ballot-candidate');
Route::get('/tally', function() {
    $ballot_count = Ballot::all()->count();
    $positions = Position::all()->sortBy('id');
    $index = 1;

    return response()
        ->view('tally', compact('positions', 'ballot_count'), 200)
        ->header('Content-Type', 'text/plain')
        ;
})->name('status');
Route::get('/results', function () {
    $positions = Position::all()->sortBy('id');

    return view('results', compact('positions'));
})->name('results');

Route::get('/dashboard/ballot', function () {
    $ballot = Ballot::all()->sortByDesc('id')->first();
    $positions = Position::all();

    $col_1 = $ballot->positions->whereIn('id', [1,2,3])->where('pivot.votes','>',0)->sortBy('level')->sortBy('pivot.seat_id')->all();
    $col_2 = $ballot->positions->whereIn('id', [6,7,3,4])->where('pivot.votes','>',0)->sortBy('level')->sortBy('pivot.seat_id')->all();
    $party_list = $ballot->positions->whereIn('id', [4])->where('pivot.votes','>',0)->sortBy('pivot.seat_id')->sortBy('id')->all();
    $board_members = $ballot->positions->whereIn('id', [8])->where('pivot.votes','>',0)->sortBy('pivot.seat_id')->sortBy('id')->all();
    $col_3 = $ballot->positions->whereIn('id', [5,9,10])->where('pivot.votes','>',0)->sortBy('level')->all();
    $councilors = $ballot->positions->whereIn('id', [11])->where('pivot.votes','>',0)->sortBy('pivot.seat_id')->sortBy('id')->all();

    return view('dashboard', compact('ballot', 'positions', 'col_1', 'col_2', 'col_3', 'board_members', 'councilors', 'party_list'));
});
