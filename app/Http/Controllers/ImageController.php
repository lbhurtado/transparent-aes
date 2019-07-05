<?php

namespace App\Http\Controllers;

use App\Image;
use App\Http\Requests\BallotImageRequest;

class ImageController extends Controller
{
    public function store(BallotImageRequest $request)
    {
        $image = tap(Image::create($request->only(['sender_mac_address'])), function ($img) {
            $img->addMediaFromRequest('image')->toMediaCollection('ballots');
        })->extractQRCode();

        return $image->with('media')->get();
    }
}
