<?php

namespace core;

abstract class Middleware
{
    protected $next, $core;
    public function __construct($core)
    {
        $this->core = $core;
    }
    
    public function setNext($next)
    {
        $this->next = $next;
    }
    public abstract function handle();
}