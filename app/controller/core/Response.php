<?php

namespace controller\core;

use model\MySmarty;

/**
 * Smartyを使用します
 */

class Response
{
    private $view;
    
    private $smarty;
    
    /**
     * Constructor
     * @param string $view
     * @return void
     */
    public function __construct()
    {
        $this->smarty = new MySmarty();
    }
    
    /**
     * @return object
     */
    public function clear()
    {
        $this->smarty->clearAllAssign();
        
        return $this;
    }
    
    /**
     * @return object
     */
    public function setTemplate($view)
    {
        // 先頭のスラッシュ削除
        $view = preg_replace('@^/@', '', $view);
        
        $this->view = $view;
        
        return $this;
    }
    
    /**
     * @return void
     */
    public function redirect($uri, $end = true)
    {
        header('Location:' . $uri);
        
        if ($end === true)
        {
            die();
        }
    }
    
    /**
     * @return object
     */
    public function assign($key = null, $value = null)
    {
        if (is_array($key))
        {
            $this->smarty->assign($key);
        }
        else
        {
            $this->smarty->assign($key, $value);
        }
        return $this;
    }
    
    /**
     * @return string
     */
    public function fetch()
    {
        return $this->smarty->fetch($this->view);
    }
    
    /**
     * @return object
     */
    public function output_filter()
    {
        $this->smarty->register_outputfilter([$this->smarty, '_smarty_output_filter']);
        
        return $this;
    }
    
    /**
     * @retrun object
     */
    public function display()
    {
        $this->smarty->display($this->view);
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function output_json($params)
    {
        if(!is_null($params) && is_array($params))
        {
            return false;
        }
        return json_encode($params);
    }
}
