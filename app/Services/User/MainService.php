<?php

namespace App\Services\User;

use DB;
use Exception;
use Auth;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\User\Service;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\News;

class MainService extends Service
{
    public function __construct()
    {
    }

    public function fetchFaqs()
    {

        $ret = [];

        $categories = FaqCategory::where('status', 1)->orderBy('disp_order', 'asc')->get();
        foreach($categories as $c) {
            $faqs = Faq::where('category_id', $c->id)->where('status', 1)->orderBy('disp_order', 'asc')->get();
            if ($faqs->isNotEmpty()) {
                $ret['faq'][$c->id]['name']  = $c->name;
                $ret['faq'][$c->id]['items'] = $faqs;
            }
        }

        return $ret;
    }

    public function fetchNews()
    {
        return News::where('status', config('define.common.status.published.id'))
                    ->orderBy('publish_date', 'desc')
                    ->paginate(10);

    }

}