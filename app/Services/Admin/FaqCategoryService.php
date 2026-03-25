<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\Admin\Service;
use App\Models\FaqCategory;

class FaqCategoryService extends Service
{
    public function __construct(FaqCategory $model)
    {
        $this->_title = 'FAQカテゴリ';
        $this->index  = '一覧';
        $this->create = '新規追加';
        $this->edit   = 'FAQカテゴリ更新';
        $this->show   = '詳細';
        parent::__construct($model);
    }

    public function fetchFaqCategory()
    {
        return $this->model
                    ->where('status', config('define.common.status.published.id'))
                    ->orderBy('disp_order', 'asc')
                    ->orderBy('id', 'desc')
                    ->paginate(config('const.system.list_counts'));
    }

    public function fetchFaqCategoryById($id)
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
        $record->name              = $request->name;
        $record->disp_order         = 0;
        $record->status             = config('define.common.status.published.id');
        $record->save();
    }

}