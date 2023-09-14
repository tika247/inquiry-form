<?php

declare(strict_types=1);

namespace controller;

use controller\core\ActionBase;
use controller\core\Logic;
use model\Validator;

// trait
use model\GetLabel;

class Action extends ActionBase
{
    // trait
    use GetLabel;

    protected $validator;
    protected $settings;
    protected $label;
    protected $action_method;

    const FORM_INI_FILE = '/app/config/form.ini';
    const MESSAGE_INI_FILE = '/app/config/message.ini';
    const LABEL_INI_FILE = '/app/config/label.ini';
    const DEFAULT_METHOD = 'index';
    const METHOD_KEY = 'action_method';

    final public function __construct(object $settings)
    {
        parent::__construct($settings);
        $this->settings = $settings;
        $this->label = null;
        $this->action_method = null;
    }
    public function init()
    {
        $this->setLabel();
        $this->sessionStart();
        $this->setActionMethod();
        $this->validator = new Validator(self::MESSAGE_INI_FILE);
        // require_once ROOT . '/app/templates/_origin/complete.html';

        $this->execute();
    }

    /**
     * Execute
     */
    private function execute()
    {
        if (method_exists($this, $this->action_method))
        {
            $method = $this->action_method;
            $this->$method();
        }
    }

    /**
     * Set Label
     */
    private function setLabel()
    {
        $this->label = $this->getLabel(ROOT . self::LABEL_INI_FILE);
    }

    /**
     * Session Start
     */
    private function sessionStart()
    {
        $this->session_name = sha1('my_app_contact');
        $this->session->start($this->session_name);
    }

    /**
     * set action_method in SESSION
     */
    private function setActionMethod()
    {
        if (array_key_exists('target_page', $_SESSION)) {
            $this->action_method = $_SESSION['target_page'];
        } else if (array_key_exists('target_page', $_POST)) {
            $this->action_method = $_POST['target_page'];
        } else if (array_key_exists('target_page', $_GET)) {
            $this->action_method = $_GET['target_page'];
        } else {
            $this->action_method = self::DEFAULT_METHOD;
        }

        $this->action_method = rtrim($this->action_method, '/');
        $this->action_method = ltrim($this->action_method, '/');

        $this->session->set(self::METHOD_KEY, $this->action_method);
    }

    /**
     * Index
     * if session_items, reflect them
     */
    public function index()
    {
        $session_items = $this->session->getAll();

        if(count($session_items) === 1 && array_key_first($session_items) === self::METHOD_KEY) {
            $this->response
                ->assign($this->label)
                ->setTemplate('/index.html')
                ->display();
        } else {
            $this->response
            ->setTemplate('/index.html')
            ->assign($this->session->getAll())
            ->assign($this->label)
            ->display();
        }
    }

    
    /**
     * Confirm
     */
    public function confirm()
    {
        $this->request->set(self::FORM_INI_FILE)->setValiables();

        $this->session->set($this->request->form_name, $this->request->params);

        // todo ここの$this->session->get($this->request->form_name)に値入りの配列が入ってくるようにする
        $this->validator->execute($this->request->validator, $this->session->get($this->request->form_name), $this->label);

        if ($this->validator->isError())
        {
            $this->response
                ->assign('is_error', $this->validator->isError())
                ->assign('error_list', $this->validator->getAllErrorList())
                ->assign($this->validator->getAllError())
                ->setTemplate('/index.html');
        }
        else
        {
            $this->response
                ->assign('token', $this->session->setToken())
                ->setTemplate('/confirm.html');
        }
        $this->response
            ->assign($this->session->getAll())
            ->assign($this->label)
            ->display();
    }

    /**
     * Complete
     */
    public function complete()
    {
        $this->request->set(self::FORM_INI_FILE)->setValiables();
        
        // Csrf
        if (!$this->session->verifyToken($this->request->params['token']))
        {
            $this->session->destroy();
            $this->response->redirect('/');
        }
        else
        {
            $this->validator->execute($this->request->validator, $this->session->get($this->request->form_name), $this->label);
            
            if ($this->validator->isError())
            {
                $this->session->destroy();
                $this->response->redirect('/');
            }
            
            // is executed in Complete page
            $logic = new Logic();
            
            // Admin
            $logic->sendmail($this->session->get('email'), $this->session->getAll(), $this->settings, $this->label, $this->response, 'admin');
            
            // User
            $logic->sendmail($this->session->get('email'), $this->session->getAll(), $this->settings, $this->label, $this->response, 'user');
            
            // csv保存
            // $logic->addCsv($this->session->getAll(), APPS_DIR . '/../data/data.csv');
        }
        $this->session->destroy();
        $this->response->redirect('/complete.html');
    }
}
