<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'synopsis'=>$this->synopsis,
            'duration'=>$this->duration,
            'poster'=>$this->getFirstMediaUrl('postes'),
            'background'=>$this->getFirstMediaUrl('backgrounds'),
            'trailer'=>$this->trailer,
            'type'=>$this->type,
            'premiere'=>$this->premiere,
            'buy'=>$this->buy,
            'active'=>$this->active,
            'update'=>$this->update,
            'projections'=> ProjectionResource::collection($this->whenLoaded('projections')),
            'qualification'=>$this->qualification,
            'actors'=>$this->actor,
            'director'=>$this->director,
            
        ];
    }
}
