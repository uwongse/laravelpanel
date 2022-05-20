<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Http\Resources\MoviesAllResource;
use App\Http\Resources\ProjectionIDResource;

class MoviesControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::now()->format("Y/m/d");
        //$id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

        return MoviesAllResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($date) {
            $query->where('release_date','=',$date)->where('cinema_id', 2);
        })->orderBy('premiere', 'asc')->with('Qualification')->with('Actor')->with('Director')
        ->get());
    }
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
    {
        $date = Carbon::now()->format("Y/m/d");
        //$id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

        return MoviesAllResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($date)  {
            $query->where('release_date','=',$date)->where('cinema_id', 1);
        })->orderBy('premiere', 'asc')->with('Qualification')->with('Actor')->with('Director')
        ->get());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index3()
    {
       // $id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();
       $date = Carbon::now()->format("Y/m/d");

        return MoviesAllResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($date)  {
            $query->where('release_date','>=',$date)->where('cinema_id', 3);
        })->orderBy('premiere', 'asc')->with('Qualification')->with('Actor')->with('Director')
        ->get());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function proximamenteteatro()
    {
        $date = Carbon::now()->format("Y/m/d");
        //$id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

        return ProjectionIDResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($date)  {
            $query->where('release_date','>', $date)->where('cinema_id', 3);
        })->with('projections')->with('Qualification')->with('Actor')->with('Director')->get()->sortBy(function($movie, $key) {
            return $movie->projections()->first()->release_date;
          }));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function proximamentecineortega()
    {
        $date = Carbon::now()->format("Y/m/d");
        //$id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();
        return ProjectionIDResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($date)  {
            $query->where('release_date','>', $date)->where('cinema_id', 1);
        })->with('projections')->with('Qualification')->with('Actor')->with('Director')->get()->sortBy(function($movie, $key) {
            return $movie->projections()->first()->release_date;
          }));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function proximamenteavenida()
    {
        $date = Carbon::now()->format("Y/m/d");
        //$id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

        return ProjectionIDResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($date)  {
            $query->where('release_date','>', $date)->where('cinema_id', 2);
        })->with('projections')->with('Qualification')->with('Actor')->with('Director')->get()->sortBy(function($movie, $key) {
            return $movie->projections()->first()->release_date;
          }));
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
