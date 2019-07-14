<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Arr;
use LBHurtado\Ballot\Models\Ballot;
use App\Http\Requests\BallotImageRequest;
use LBHurtado\Ballot\Models\{Position, Candidate};

class ImageController extends Controller
{
    const GROUPING_POSITION_ID_NDX = 0;
    const GROUPING_SEAT_NDX = 1;
    const DEFAULT_SEAT = 1;

    public function store(BallotImageRequest $request)
    {
        $image = $this->getImageFromRequest($request);
        $ballot = $this->getBallotFromImage($image);
        $answer_key = $this->getAnswerKey();

        foreach ($image->markings as $grouping => $choice) {
            if (empty($choice)) continue;
            list($position_id, $seat) = $this->getSeating($grouping);
            $position = Position::find($position_id);
            if ($seat <= $position->seats) {
                if ($candidate = $this->getCandidateFromChoice($answer_key, $choice)){
                    $ballot->updatePivot($candidate, $seat);
                }
            }
        }

        return $ballot->load('positions');
    }

    protected function getImageFromRequest(BallotImageRequest $request)
    {
        $image = Image::persist($request)
//            ->deskew()
            ->transfuseQRCode()
            ->processMarkings()
        ;

        return $image;
    }

    protected function getBallotFromImage(Image $image)
    {
        Ballot::updateOrCreate(['code' => $image->qr_code], ['image' => $image->url]);

        return Ballot::where('code', $image->qr_code)->firstOrFail();
    }

    protected function getAnswerKey(): array
    {
        $json = file_get_contents(base_path(config('app.answer_key')));

        return json_decode($json, true);
    }

    protected function getSeating($grouping): array
    {
        $seating = explode(':', $grouping);
        $position_id = Arr::get($seating, self::GROUPING_POSITION_ID_NDX);
        $seat = Arr::get($seating, self::GROUPING_SEAT_NDX, self::DEFAULT_SEAT);

        return [$position_id, $seat];
    }

    protected function getCandidateFromChoice($answer_key, $choice): ?Candidate
    {
        list($position_id, $sequence) = explode(':', $choice);

        $key = "{$position_id}.{$sequence}";
        $candidate_code = Arr::get($answer_key, $key);

        return Candidate::whereCode($candidate_code)->first();
    }
}
