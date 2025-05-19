<?php

namespace App\Controllers;

use Framework\Controllers\AbstractViewController;

class HomeController extends AbstractViewController {
    public function index()
    {
        $this->renderView('home');
    }
}
