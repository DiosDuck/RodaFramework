<?php

namespace App\Controllers;

use Framework\AbstractController;

class HomeController extends AbstractController {
    public function index()
    {
        $this->renderView('home');
    }
}
