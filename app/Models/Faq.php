<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $table = 'faqs';
    protected $guarded = array('id');
    protected $dates = [
        'disp_date',
        'start_date',
        'end_date'
    ];

    public function getStatusValueAttribute()
    {
        return config('status.common.' . $this->status);
    }

    public function getStatusBadgeAttribute()
    {
        $ret = 'badge-danger';
        if ($this->status == 1) {
            $ret = 'badge-primary';
        }
        return $ret;
    }

    public function getPublicDateAttribute()
    {
        $ret = '';
        if ($this->start_date) {
            $ret .= $this->start_date->format('Y/m/d H:i');
        } else {
            $ret .= '指定なし';
        }
        $ret .= ' ～ ';
        if ($this->end_date) {
            $ret .= $this->end_date->format('Y/m/d H:i');
        } else {
            $ret .= '指定なし';
        }

        return $ret;
    }

    public function getStartDatetimeAttribute()
    {
        $ret = '';
        $start_date = $this->start_date;
        if ($start_date) {
            $ret = $start_date->format('Y-m-d H:i');
        }
        return str_replace(" ", "T", $ret);
    }

    public function getEndDatetimeAttribute()
    {
        $ret = '';
        $end_date = $this->end_date;
        if ($end_date) {
            $ret = $end_date->format('Y-m-d H:i');
        }
        return str_replace(" ", "T", $ret);
    }


    public function category()
    {
        return $this->belongsTo('App\Models\FaqCategory', 'category_id', 'id');
    }

}
