<?php

namespace App\Http\Controllers;

use App\Image;
use App\Http\Requests\BallotImageRequest;

class ImageController extends Controller
{
    public function store(BallotImageRequest $request)
    {
        $image = Image::create($request->only(['sender_mac_address']));
        $image->addMediaFromRequest('image')->toMediaCollection('ballots');

        return $image->with('media')->get();
    }
}
