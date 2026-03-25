<?php

namespace App\Services\Admin;

class Service
{
    protected $_title = '';
    protected $_item1 = '';
    protected $_item2 = '';

    /**
     * Stores the model used for service
     */

    public function __construct(protected $model)
    {
    }


    public function breadcrumb($request, $method='')
    {
        $content_header['title'] = $this->_title;

        if (isset($this->$method)) {
            $content_header['breadcrumb'][] = array('url' => '', 'title' => $this->_title);
            if ($this->$method) {
                $content_header['breadcrumb'][] = array('url' => '', 'title' => $this->$method);
            }
        } else {
            $content_header['breadcrumb'][] = array('url' => '', 'title' => 'パンくず調整中');
        }
        return $content_header;
    }
}


