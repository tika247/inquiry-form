<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return array(
    'model\\' => array($baseDir . '/app/model'),
    'controller\\' => array($baseDir . '/app/controller'),
    'Smarty\\' => array($baseDir . '/vender/smarty/smarty'),
    'PHPMailer\\PHPMailer\\' => array($vendorDir . '/phpmailer/phpmailer/src'),
    'PHPMailer\\' => array($baseDir . '/vender/phpmailer/phpmailer'),
);
