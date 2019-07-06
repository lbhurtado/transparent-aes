<?php

namespace App\Http\Controllers;

use App\Image;
use LBHurtado\Ballot\Models\Ballot;
use App\Http\Requests\BallotImageRequest;
use LBHurtado\BallotOMR\Facades\BallotOMR; //TODO: put this in a job

class ImageController extends Controller
{
    public function store(BallotImageRequest $request)
    {
        $image = Image::persist($request)->transfuseQRCode();
        $ballot = Ballot::updateOrCreate(['code' => $image->qr_code], ['image' => $image->url]);

        BallotOMR::setImage($image->path)->process();

        return $ballot->with('positions')->get();
    }
}
