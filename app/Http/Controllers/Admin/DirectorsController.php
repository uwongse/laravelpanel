<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Director\BulkDestroyDirector;
use App\Http\Requests\Admin\Director\DestroyDirector;
use App\Http\Requests\Admin\Director\IndexDirector;
use App\Http\Requests\Admin\Director\StoreDirector;
use App\Http\Requests\Admin\Director\UpdateDirector;
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

class DirectorsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDirector $request
     * @return array|Factory|View
     */
    public function index(IndexDirector $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Director::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'director'],

            // set columns to searchIn
            ['id', 'director']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.director.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.director.create');

        return view('admin.director.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDirector $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDirector $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Director
        $director = Director::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/directors'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/directors');
    }

    /**
     * Display the specified resource.
     *
     * @param Director $director
     * @throws AuthorizationException
     * @return void
     */
    public function show(Director $director)
    {
        $this->authorize('admin.director.show', $director);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Director $director
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Director $director)
    {
        $this->authorize('admin.director.edit', $director);


        return view('admin.director.edit', [
            'director' => $director,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDirector $request
     * @param Director $director
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDirector $request, Director $director)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Director
        $director->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/directors'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/directors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDirector $request
     * @param Director $director
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDirector $request, Director $director)
    {
        $director->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDirector $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDirector $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('directors')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
