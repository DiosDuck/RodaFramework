<?php

namespace Framework\Authorization;

use Framework\Router\Route;

interface IAuthorizationService {
    /**
     * Check if user is allowed to access endpoint
     * 
     * @return bool if user is allowed or not
     */
    public function isAuthorized(Route $route): bool;
}
