<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RentalRoomSettingRequest;
use Illuminate\Http\Request;
use App\Services\Admin\RentalRoomSettingService;

class RentalRoomSettingController extends Controller
{
    public function __construct(private RentalRoomSettingService $service)
    {
    }

    public function edit(Request $request)
    {
        $record         = $this->service->getSetting();
        $content_header = $this->service->breadcrumb($request, 'edit');
        return view('admin/rental-room-setting/edit', compact('content_header', 'record'));
    }

    public function update(RentalRoomSettingRequest $request)
    {
        $this->service->updateCapacity($request);
        return redirect('admin/rental-room-setting')->with('status', '設定を更新しました');
    }
}
