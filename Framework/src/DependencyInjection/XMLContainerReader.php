<?php

namespace Framework\DependencyInjection;

use Framework\ConfigReader\XMLConfigReader;
use SimpleXMLElement;

class XMLContainerReader extends AbstractContainerReader
{
    public function __construct()
    {
        $this->config = $this->mergeXMLElements(
            XMLConfigReader::getDIFrameworkFile(),
            XMLConfigReader::getDIAppFile(),
        );
    }

    private function mergeXMLElements(SimpleXMLElement $framework, ?SimpleXMLElement $app): array
    {
        $data = $this->getData($framework);
        if (!$app || !isset($app->class)) {
            return $data;
        }

        $appData = $this->getData($app);
        return array_merge(
            $data, $appData
        );
    }

    private function getData(SimpleXMLElement $element): array
    {
        $data = [];
        foreach ($element->class as $class) {
            $name = (string) $class['name'];
            $params = [];
            
            if ($args = $class?->args?->arg) {
                $params['args'] = (array) $args;
            }

            if ($base = $class?->base) {
                $params['class'] = (string) $base;
            }

            if ($method = $class?->method) {
                $params['method'] = (string) $method;
            }

            $data[$name] = $params;
        }

        return $data;
    }
}
