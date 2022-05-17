<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Projection\BulkDestroyProjection;
use App\Http\Requests\Admin\Projection\DestroyProjection;
use App\Http\Requests\Admin\Projection\IndexProjection;
use App\Http\Requests\Admin\Projection\StoreProjection;
use App\Http\Requests\Admin\Projection\UpdateProjection;
use App\Models\Syncronitation;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Cinema;
use App\Models\Projection;
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

class ProjectionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexProjection $request
     * @return array|Factory|View
     */
    public function index(IndexProjection $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Projection::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'hour', 'release_date', 'movie_id', 'room_id', 'cinema_id'],

            // set columns to searchIn
            ['id', 'hour', 'release_date','movies.title','rooms.room','cinemas.cinema'],

            function ($query) use ($request) {
                $query->with(['movie','room','cinema','syncronitation']);
    
                // add this line if you want to search by author attributes
                $query->join('movies', 'movies.id', '=', 'projections.movie_id');
    
                $query->join('rooms', 'rooms.id', '=', 'projections.room_id');

                $query->join('cinemas', 'cinemas.id', '=', 'projections.cinema_id');
    
              
                if($request->has('movies')){
                    $query->whereIn('movie_id', $request->get('movies'));
                }
                if($request->has('rooms')){
                    $query->whereIn('room_id', $request->get('rooms'));
                }
                if($request->has('cinemas')){
                    $query->whereIn('cinema_id', $request->get('cinemas'));
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

        return view('admin.projection.index', ['data' => $data,
        'movies' => Movie::all(),
        'rooms' => Room::all(),
        'cinemas' => Cinema::all(),
       
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
        $this->authorize('admin.projection.create');

        return view('admin.projection.create',[
        'movies' => Movie::all(),
        'rooms' => Room::all(),
        'cinemas' => Cinema::all(),
        
    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjection $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreProjection $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitized['movie_id'] = $request->getMovieId();
        $sanitized['room_id'] = $request->getRoomId();
        $sanitized['cinema_id'] = $request->getCinemaId();
       


        // Store the Projection
        Projection::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/projections'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/projections');
    }

    /**
     * Display the specified resource.
     *
     * @param Projection $projection
     * @throws AuthorizationException
     * @return void
     */
    public function show(Projection $projection)
    {
        $this->authorize('admin.projection.show', $projection);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Projection $projection
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Projection $projection)
    {
        $this->authorize('admin.projection.edit', $projection);

        $projection->load(['movie', 'room', 'cinema','syncronitation']);


        return view('admin.projection.edit', [
            'projection' => $projection,
            'movies' => Movie::all(),
            'rooms' => Room::all(),
            'cinemas' => Cinema::all(),
        
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjection $request
     * @param Projection $projection
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateProjection $request, Projection $projection)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitized['movie_id'] = $request->getMovieId();
        $sanitized['room_id'] = $request->getRoomId();
        $sanitized['cinema_id'] = $request->getCinemaId();
       
        // Update changed values Projection
        $projection->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/projections'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/projections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyProjection $request
     * @param Projection $projection
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyProjection $request, Projection $projection)
    {
        $projection->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyProjection $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyProjection $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('projections')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
