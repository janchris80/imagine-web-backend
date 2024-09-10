<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ApiBaseController extends Controller
{
    use ApiResponse;
}
