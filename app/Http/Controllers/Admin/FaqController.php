<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use Illuminate\Http\Request;
use App\Services\Admin\FaqService;

class FaqController extends Controller
{

    public function __construct(private FaqService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $records = $this->service->fetchFaq();

        $content_header = $this->service->breadcrumb($request, 'index');
        return view('admin/faq/faq-list', compact('content_header', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $content_header = $this->service->breadcrumb($request, 'create');
        $categories = $this->service->fetchFaqCategories();

        return view('admin/faq/create', compact('content_header', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        //
        $this->service->upsert($request);
        return redirect('admin/faq')->with('status', '登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //
        $record = $this->service->fetchFaqById($id);
        $categories = $this->service->fetchFaqCategories();

        $content_header = $this->service->breadcrumb($request, 'edit');
        return view('admin/faq/edit', compact('content_header', 'record', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, string $id)
    {
        //
        $this->service->upsert($request);
        return redirect('admin/faq')->with('status', '登録しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
