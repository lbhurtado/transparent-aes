<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Image extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'sender_mac_address',
        'qr_code',
    ];
    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('images')
            ->singleFile();
    }
}
