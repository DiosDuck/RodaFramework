<?php

namespace App\Controllers;

use Framework\Controllers\AbstractViewController;

class HomeController extends AbstractViewController {
    public function index(): void
    {
        $this->setTItle('Welcome Page');
        $this->addHeader('meta name="description" content="Roda\'s Framework Welcome Page which shows a view and two endpoints"');
        $this->addHeader('meta name="keywords" content="PHP ,HTML, CSS, JavaScript"');
        $this->addHeader('meta name="author" content="Roda"');
        $this->renderView('home/index');
    }
}
