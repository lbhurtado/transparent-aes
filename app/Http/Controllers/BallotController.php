<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use LBHurtado\Ballot\Models\{Ballot, Position, Candidate};

class BallotController extends Controller
{
    protected $client;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->client =  new \GuzzleHttp\Client();
    }

    public function index()
    {
        $ballot = Ballot::latest()->first();
        $ballot_code = $ballot->code;

        $ballot = Ballot::with('positions')
            ->where('code', $ballot_code)
            ->first();


        $positions = Position::all();

        // dd($positions->find(3)->candidates()->find(11)->votes()->whereHas('ballot', function ($q) {
        // 	$q->where('id', 1);
        // })->first()->seat_id);
        // dd($positions->find(1)->candidates()->find(3)->votes()->count());
        return view('ballot', compact('ballot', 'positions'));
    }

    public function store(Request $request)
    {
        $ballot_code = $request->input('ballot_code');

        $candidate_code = $request->input('candidate_code');
        $seat_id = $request->input('seat_id');

        $client = new \GuzzleHttp\Client();
        $url = "http://transparent-aes.app/api/ballot/candidate";

        $response = $client->request('POST', $url, ['json' => compact('ballot_code', 'candidate_code', 'seat_id')]);

        $ballot = Ballot::with('positions')
            ->where('code', $ballot_code)
            ->first();

        $positions = Position::all();

        return redirect('ballot');
        // return view('ballot', compact('ballot', 'positions'));
    }
}
