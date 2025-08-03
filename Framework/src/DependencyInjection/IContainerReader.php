<?php

namespace Framework\DependencyInjection;

interface IContainerReader {
    public function get(string $name): mixed;
}
