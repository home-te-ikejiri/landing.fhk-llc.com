<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\Service;
use App\Models\EventReservation;
use App\Models\Customer;
use App\Models\Event;

class EventReservationService extends Service
{
    const STATUS_LABELS = [
        EventReservation::STATUS_TENTATIVE => '仮予約',
        EventReservation::STATUS_CONFIRMED => '確定',
        EventReservation::STATUS_CANCELLED => 'キャンセル',
    ];

    public function __construct(EventReservation $model)
    {
        $this->_title = 'イベント予約';
        $this->index  = '予約一覧';
        $this->create = '予約登録';
        $this->edit   = '予約詳細・編集';
        parent::__construct($model);
    }

    public function fetchList(Request $request)
    {
        $query = $this->model
                      ->with('event')
                      ->orderBy('created_at', 'desc');

        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        return $query->paginate(config('const.list_counts.admin.index'));
    }

    public function fetchById($id): EventReservation
    {
        return $this->model
                    ->with(['event', 'participants'])
                    ->findOrFail($id);
    }

    public function fetchAllEvents()
    {
        return Event::orderBy('event_date', 'desc')->get();
    }

    public function upsert(Request $request): void
    {
        if ($request->id) {
            $record = $this->model->findOrFail($request->id);
        } else {
            $record = new $this->model;
        }

        $record->event_id              = $request->event_id;
        $record->num_participants         = $request->num_participants;
        $record->representative_name      = $request->representative_name;
        $record->email                    = $request->email;
        $record->representative_phone     = $request->representative_phone;
        $record->message                  = $request->message;
        $record->status                   = $request->status;
        $record->admin_memo               = $request->admin_memo;

        $customer = Customer::updateOrCreate(
            ['email' => $request->email],
            ['name'  => $request->representative_name, 'phone' => $request->representative_phone]
        );
        $record->customer_id = $customer->id;

        $record->save();
    }

    public function updateStatus($id, int $status): void
    {
        $record         = $this->model->findOrFail($id);
        $record->status = $status;
        $record->save();
    }
}
