<?php

declare(strict_types=1);

namespace controller\core;

use controller\core\Request;
use controller\core\Response;
use controller\core\Session;

class ActionBase
{
    protected $session;
    protected $request;
    protected $response;

    /**
     * base construct
     */
    public function __construct($settings)
    {
        $this->request = new Request($settings);
        $this->response = new Response();
        $this->session  = new Session();
    }
}