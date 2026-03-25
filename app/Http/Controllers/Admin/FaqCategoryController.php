<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqCategoryRequest;
use Illuminate\Http\Request;
use App\Services\Admin\FaqCategoryService;

class FaqCategoryController extends Controller
{

    public function __construct(private FaqCategoryService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $records = $this->service->fetchFaqCategory();

        $content_header = $this->service->breadcrumb($request, 'index');
        return view('admin/faq-category/faq-list', compact('content_header', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $content_header = $this->service->breadcrumb($request, 'create');
        return view('admin/faq-category/create', compact('content_header'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqCategoryRequest $request)
    {
        //
        $this->service->upsert($request);
        return redirect('admin/faq-category')->with('status', '登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        //
        $record = $this->service->fetchFaqById($id);

        $content_header = $this->service->breadcrumb($request, 'show');
        return view('admin/faq-category/faq-single', compact('content_header','record'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //
        $record = $this->service->fetchFaqCategoryById($id);

        $content_header = $this->service->breadcrumb($request, 'edit');
        return view('admin/faq-category/edit', compact('content_header', 'record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqCategoryRequest $request, string $id)
    {
        //
        $this->service->upsert($request);
        return redirect('admin/faq-category')->with('status', '登録しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
