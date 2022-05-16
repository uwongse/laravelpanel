<?php

namespace App\Http\Controllers\API\Movie;
use App\Models\Movie;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectionIDResource;
use Illuminate\Http\Request;
use App\Models\Syncronitation;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
class id2Controler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Movie::find($id)->with('Projections')->with('Qualification')->with('Actor')->with('Director')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $idS=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();
        
        $date = Carbon::now()->format("Y/m/d");

        return ProjectionIDResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($idS, $date)  {
            $query->where('projections.syncronitation_id', $idS->id)->where('release_date','>',$date);
        })->where('id', $id)->with('Projections')->with('Qualification')->with('Actor')->with('Director')->with('projections.cinema')
        ->with('projections.room')->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Movie::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
