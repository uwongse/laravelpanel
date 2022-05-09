<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Syncronitation;
use App\Models\Projection;

class ProjectionIDResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'synopsis'=>$this->synopsis,
            'duration'=>$this->duration,
            'poster'=>$this->getFirstMediaUrl('posters'),
            'background'=>$this->getFirstMediaUrl('backgrounds'),
            'trailer'=>$this->trailer,
            'type'=>$this->type,
            'premiere'=>$this->premiere,
            'buy'=>$this->buy,
            'active'=>$this->active,
            'update'=>$this->update,
            'projections'=> ProjectionResource::collection(Projection::where('projections.syncronitation_id', $id->id)->where('release_date','!=', null)->where('projections.movie_id',$this->id)
            ->with('movie')->with('Room')->with('Cinema')->get()),
            'qualification'=>$this->qualification,
            'actors'=>$this->actor,
            'director'=>$this->director,
            
        ];
    }
}
