<?php

namespace App\Http\Controllers\API;
use App\Http\Resources\MovieToday;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Syncronitation;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class MoviesTodayControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();
        $date = Carbon::now()->format("Y-m-d");
        
        return MovieToday::collection( Movie::whereHas('projections', function (Builder $query ) use ($id ,$date)  {
            $query->where('projections.syncronitation_id', $id->id)->where('release_date', null)->where('cinema_id', 1)->where('cinema_id', 2);
        })->orderBy('premiere', 'desc')->with('Qualification')->with('Actors')->with('Directors')
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
