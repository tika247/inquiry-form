<?php

namespace controller\core;

use model\Mail;

class Logic
{
    private $date;
    
    public function __construct()
    {
        $this->date = date('Y/m/d H:i:s');
    }
    
    /**
     * @access public
     * @param string $to
     * @param array $params
     * @param array $settings
     * @param array $label
     * @param object $response
     * @param string $type
     * @return bool
     */
    public function sendmail($to, array $params = [], array $settings = [], array $label = [], \controller\core\Response $response, $type = 'admin')
    {
        $mail = new Mail();
        
        $mail_settings = $settings['MAIL_' . strtoupper($type)];
        
        if ($type === 'user')
        {
            $mail_settings['to'] = $to;
        }
        $mail_settings['body'] = $response->assign($params)->assign($label)->setTemplate($mail_settings['template'])->fetch();
        
        $mail->send($mail_settings, false);
    }
    
    /**
     * csv 保存
     */
    public function csv(array $params = [], $save_dir)
    {
        // 保存
    }
}
