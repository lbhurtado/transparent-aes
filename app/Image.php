<?php

namespace App;

use RobbieP\ZbarQrdecoder\ZbarDecoder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Http\Requests\BallotImageRequest as Request;

//TODO: make this a package
class Image extends Model implements HasMedia
{
    use HasMediaTrait;

    const MEDIA_COLLECTION = 'ballots';

    protected $fillable = [
        'sender_mac_address',
        'qr_code',
    ];

    public function registerMediaCollections()
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION)->singleFile();
    }

    public function transfuseQRCode()
    {
        tap(new ZbarDecoder(config('zbar')), function(ZbarDecoder $zbar) {
            tap($zbar->make($this->path), function ($result) {
                if ($result->getCode() == 200)
                    $this->update(['qr_code' => $result->getText()]);
            });
        });

        return $this;
    }

    public function getUrlAttribute()
    {
        return $this->getFirstMedia(self::MEDIA_COLLECTION)->getUrl();
    }

    public function getPathAttribute()
    {
        return $this->getFirstMedia(self::MEDIA_COLLECTION)->getPath();
    }

    public static function persist(Request $request)
    {
        return tap(static::firstOrCreate($request->only(['sender_mac_address'])), function ($img) {
            $img->addMediaFromRequest(Request::IMAGE_FIELD)->toMediaCollection(static::MEDIA_COLLECTION);
        });
    }
}
