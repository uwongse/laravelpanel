<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slide\BulkDestroySlide;
use App\Http\Requests\Admin\Slide\DestroySlide;
use App\Http\Requests\Admin\Slide\IndexSlide;
use App\Http\Requests\Admin\Slide\StoreSlide;
use App\Http\Requests\Admin\Slide\UpdateSlide;
use App\Models\Slide;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class SlidesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSlide $request
     * @return array|Factory|View
     */
    public function index(IndexSlide $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Slide::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'title',  'active', 'url', 'updated'],

            // set columns to searchIn
            ['id', 'title', 'url']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.slide.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.slide.create');

        return view('admin.slide.create',[
            'mode' => 'create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSlide $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSlide $request)
    {
        
        // Sanitize input
        $sanitized = $request->getSanitized();
        
        // Store the Slide
        $slide = Slide::create($sanitized);
        
        if ($request->ajax()) {
            return ['redirect' => secure_url('admin/slides'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/slides');
    }

    /**
     * Display the specified resource.
     *
     * @param Slide $slide
     * @throws AuthorizationException
     * @return void
     */
    public function show(Slide $slide)
    {
        $this->authorize('admin.slide.show', $slide);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Slide $slide
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Slide $slide)
    {
        $this->authorize('admin.slide.edit', $slide);


        return view('admin.slide.edit', [
            'slide' => $slide,
            'mode' => 'edit',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSlide $request
     * @param Slide $slide
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSlide $request, Slide $slide)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // $request->file('image')->store('mi_poster');



        // Update changed values Slide
        $slide->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => secure_url('admin/slides'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/slides');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySlide $request
     * @param Slide $slide
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySlide $request, Slide $slide)
    {
        $slide->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySlide $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySlide $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('slides')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
