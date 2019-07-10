<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Arr;
use LBHurtado\Ballot\Models\Ballot;
use App\Http\Requests\BallotImageRequest;
use LBHurtado\Ballot\Models\{Position, Candidate};

class ImageController extends Controller
{
    public function store(BallotImageRequest $request)
    {
        $image = $this->getImageFromRequest($request);
        $ballot = $this->getBallotFromImage($image);

//        dd($image->markings);
//       dd($image->getMarkings());
        foreach ($image->markings as $group_id => $candidate_code) {
            if ($candidate = Candidate::where('code', $candidate_code)->first()){
                $ar = explode(':', $group_id);
                $position_code = Arr::get($ar, 0);
                $position = Position::where('name', $position_code)->first();
                $seat = Arr::get($ar, 1, 1);
                if ($seat <= $position->seats)
                    $ballot->updatePivot($candidate, $seat);
            }
        }

        return $ballot->load('positions');
    }

    protected function getImageFromRequest(BallotImageRequest $request)
    {
        $image = Image::persist($request)->deskew()->transfuseQRCode()->processMarkings();

        return $image;
    }

    protected function getBallotFromImage(Image $image)
    {
        Ballot::updateOrCreate(['code' => $image->qr_code], ['image' => $image->url]);

        return Ballot::where('code', $image->qr_code)->firstOrFail();
    }
}
