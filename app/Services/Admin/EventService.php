<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\Service;
use App\Models\Event;

class EventService extends Service
{
    public function __construct(Event $model)
    {
        $this->_title = 'イベント管理';
        $this->index  = '一覧';
        $this->create = '新規追加';
        $this->edit   = 'イベント編集';
        $this->show   = '詳細';
        parent::__construct($model);
    }

    public function fetchEvents()
    {
        return $this->model
            ->orderBy('event_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(config('const.list_counts.admin.index'));
    }

    public function fetchEventById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function upsert(Request $request)
    {
        if ($request->id) {
            $record = $this->model->findOrFail($request->id);
        } else {
            $record = new $this->model;
        }

        $record->title        = $request->title;
        $record->event_date   = $request->event_date;
        $record->start_time   = $request->start_time;
        $record->end_time     = $request->end_time;
        $record->capacity     = $request->capacity;
        $record->description  = $request->description;
        $record->price        = $request->price;
        $record->external_url = $request->external_url ?: null;
        $record->status       = $request->status;
        $record->admin_memo   = $request->admin_memo;
        $record->save();
    }

    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        $record->delete();
    }
}
