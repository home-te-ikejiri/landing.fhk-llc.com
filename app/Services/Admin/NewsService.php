<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\Admin\Service;
use App\Models\News;

class NewsService extends Service
{
    public function __construct(News $model)
    {
        $this->_title = 'お知らせ';
        $this->index  = '一覧';
        $this->create = '新規追加';
        $this->edit   = 'お知らせ更新';
        $this->show   = '詳細';
        parent::__construct($model);
    }

    public function fetchNews()
    {
        return $this->model
                    ->where('status', config('define.common.status.published.id'))
                    ->orderBy('created_at', 'desc')
                    ->paginate(config('const.system.list_counts'));

    }

    public function fetchNewsById($id)
    {
        return $this->model
            ->where('status',         config('define.common.status.published.id'))
            ->findOrFail($id);
    }

    public function upsert(Request $request)
    {

        if ($request->id) {
            $record = $this->model->findOrFail($request->id);
            $record->updated_at = now();
        } else {
            $record = new $this->model;
        }
        $record->title               = $request->title;
        $record->publish_date        = $request->publish_date;
        $record->details             = $request->details;
        $record->status              = config('define.common.status.published.id');
        $record->save();
    }

}