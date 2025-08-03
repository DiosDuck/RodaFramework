<?php

namespace App\Controllers;

use Framework\Controllers\AbstractAPIController;
use Framework\Session\ISession;

class AdminApiController extends AbstractAPIController {
    public function __construct(
        private readonly ISession $session
    ) { }

    public function sign(): void
    {
        if ($this->session->has('role')) {
            $this->sendJsonResponse([
                'message' => 'User already has admin role'
            ], 400);
        }

        $this->session->set('role', 'admin');
        $this->sendJsonResponse([
            'message' => 'Welcome, admin'
        ]);
    }

    public function unsign(): void
    {
        if (!$this->session->has('role')) {
            $this->sendJsonResponse([
                'message' => 'User doesn\'t have already an admin role'
            ], 400);
        }

        $this->session->clear('role');
        $this->sendJsonResponse([
            'message' => 'Bye, admin'
        ]);
    }
}
