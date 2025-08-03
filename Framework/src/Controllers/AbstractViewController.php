<?php

namespace Framework\Controllers;

abstract class AbstractViewController extends AbstractController
{
    private const TITLE = 'title';
    private array $heads = [];

    /**
     * Set the title of the page
     */
    protected function setTItle(string $title): void
    {
        $this->heads[self::TITLE] = $title;
    }

    /**
     * Add a header line
     */
    protected function addHeader(string $header): void
    {
        array_push($this->heads, $header);
    }

    /**
     * render view elements
     */
    protected function renderView(string $name, array $data = [], string $base = 'base'): void
    {
        // set default title if not set
        if (!isset($this->heads[self::TITLE])) {
            $list = explode('\\', get_class($this));
            $title = end($list);
            $this->setTItle($title);
        }

        render($name, array_merge($data, ['heads' => $this->heads]), $base);
    }

    /**
     * redirects to the wanted URL
     */
    protected function redirectTo(string $url): void
    {
        redirect($url);
    }
}
