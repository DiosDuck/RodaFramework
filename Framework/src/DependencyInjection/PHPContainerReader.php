<?php

namespace Framework\DependencyInjection;

use Framework\ConfigReader\PHPConfigReader;

class PHPContainerReader extends AbstractContainerReader
{
    public function __construct()
    {
        $this->config = array_merge(
            PHPConfigReader::getDIFrameworkFile(),
            PHPConfigReader::getDIAppFile(),
        );
    }
}
