<?php

namespace Framework\Controllers;

abstract class AbstractViewController extends AbstractController
{
    /**
     * render view elements
     */
    public function renderView(string $name, array $data = []): void
    {
        loadView($name, $data);
    }

    /**
     * redirects to the wanted URL
     */
    protected function redirectTo(string $url): void
    {
        redirect($url);
    }
}
