<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Validation\ValidationException;
use App\Models\Qualification;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Movie\BulkDestroyMovie;
use App\Http\Requests\Admin\Movie\DestroyMovie;
use App\Http\Requests\Admin\Movie\IndexMovie;
use App\Http\Requests\Admin\Movie\StoreMovie;
use App\Http\Requests\Admin\Movie\UpdateMovie;
use App\Models\Movie;
use App\Models\Actor;
use App\Models\Director;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MoviesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexMovie $request
     * @return array|Factory|View
     */
    public function index(IndexMovie $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Movie::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'title', 'duration', 'date', 'trailer', 'type', 'premiere', 'buy', 'active','update', 'qualification_id'],

            // set columns to searchIn
            ['id', 'title', ],
            function ($query) use ($request) {
                $query->with(['actors','directors','qualification']);
    
                // add this line if you want to search by author attributes
                $query->join('qualifications', 'qualifications.id', '=', 'movies.qualification_id');

                //$query->join('actor_movie', 'actor_movie.movie_id', '=', 'movies.id')
                //->join('actors', 'actors.id', '=', 'actor_movie.actor_id')
                //->groupBy('movies.id');

                //$query->join('director_movie', 'director_movie.movie_id', '=', 'movies.id')
                //->join('directors', 'directors.id', '=', 'director_movie.director_id')
                //->groupBy('movies.id');

                if($request->has('qualifications')){
                   $query->whereIn('qualification_id', $request->get('qualifications'));
                }
                

            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.movie.index', ['data' => $data,
        'qualifications' => Qualification::all()
    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.movie.create');

        return view('admin.movie.create',[
            'qualifications' => Qualification::all(),
            'actors' => Actor::all(),
            'directors' => Director::all(),
            'mode' => 'create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMovie $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreMovie $request)
    {
        // Sanitize input
   
        $sanitized = $request->getSanitized();

        $sanitized['qualification_id'] = $request->getQualificationId();


        DB::transaction(function () use ($sanitized) {
            // Store the ArticlesWithRelationship
            $movie = Movie::create($sanitized);
            $movie->actors()->sync($sanitized['actors']);
            $movie->directors()->sync($sanitized['directors']);
        });
    

        // Store the Movie


        if ($request->ajax()) {
            return ['redirect' => url('admin/movies'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/movies');
    }

    /**
     * Display the specified resource.
     *
     * @param Movie $movie
     * @throws AuthorizationException
     * @return void
     */
    public function show(Movie $movie)
    {
        $this->authorize('admin.movie.show', $movie);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Movie $movie
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Movie $movie)
    {
        $this->authorize('admin.movie.edit', $movie);


        $movie->load(['actors','directors','qualification']);

        return view('admin.movie.edit', [
            'movie' => $movie,
            'qualifications' => Qualification::all(),
            'actors' => Actor::all(),
            'directors' => Director::all(),
            'mode' => 'edit',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMovie $request
     * @param Movie $movie
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateMovie $request, Movie $movie)
    {
        // Sanitize input

        $sanitized = $request->getSanitized();


        $sanitized['qualification_id'] = $request->getQualificationId();
        $sanitized['actors'] = $request->getActors();
        $sanitized['directors'] = $request->getDirectors();

        DB::transaction(function () use ($movie, $sanitized) {
            // Update changed values ArticlesWithRelationship
            $movie->update($sanitized);
            $movie->actors()->sync($sanitized['actors']);
            $movie->directors()->sync($sanitized['directors']);
        });

        // Update changed values Movie


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/movies'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/movies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyMovie $request
     * @param Movie $movie
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyMovie $request, Movie $movie)
    {
        $movie->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyMovie $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyMovie $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('movies')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
