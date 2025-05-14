<?php

namespace controllers;

use core\Controller;
use core\Core;

class SiteController extends Controller
{
    public function __construct(Core $core, $controllerName, $actionName)
    {
        parent::__construct($core, $controllerName, $actionName);
    }
    
    public function actionIndex()
    {
        echo '<h1>SiteController -> actionIndex!</h1>';
    }
    public function actionAbout()
    {
        $this->template->render();
    }
}