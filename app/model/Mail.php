<?php

namespace model;

/**
 * SMTP対応/添付ファイル対応
 *
 * @todo Logger & s/mime.
 */
class Mail
{
    public $mail;
    
    public function __construct()
    {
        $this->mail = new \PHPMailer();
    }
    
    /**
     * Mail sender.
     */
    public function send($settings = [], $smtp = false)
    {
        if ($smtp === true)
        {
            $this->mail->isSMTP();
            
            $this->mail->SMTPAuth   = true;
            $this->mail->Host       = $settings['SMTP_HOST_NAME'];
            $this->mail->Username   = $settings['SMTP_USER_NAME'];
            $this->mail->Password   = $settings['SMTP_PASSWORD'];
            $this->mail->SMTPSecure = $settings['SMTP_MAIL_ENCRPT'];
            $this->mail->Port       = $settings['SMTP_PORT'];
        }
        
        // iso-2022-jp-ms or utf-8
        if (strtolower($settings['charset']) === 'iso-2022-jp-ms')
        {
            $mail_header_charset = 'ISO-2022-JP';
            $this->mail->CharSet = $mail_header_charset;
        }
        else
        {
            $this->mail->CharSet = $settings['charset'];
        }
        $this->mail->Encoding = $settings['encoding'];
        
        if ($settings['envelope'])
        {
            $this->mail->Sender = $settings['envelope'];
        }
        
        // 複数指定の場合
        if (preg_match('/,/', $settings['to']))
        {
            $to_list = preg_split('/,/', $settings['to']);
            
            foreach ($to_list as $value)
            {
                $this->mail->addAddress($value);
            }
        }
        else
        {
            $this->mail->addAddress($settings['to']);
        }
        
        if (strlen($settings['cc']))
        {
            $this->mail->addCc($settings['cc']);
        }
        
        if (strlen($settings['bcc']))
        {
            $this->mail->addBcc($settings['bcc']);
        }
        
        $this->mail->From = $settings['from'];
        $this->mail->FromName = $settings['from_name'];
        
        if ($settings['qmail'] == 1)
        {
            $this->mail->Subject = mb_encode_mimeheader($settings['subject'], $settings['charset'], 'B', "\n");
        }
        else
        {
            $this->mail->Subject = mb_encode_mimeheader($settings['subject'], $settings['charset']);
        }
        
        // 本文設定
        $this->mail->Body = mb_convert_encoding($settings['body'], $settings['charset'], $settings['charset']);
        
        // 添付ファイルが必要な場合
        if ($settings['attach_file'])
        {
            $this->addAttachment($settings);
        }
        
        if (!$this->mail->send())
        {
            // Logger.
            return false;
        }
        return true;
    }
    
    /**
     * 添付ファイル追加
     */
    public function addAttachment($settings = [])
    {
        $settings['attach_file_name'] = mb_encode_mimeheader($settings['attach_file_name'], $settings['charset']);
        
        // addAttachment($path, $name = '', $encoding = 'base64', $type = '', $disposition = 'attachment')
        $this->mail->addAttachment($settings['attach_file'], $settings['attach_file_name']);
    }
    
    /**
     *
     */
    public function clearAddresses()
    {
        $this->mail->clearAddresses();
    }
    
    public function setBody($body)
    {
        $this->mail->Body = $body;
    }
}
