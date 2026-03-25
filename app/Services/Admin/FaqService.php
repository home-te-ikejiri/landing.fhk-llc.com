<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\Admin\Service;
use App\Models\Faq;
use App\Models\FaqCategory;

class FaqService extends Service
{
    public function __construct(Faq $model)
    {
        $this->_title = 'FAQ';
        $this->index  = '一覧';
        $this->create = '新規追加';
        $this->edit   = 'FAQ更新';
        $this->show   = '詳細';
        parent::__construct($model);
    }

    public function fetchFaq()
    {
        return $this->model
                    ->where('status', config('define.common.status.published.id'))
                    ->orderBy('disp_order', 'asc')
                    ->orderBy('id', 'desc')
                    ->paginate(config('const.system.list_counts'));
    }

    public function fetchFaqById($id)
    {
        return $this->model
            ->where('status',         config('define.common.status.published.id'))
            ->findOrFail($id);
    }

    public function fetchFaqCategories()
    {
        return FaqCategory::where('status',         config('define.common.status.published.id'))
            ->orderBy('disp_order', 'asc')
            ->get();
    }


    public function upsert(Request $request)
    {

        if ($request->id) {
            $record = $this->model->findOrFail($request->id);
            $record->updated_at = now();
        } else {
            $record = new $this->model;
        }
        $record->title              = $request->title;
        $record->category_id        = $request->category_id;
        $record->body               = $request->body;
        $record->disp_order         = 0;
        $record->status             = config('define.common.status.published.id');
        $record->save();
    }

}