<?php

declare(strict_types=1);

namespace controller;

class Settings
{
    public $settingsIniPath;
    public $dependencyPath;
    public $settings;

    final public function __construct()
    {
        $this->settingsIniPath = ROOT . '/app/config/settings.ini';
        $this->dependencyPath = ROOT . '/app/config/dependency/';
        $this->settings = [];

        $this->init();

        return $this->settings;
    }

    /**
     * Init
     */
    public function init()
    {
        $this->defineSettings();
        $this->defineTimezone();
        $this->defineDependenciy();
        $this->overrideIni();
        $this->defineSession();
        $this->defineSmarty();
        $this->defineErrorHandler();
    }

    /**
     * Define settings
     */
    private function defineSettings()
    {
        $this->settings = parse_ini_file($this->settingsIniPath, true);
    }

    /**
     * Define timezone
     */
    private function defineTimezone()
    {
        date_default_timezone_set($this->settings['PHP']['timezone']);
    }
    
    /**
     * Define dependency
     */
    private function defineDependenciy()
    {
        if (isset($_SERVER['SERVER_NAME']))
        {
            $host_name = $_SERVER['SERVER_NAME'];
        }
        elseif (isset($_SERVER['REMOTE_ADDR']))
        {
            $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        }
    
        // TODO: change for 'domain'
        if (preg_match('/\.mitsue\.(co\.jp|com)$/', $host_name))
        {
            $environment = 'dev';
            error_reporting($this->settings['ERROR_REPORT']['dev']);
        }
        elseif (preg_match('/\.domain\.co\.jp$/', $host_name))
        {
            $environment = 'stage';
            error_reporting($this->settings['ERROR_REPORT']['pro']);
        }
        else
        {
            $environment = 'live';
            error_reporting($this->settings['ERROR_REPORT']['pro']);
        }
        
        $dependency = parse_ini_file($this->dependencyPath . strtolower($environment) . '.ini', true);
        
        // merge
        $this->settings = array_merge($this->settings, $dependency);
        $this->settings['ENV']['server'] = $environment;
    }
    
    /**
     * Override by ini_set
     */
    private function overrideIni()
    {
        foreach ($this->settings['INI_SET'] as $k => $v)
        {
            ini_set($k, $v);
        }
        
        mb_regex_encoding($this->settings['INI_SET']['charset']);
        ini_set('error_log', ROOT . $this->settings['INI_SET']['error_log']);
    }
    
    /**
     * Define session
     */
    private function defineSession()
    {
        foreach ($this->settings['SESSION'] as $k => $v)
        {
            ini_set('session.' . $k, $v);
        }
        session_cache_limiter($this->settings['SESSION']['session_cache_limiter']);
    }
    
    /**
     * Define Smarty
     */
    private function defineSmarty()
    {
        define('SMARTY_CONFIG_DIR', ROOT . $this->settings['SMARTY']['config']);
        define('SMARTY_COMPILE_DIR', ROOT . $this->settings['SMARTY']['compile']);
        define('SMARTY_CACHE_DIR', ROOT . $this->settings['SMARTY']['cache']);
        define('SMARTY_TEMPLATE_DIR', ROOT . $this->settings['SMARTY']['template']);
    }
    
    /**
     * Define Error Handler
     */
    private function defineErrorHandler()
    {
        $settings = $this->settings;
        $environment = $this->settings['ENV']['server'];
        $my_error_handler = function($error_no, $error_msg, $error_file, $error_line) use($settings, $environment) {
        
            switch ($error_no)
            {
                case E_NOTICE :
                case E_USER_NOTICE :
                    $severity_msg = 'Notice';
                break;
                
                case E_STRICT :
                case E_WARNING :
                case E_CORE_WARNING :
                case E_COMPILE_WARNING :
                case E_DEPRECATED :
                case E_USER_WARNING :
                case E_USER_DEPRECATED :
                    $severity_msg = 'Warning';
                break;
                
                default :
                    $severity_msg = 'Fatal error';
            }
            
            $error_text = sprintf('%s: %s filename: %s line: %s', $severity_msg, $error_msg, $error_file, $error_line);
            
            // development only.
            if ($environment === 'dev')
            {
                print $error_text;
            }
            
            if (ini_get('log_errors'))
            {
                error_log($error_text);
            }
        };
        
        set_exception_handler(function($error_no, $error_msg, $error_file, $error_line) use($my_error_handler) {
            
            // warning 処理続行
            if ($error_no === E_WARNING || $error_no === E_CORE_WARNING || $error_no === E_COMPILE_WARNING)
            {
                $my_error_handler($error_no, $error_msg, $error_file, $error_line);
            }
            elseif (error_reporting() & $error_no)
            {
                throw new ErrorException($error_msg, 0, $error_no, $error_file, $error_line);
            }
        });
        
        set_exception_handler(function($throwable) use($my_error_handler) {
            
            if ($throwable instanceof ErrorException)
            {
                $my_error_handler($throwable->getSeverity(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
            }
            else
            {
                $my_error_handler($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
            }
        });
        
        register_shutdown_function(function() use($my_error_handler) {
            
            $error = error_get_last();
            
            if (!is_null($error))
            {
                $my_error_handler($error['type'], $error['message'], $error['file'], $error['line']);
            }
        });
    }
}