<?php

namespace controller\core;

// trait
use model\RemoveControlCode;

/**
 * POST/GET 受取処理
 */
class Request
{
    // trait
    use RemoveControlCode;

    protected $settings;
    public $method;
    public $form_name;
    public $validator;
    public $params;
    public $charset;
    
    /**
     * コンストラクタ
     */
    public function __construct($settings)
    {
        $this->settings = $settings;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->form_name = null;
        $this->validator = null;
        $this->params = null;

        $this->charset = $this->settings->settings['INI_SET']['charset'];
    }
    
    /**
     * form name と validateRuleをセット
     */
    public function set($file_name = null)
    {
        if (is_null($file_name))
        {
            return false;
        }
        
        $this->addFormName($file_name);
        
        $this->addValidatorList($file_name);
        
        return $this;
    }
    
    /**
     * Get Value from $_POST or $_SESSION
     */
    public function setValiables()
    {
        if ($this->method === 'POST')
        {
            foreach ($this->form_name as $key)
            {
                if(isset($_POST[$key])) {
                    $this->params[$key] = $_POST[$key];
                }
            }
        }
        elseif ($this->method === 'GET')
        {
            foreach ($this->form_name as $key)
            {
                $this->params[$key] = $_SESSION[$key];
            }
        }

        $this->params = $this->filter($this->params);
        
        return $this;
    }
    
    /**
     * nameによるFilterしない場合
     */
    public function setValiablesAll()
    {
        if ($this->method === 'POST')
        {
            $this->params = $_POST;
        }
        elseif ($this->method === 'GET')
        {
            $this->params = $_GET;
        }

        $this->filter();
        
        return $this;
    }
    
    /**
     * 
     */
    public function clearFormName()
    {
        $this->form_name = [];
    }
    
    /**
     * 
     */
    public function clearValidatorList()
    {
        $this->validator = [];
    }
    
    /**
     * 
     */
    public function addFormName($file_name = null)
    {
        $name_list = parse_ini_file(ROOT . $file_name, true);
        
        foreach ($name_list as $key => $params)
        {
            foreach ($params as $name => $value)
            {
                $this->form_name[] = $name;
            }
        }
        return $this;
    }
    
    /**
     * @access  public
     * @param   string    ini file name.
     */
    public function addValidatorList($file_name = null)
    {
        $name_list = parse_ini_file(ROOT . $file_name, true);
        
        foreach ($name_list as $group => $form_name)
        {
            foreach ($form_name as $key => $value)
            {
                $this->validator[$group][$key] = $value;
            }
        }

        return $this;
    }
    
    /**
     * 入力値に最低限必要な処理
     */
    public function filter($params = [])
    {
        foreach ($params as $key => $value)
        {
            if (is_object($value) || is_null($value))
            {
                continue;
            }
            elseif (is_array($value))
            {
                $value = self::filter($value);
            }
            else
            {
                $value = mb_convert_encoding($value, $this->charset);
                $value = $this->kanaFilter($value);
                $value = $this->removeControlCode($value);
                
                $value = str_replace("\r\n", "\n", $value);
                $value = str_replace("\r", "\n", $value);
                
                $value = $this->exTrim($value);
            }
            $params[$key] = $value;
        }
        return $params;
    }
    
    /**
     * 何も指定が無い場合は KV
     * @see mb_convert_kana()
     * @param array $params 入力値
     * @param array $option mb_convert_kanaの第2引数
     */
    public function kanaFilter($string, $option = 'KV')
    {
        return mb_convert_kana($string, $option, $this->charset);
    }
    
    /**
     * trim + 全角スペース utf-8用
     */
    public function exTrim($string)
    {
        return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $string);
    }
    
    /**
     * getter
     */
    public function getParams()
    {
        return $this->params;
    }
}
