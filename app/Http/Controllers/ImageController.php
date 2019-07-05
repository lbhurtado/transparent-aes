<?php

namespace App\Http\Controllers;

use App\Image;
use LBHurtado\Ballot\Models\Ballot;
use App\Http\Requests\BallotImageRequest;

class ImageController extends Controller
{
    public function store(BallotImageRequest $request)
    {
        $image = Image::persist($request)->transfuseQRCode();
        $ballot = Ballot::updateOrCreate(['code' => $image->qr_code], ['image' => $image->url]);

        return $ballot->with('positions')->get();
    }
}
