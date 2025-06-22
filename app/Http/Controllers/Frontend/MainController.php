<?php

namespace App\Http\Controllers\Frontend;


use Illuminate\View\View;

/**
 * Base Controller For API
 */
class MainController extends BaseController
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('app');
    }
}
