<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;

class Movie extends Model implements HasMedia
{
    use SoftDeletes;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;


    protected $fillable = [
        'title',
        'synopsis',
        'duration',
        'date',
        'trailer',
        'type',
        'premiere',
        'buy',
        'active',
        'update',
        'qualification_id',

    ];


    protected $dates = [
        'date',
        'premiere',
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/movies/' . $this->getKey());
    }
    public function qualification()
    {
        return $this->belongsTo('App\Models\Qualification');
    }
    public function projections()
    {
        return $this->hasMany('App\Models\Projection');
    }
    public function actor()
    {
        return $this->belongsToMany('App\Models\Actor');
    }
    public function director()
    {
        return $this->belongsToMany('App\Models\Director');
    }
    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }
    public function directors()
    {
        return $this->belongsToMany(Director::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('posters')->disk('mi_poster')->accepts('image/*')->canUpload('media.upload');
        $this->addMediaCollection('backgrounds')->disk('mi_fondo')->accepts('image/*')->canUpload('media.upload');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();
    }
}
