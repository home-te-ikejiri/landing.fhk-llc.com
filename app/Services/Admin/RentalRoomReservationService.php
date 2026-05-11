<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\Service;
use App\Models\RentalRoomReservation;
use App\Models\Customer;

class RentalRoomReservationService extends Service
{
    // ステータスラベル
    const STATUS_LABELS = [
        RentalRoomReservation::STATUS_TENTATIVE  => '仮予約',
        RentalRoomReservation::STATUS_CONFIRMED  => '確定',
        RentalRoomReservation::STATUS_REJECTED   => '受付不可',
        RentalRoomReservation::STATUS_CANCELLED  => 'キャンセル',
    ];

    // 利用種別ラベル
    const USAGE_TYPE_LABELS = [
        RentalRoomReservation::USAGE_TYPE_SHARED    => '共有（席のみ）',
        RentalRoomReservation::USAGE_TYPE_EXCLUSIVE => '占有（フロア貸し切り）',
    ];

    // 利用目的ラベル
    const PURPOSE_LABELS = [
        RentalRoomReservation::PURPOSE_MEETING => '打ち合わせ',
        RentalRoomReservation::PURPOSE_SEMINAR => 'セミナー',
        RentalRoomReservation::PURPOSE_EVENT   => 'イベント',
        RentalRoomReservation::PURPOSE_SEAT    => '席利用',
        RentalRoomReservation::PURPOSE_OTHER   => 'その他',
    ];

    public function __construct(RentalRoomReservation $model)
    {
        $this->_title = 'レンタルルーム予約';
        $this->index  = '予約一覧';
        $this->create = '予約登録';
        $this->edit   = '予約詳細・編集';
        parent::__construct($model);
    }

    public function fetchList(Request $request)
    {
        $query = $this->model->orderBy('reservation_date', 'desc')->orderBy('start_time', 'asc');

        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->where('reservation_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('reservation_date', '<=', $request->date_to);
        }

        return $query->paginate(config('const.list_counts.admin.index'));
    }

    public function fetchById($id): RentalRoomReservation
    {
        return $this->model->findOrFail($id);
    }

    public function upsert(Request $request): void
    {
        if ($request->id) {
            $record = $this->model->findOrFail($request->id);
        } else {
            $record = new $this->model;
        }

        $record->reservation_date = $request->reservation_date;
        $record->start_time       = $request->start_time;
        $record->end_time         = $request->end_time;
        $record->usage_type       = $request->usage_type;
        $record->purpose          = $request->purpose;
        $record->num_people       = $request->num_people;
        $record->name             = $request->name;
        $record->email            = $request->email;
        $record->phone            = $request->phone;
        $record->message          = $request->message;
        $record->status           = $request->status;
        $record->admin_memo       = $request->admin_memo;

        // 顧客情報を upsert（メールアドレスをキーに）
        $customer = Customer::updateOrCreate(
            ['email' => $request->email],
            ['name'  => $request->name, 'phone' => $request->phone]
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
