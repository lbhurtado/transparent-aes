<?php

namespace App;

use Illuminate\Support\Arr;
use RobbieP\ZbarQrdecoder\ZbarDecoder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Http\Requests\BallotImageRequest as Request;
use LBHurtado\BallotOMR\Facades\BallotOMR; //TODO: put this in a job
use Spatie\SchemalessAttributes\SchemalessAttributes;

//TODO: make this a package
class Image extends Model implements HasMedia
{
    use HasMediaTrait;

    const MEDIA_COLLECTION = 'ballots';

    protected $fillable = [
        'sender_mac_address',
        'qr_code',
    ];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    /** @var \Imagick */
    protected $imagick;

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

    public function processMarkings()
    {
        $preloaded_image_path = storage_path("app/preload/{$this->qr_code}.jpg");

        $path = config('app.simulated_images') ? $preloaded_image_path : $this->path;

        tap(BallotOMR::setImage($path), function (\LBHurtado\BallotOMR\Drivers\Driver $omr) {
           $omr->process();
           $this->markings = $omr->getResults();
           $this->save();
        });

        return $this;
    }

    public function setMarkingsAttribute($value)
    {
        Arr::set($this->extra_attributes, 'markings', $value);
    }

    public function getMarkingsAttribute()
    {
        return Arr::get($this->extra_attributes, 'markings');
    }

    public function deskew($threshold = 80) {
        $imagick = new \Imagick($this->path);
        $imagick->deskewImage($threshold);
//        $imagick->trimImage(0);
        $imagick->resizeImage(2480, 3508, \Imagick::FILTER_LANCZOS, -1);

//        $imagick->cropImage(2480, 3508, 22,0);
        $imagick->contrastImage(100);
        $imagick->writeImage();

        return $this;
    }

    public function getExtraAttributesAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'extra_attributes');
    }

    public function scopeWithExtraAttributes(): Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('extra_attributes');
    }
}
