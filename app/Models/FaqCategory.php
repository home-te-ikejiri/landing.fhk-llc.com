<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory;

    protected $table = 'faq_categories';
    protected $guarded = array('id');


    public function getStatusValueAttribute()
    {
        return config('system.status.common.' . $this->status);
    }

    public function getStatusBadgeAttribute()
    {
        $ret = 'badge bg-danger';
        if ($this->status == 1) {
            $ret = 'badge bg-primary';
        }
        return $ret;
    }

}
