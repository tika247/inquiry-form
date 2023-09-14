<?php

namespace model;

/**
 * Smarty 設定
 */
class MySmarty extends \Smarty
{
    function __construct($smarty = [])
    {
        parent::__construct();
        
        // default escape.
        $this->escape_html  = true;
        
        $this->left_delimiter  =  '{';
        
        $this->right_delimiter =  '}';
        
        // Set smarty directory path for form.
        $this->template_dir = SMARTY_TEMPLATE_DIR;
        
        $this->config_dir = SMARTY_CONFIG_DIR;
        
        $this->compile_dir = SMARTY_COMPILE_DIR;
        
        $this->cache_dir = SMARTY_CACHE_DIR;
    }
    
    /**
     * @access private
     */
    private function __smarty_pre_filter($tpl, $from_charset, $to_charset)
    {
        return mb_convert_encoding($tpl, $to_charset, $from_charset);
    }
    
    /**
     * @access private
     */
    private function __smarty_output_filter($tpl, $from_charset, $to_charset)
    {
        return mb_convert_encoding($tpl, $to_charset, $from_charset);
    }
}
