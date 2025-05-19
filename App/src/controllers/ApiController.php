<?php

namespace App\Controllers;

use Framework\Controllers\AbstractAPIController;

class ApiController extends AbstractAPIController
{
    public function welcome()
    {
        sleep(4);
        $this->sendJsonResponse([
            'success' => true,
            'message' => 'Welcome to the API'
        ]);
    }

    public function jsonBody()
    {
        sleep(2);
        $request = $this->getJsonBody();
        $data['success'] = true;
        $data['message'] = 'Data received';
        $data['data'] = $request;
        $this->sendJsonResponse($data);
    }
}
