<?php

namespace App\Http\Controllers;

use App\Services\Business\ResponseService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $resp;

    public function __construct(ResponseService $resp)
    {
        $this->resp = $resp;
    }

    public function showWelcome(Request $request) {
        return view('welcome');
    }
}