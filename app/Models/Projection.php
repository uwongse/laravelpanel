<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projection extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'hour',
        'release_date',
        'movie_id',
        'room_id',
        'cinema_id',
        'syncronitation_id',
    
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
        return secure_url('/admin/projections/'.$this->getKey());
    }
    public function movie() {
        return $this->belongsTo('App\Models\Movie');
      }
      public function room() {
        return $this->belongsTo('App\Models\Room');
      }
      public function cinema() {
        return $this->belongsTo('App\Models\Cinema');
      }
      public function Syncronitation() {
        return $this->belongsTo('App\Models\Syncronitation');
      }
}
