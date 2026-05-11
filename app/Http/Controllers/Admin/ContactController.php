<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactRequest;
use Illuminate\Http\Request;
use App\Services\Admin\ContactService;

class ContactController extends Controller
{
    public function __construct(private ContactService $service)
    {
    }

    public function index(Request $request)
    {
        $records             = $this->service->fetchList($request);
        $content_header      = $this->service->breadcrumb($request, 'index');
        $statusLabels        = ContactService::STATUS_LABELS;
        $relatedTypeLabels   = ContactService::RELATED_TYPE_LABELS;
        return view('admin/contact/index',
            compact('content_header', 'records', 'statusLabels', 'relatedTypeLabels'));
    }

    public function show(Request $request, string $id)
    {
        $record              = $this->service->fetchById($id);
        $content_header      = $this->service->breadcrumb($request, 'edit');
        $statusLabels        = ContactService::STATUS_LABELS;
        $relatedTypeLabels   = ContactService::RELATED_TYPE_LABELS;
        return view('admin/contact/show',
            compact('content_header', 'record', 'statusLabels', 'relatedTypeLabels'));
    }

    public function update(ContactRequest $request, string $id)
    {
        $this->service->update($request, $id);
        return redirect('admin/contact')->with('status', '更新しました');
    }
}
