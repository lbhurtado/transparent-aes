<?php

namespace App\Http\Controllers;

use App\Image;
use LBHurtado\Ballot\Models\Ballot;
use App\Http\Requests\BallotImageRequest;

class ImageController extends Controller
{
    public function store(BallotImageRequest $request)
    {
        $image = tap(Image::create($request->only(['sender_mac_address'])), function ($img) {
            $img->addMediaFromRequest('image')->toMediaCollection('ballots');
        })->extractQRCode();

        $ballot = Ballot::updateOrCreate(['code' => $image->qr_code], ['image' => $image->getFirstMediaUrl('ballots')]);

        return $ballot->with('positions')->get();
    }
}
