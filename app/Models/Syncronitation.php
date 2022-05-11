<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Syncronitation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'result',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return secure_url('/admin/syncronitations/'.$this->getKey());
    }
    public function projections() {
        return $this->hasMany('App\Models\Projection');
      }
}
