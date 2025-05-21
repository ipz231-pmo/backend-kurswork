<?php

namespace controllers;

use core\Controller;
use core\Core;

class SiteController extends Controller
{
    public function __construct(Core $core)
    {
        parent::__construct($core);
    }
    
    public function actionIndex()
    {
        $this->View();
    }
    public function actionAbout()
    {
        $this->View();
    }
}