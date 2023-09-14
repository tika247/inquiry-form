<?php

namespace controller;

require_once ROOT . "/vendor/autoload.php";

use controller\Settings;
use controller\Action;


/**
 * Dispatcher
 */
class Dispatcher
{
    public function __construct(){}
    
    /**
     * Init
     */
    public function init()
    {
        $settings = new Settings();
        $action = new Action($settings);
        $action->init();
    }
}
