<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\Service;
use App\Models\RentalRoomSetting;

class RentalRoomSettingService extends Service
{
    public function __construct(RentalRoomSetting $model)
    {
        $this->_title = 'レンタルルーム設定';
        $this->edit   = '席数設定';
        parent::__construct($model);
    }

    public function getSetting(): RentalRoomSetting
    {
        return $this->model->firstOrCreate([], ['capacity' => 3]);
    }

    public function updateCapacity(Request $request): void
    {
        $setting           = $this->getSetting();
        $setting->capacity = $request->capacity;
        $setting->save();
    }
}
