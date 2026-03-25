<?php

namespace App\Services\User;

use Config;
use App\Exceptions\ResourceNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Service
{
    /**
     * Stores the model used for service
     * @var Eloquent object
     */
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}