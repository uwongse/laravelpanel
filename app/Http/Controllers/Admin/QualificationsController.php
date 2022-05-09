<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Qualification\BulkDestroyQualification;
use App\Http\Requests\Admin\Qualification\DestroyQualification;
use App\Http\Requests\Admin\Qualification\IndexQualification;
use App\Http\Requests\Admin\Qualification\StoreQualification;
use App\Http\Requests\Admin\Qualification\UpdateQualification;
use App\Models\Qualification;
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

class QualificationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexQualification $request
     * @return array|Factory|View
     */
    public function index(IndexQualification $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Qualification::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'qualification', 'abbreviation', 'image'],

            // set columns to searchIn
            ['id', 'qualification', 'abbreviation', 'image']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.qualification.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.qualification.create');

        return view('admin.qualification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQualification $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreQualification $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Qualification
        $qualification = Qualification::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/qualifications'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/qualifications');
    }

    /**
     * Display the specified resource.
     *
     * @param Qualification $qualification
     * @throws AuthorizationException
     * @return void
     */
    public function show(Qualification $qualification)
    {
        $this->authorize('admin.qualification.show', $qualification);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Qualification $qualification
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Qualification $qualification)
    {
        $this->authorize('admin.qualification.edit', $qualification);


        return view('admin.qualification.edit', [
            'qualification' => $qualification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQualification $request
     * @param Qualification $qualification
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateQualification $request, Qualification $qualification)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Qualification
        $qualification->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/qualifications'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/qualifications');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyQualification $request
     * @param Qualification $qualification
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyQualification $request, Qualification $qualification)
    {
        $qualification->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyQualification $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyQualification $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('qualifications')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
