<?php

namespace core;

use Exception;

class Template
{
    protected array $parameters = [];
    protected string $templatePath;
    
    public function __construct($templatePath) {
        $this->templatePath = $templatePath;
    }
    
    public function setParameter($name, $value) {
        $this->parameters[$name] = $value;
    }
    public function getParameter($name) {
        return $this->parameters[$name];
    }
    public function setParameters($parameters) {
        foreach ($parameters as $name => $value)
            $this->parameters[$name] = $value;
    }
    public function getParameters() {
        return $this->parameters;
    }
    public function __get($name) {
        return $this->getParameter($name);
    }
    public function __set($name, $value) {
        $this->setParameter($name, $value);
    }
    
    public function render() {
        echo $this->getOutput();
    }
    public function getOutput() {
        ob_start();
        extract($this->parameters);
        include $this->templatePath;
        return ob_get_clean();
    }
    
    public function setTemplatePath(string $path)  {
        $this->templatePath = $path;
    }
}