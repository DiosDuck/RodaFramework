<?php

namespace App\Controllers;

use Framework\Controllers\AbstractAPIController;

class ApiController extends AbstractAPIController
{
    public function welcome(string $name): void
    {
        $this->sendJsonResponse([
            'success' => true,
            'message' => "Welcome to the API, $name"
        ]);
    }

    public function jsonBody(): void
    {
        $request = $this->getJsonBody();
        $data['success'] = true;
        $data['message'] = 'Data received';
        $data['data'] = $request;
        $this->sendJsonResponse($data);
    }
}
