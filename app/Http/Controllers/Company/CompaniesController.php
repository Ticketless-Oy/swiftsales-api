<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Models\Company;

class CompaniesController extends BaseController
{

    const RESOURCE_MODEL = Company::class;

    public function __construct()
    {

        $this->CRUD_RESPONSE_ARRAY = 'companies';
        $this->CRUD_RESPONSE_OBJECT = 'company';
    }
}
