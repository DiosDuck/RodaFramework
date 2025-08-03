<?php

namespace Framework\Authorization;

use Framework\Router\Route;
use Framework\Session\ISession;

class AuthorizationService implements IAuthorizationService {
    public function __construct(
        private ISession $session,
    ) { }

    /**
     * Check if the user from session has access to the route
     */
    public function isAuthorized(Route $route): bool
    {
        $allowedRoles = $route->getAuthorizedRoles();
        if ($allowedRoles === '*') {
            return true;
        }

        $currentRole = $this->session->get('role');
        if (!$currentRole) {
            return false;
        }

        if (is_array($allowedRoles)) {
            return in_array($currentRole, $allowedRoles);
        }

        return $currentRole === $allowedRoles;
    }
}
