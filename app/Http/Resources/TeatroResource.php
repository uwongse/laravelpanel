<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Syncronitation;
use App\Models\Projection;

class TeatroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //$id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'synopsis'=>$this->synopsis,
            'duration'=>$this->duration,
            'date'=>$this->date,
            'poster'=>$this->getFirstMediaUrl('posters'),
            'background'=>$this->getFirstMediaUrl('backgrounds'),
            'trailer'=>$this->trailer,
            'type'=>$this->type,
            'premiere'=>$this->premiere,
            'valid'=>$this->valid,
            'buy'=>$this->buy,
            'active'=>$this->active,
            'update'=>$this->update,
            'projections'=> ProjectionResource::collection(Projection::where('cinema_id', 3)->where('projections.movie_id',$this->id)
            ->with('movie')->with('Room')->with('Cinema')->get()),
            'qualification'=>$this->qualification,
            'actors'=>$this->actor,
            'director'=>$this->director,
            
        ];
    }
}
