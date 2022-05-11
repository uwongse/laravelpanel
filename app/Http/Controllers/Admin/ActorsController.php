<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Actor\BulkDestroyActor;
use App\Http\Requests\Admin\Actor\DestroyActor;
use App\Http\Requests\Admin\Actor\IndexActor;
use App\Http\Requests\Admin\Actor\StoreActor;
use App\Http\Requests\Admin\Actor\UpdateActor;
use App\Models\Actor;
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

class ActorsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexActor $request
     * @return array|Factory|View
     */
    public function index(IndexActor $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Actor::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'actor'],

            // set columns to searchIn
            ['id', 'actor']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.actor.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.actor.create');

        return view('admin.actor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreActor $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreActor $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Actor
        $actor = Actor::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => secure_url('admin/actors'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/actors');
    }

    /**
     * Display the specified resource.
     *
     * @param Actor $actor
     * @throws AuthorizationException
     * @return void
     */
    public function show(Actor $actor)
    {
        $this->authorize('admin.actor.show', $actor);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Actor $actor
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Actor $actor)
    {
        $this->authorize('admin.actor.edit', $actor);


        return view('admin.actor.edit', [
            'actor' => $actor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateActor $request
     * @param Actor $actor
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateActor $request, Actor $actor)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Actor
        $actor->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => secure_url('admin/actors'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/actors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyActor $request
     * @param Actor $actor
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyActor $request, Actor $actor)
    {
        $actor->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyActor $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyActor $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('actors')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
