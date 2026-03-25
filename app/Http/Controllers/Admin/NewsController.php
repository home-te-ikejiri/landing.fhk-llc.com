<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use Illuminate\Http\Request;
use App\Services\Admin\NewsService;

class NewsController extends Controller
{

    public function __construct(private NewsService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $records = $this->service->fetchNews();

        $content_header = $this->service->breadcrumb($request, 'index');
        return view('admin/news/news-list', compact('content_header', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $content_header = $this->service->breadcrumb($request, 'create');
        return view('admin/news/create', compact('content_header'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        //
        $this->service->upsert($request);
        return redirect('admin/news')->with('status', '登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        //
        $record = $this->service->fetchNewsById($id);

        $content_header = $this->service->breadcrumb($request, 'show');
        return view('admin/news/news-single', compact('content_header','record'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //
        $record = $this->service->fetchNewsById($id);

        $content_header = $this->service->breadcrumb($request, 'edit');
        return view('admin/news/edit', compact('content_header', 'record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, string $id)
    {
        //
        $this->service->upsert($request);
        return redirect('admin/news')->with('status', '登録しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
