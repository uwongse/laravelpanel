<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Syncronitation\BulkDestroySyncronitation;
use App\Http\Requests\Admin\Syncronitation\DestroySyncronitation;
use App\Http\Requests\Admin\Syncronitation\IndexSyncronitation;
use App\Http\Requests\Admin\Syncronitation\StoreSyncronitation;
use App\Http\Requests\Admin\Syncronitation\UpdateSyncronitation;
use App\Models\Syncronitation;
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

class SyncronitationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSyncronitation $request
     * @return array|Factory|View
     */
    public function index(IndexSyncronitation $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Syncronitation::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id','result'],

            // set columns to searchIn
            ['id', 'result']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.syncronitation.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.syncronitation.create');

        return view('admin.syncronitation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSyncronitation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSyncronitation $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Syncronitation
        $syncronitation = Syncronitation::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => secure_url('admin/syncronitations'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/syncronitations');
    }

    /**
     * Display the specified resource.
     *
     * @param Syncronitation $syncronitation
     * @throws AuthorizationException
     * @return void
     */
    public function show(Syncronitation $syncronitation)
    {
        $this->authorize('admin.syncronitation.show', $syncronitation);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Syncronitation $syncronitation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Syncronitation $syncronitation)
    {
        $this->authorize('admin.syncronitation.edit', $syncronitation);


        return view('admin.syncronitation.edit', [
            'syncronitation' => $syncronitation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSyncronitation $request
     * @param Syncronitation $syncronitation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSyncronitation $request, Syncronitation $syncronitation)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Syncronitation
        $syncronitation->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => secure_url('admin/syncronitations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/syncronitations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySyncronitation $request
     * @param Syncronitation $syncronitation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySyncronitation $request, Syncronitation $syncronitation)
    {
        $syncronitation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySyncronitation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySyncronitation $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('syncronitations')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
