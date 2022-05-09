<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cinema\BulkDestroyCinema;
use App\Http\Requests\Admin\Cinema\DestroyCinema;
use App\Http\Requests\Admin\Cinema\IndexCinema;
use App\Http\Requests\Admin\Cinema\StoreCinema;
use App\Http\Requests\Admin\Cinema\UpdateCinema;
use App\Models\Cinema;
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

class CinemasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCinema $request
     * @return array|Factory|View
     */
    public function index(IndexCinema $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Cinema::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'cinema'],

            // set columns to searchIn
            ['id', 'cinema']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.cinema.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.cinema.create');

        return view('admin.cinema.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCinema $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCinema $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Cinema
        $cinema = Cinema::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/cinemas'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/cinemas');
    }

    /**
     * Display the specified resource.
     *
     * @param Cinema $cinema
     * @throws AuthorizationException
     * @return void
     */
    public function show(Cinema $cinema)
    {
        $this->authorize('admin.cinema.show', $cinema);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Cinema $cinema
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Cinema $cinema)
    {
        $this->authorize('admin.cinema.edit', $cinema);


        return view('admin.cinema.edit', [
            'cinema' => $cinema,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCinema $request
     * @param Cinema $cinema
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCinema $request, Cinema $cinema)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Cinema
        $cinema->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/cinemas'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/cinemas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCinema $request
     * @param Cinema $cinema
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCinema $request, Cinema $cinema)
    {
        $cinema->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCinema $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCinema $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('cinemas')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
