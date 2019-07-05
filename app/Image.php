<?php

namespace App;

use RobbieP\ZbarQrdecoder\ZbarDecoder;
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

    public function extractQRCode()
    {
        $config = ['path' => '/usr/local/bin/'];
        $zbar = new ZbarDecoder($config);

        $result = $zbar->make($this->getFirstMedia('ballots')->getPath());

        if ($result->getCode() == 200)
            $this->update(['qr_code' => $result->getText()]);

        return $this;
    }
}
