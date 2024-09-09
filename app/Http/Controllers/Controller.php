<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequest;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequest, DispatchesJobs, ValidatesRequest;
}