<?php

namespace App\Controllers;

use Framework\Controllers\AbstractViewController;

class AdminController extends AbstractViewController {
    public function index(): void
    {
        $this->setTItle('Welcome Admin Page');
        $this->renderView('admin/index');
    }
}
