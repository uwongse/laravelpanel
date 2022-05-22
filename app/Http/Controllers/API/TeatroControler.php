<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProjectionIDResource;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Syncronitation;
use Carbon\Carbon;
class TeatroControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //$id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();
        $date = Carbon::now()->format("Y/m/d");

        return ProjectionIDResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($date)  {
            $query->where('release_date',">=", $date)->where('cinema_id', 3)->where('valid','=', 0);
        })->orderBy('premiere', 'asc')->with('Qualification')->with('Actor')->with('Director')
        ->get());
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
        //
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
        //
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
