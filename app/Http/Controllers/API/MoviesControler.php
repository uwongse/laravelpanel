<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Syncronitation;
use App\Http\Resources\MoviesAllResource;

class MoviesControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

        return MoviesAllResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($id)  {
            $query->where('projections.syncronitation_id', $id->id)->where('cinema_id', 2);
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
        $id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

        return MoviesAllResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($id)  {
            $query->where('projections.syncronitation_id', $id->id)->where('cinema_id', 1);
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
        $id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

        return MoviesAllResource::collection( Movie::whereHas('projections', function (Builder $query ) use ($id)  {
            $query->where('projections.syncronitation_id', $id->id)->where('cinema_id', 3);
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
