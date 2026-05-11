<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\Service;
use App\Models\Contact;

class ContactService extends Service
{
    const STATUS_LABELS = [
        Contact::STATUS_PENDING     => '未対応',
        Contact::STATUS_IN_PROGRESS => '対応中',
        Contact::STATUS_DONE        => '完了',
    ];

    const RELATED_TYPE_LABELS = [
        Contact::RELATED_TYPE_RENTAL_ROOM => 'レンタルルーム予約',
        Contact::RELATED_TYPE_EVENT       => 'イベント予約',
    ];

    public function __construct(Contact $model)
    {
        $this->_title = 'お問い合わせ';
        $this->index  = '一覧';
        $this->edit   = '詳細';
        parent::__construct($model);
    }

    public function fetchList(Request $request)
    {
        $query = $this->model->orderBy('created_at', 'desc');

        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        if ($request->filled('related_type')) {
            $query->where('related_type', $request->related_type);
        }

        return $query->paginate(config('const.list_counts.admin.index'));
    }

    public function fetchById($id): Contact
    {
        return $this->model->findOrFail($id);
    }

    public function update(Request $request, $id): void
    {
        $record             = $this->model->findOrFail($id);
        $record->status     = $request->status;
        $record->admin_memo = $request->admin_memo;
        $record->save();
    }
}
