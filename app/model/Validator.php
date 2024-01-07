<?php

namespace model;

/**
 * Validation
 */
class Validator
{
    protected $error = [];
    
    protected $message = [];
    
    public function __construct($message_file = null, $language = 'en')
    {
        $messages = [];
        
        if (isset($message_file))
        {
            $messages = parse_ini_file(ROOT . $message_file, true);
            
            foreach ($messages as $lang => $record)
            {
                if (strtolower($language) === $lang)
                {
                    foreach ($record as $key => $message)
                    {
                        $this->message[$key] = $message;
                    }
                }
            }
        }
    }
    
    /**
     * Execute
     */
    public function execute($validator_list, $params, array $label = [])
    {
        foreach ($validator_list as $err_group => $err_content)
        {
            foreach ($err_content as $key => $err_dsn)
            {
                if (strlen($err_dsn))
                {
                    $err_list = preg_split('/#/', $err_dsn);

                    foreach ($err_list as $dsn)
                    {
                        $parts = [];
                        
                        list($class_method, $options) = preg_split('#://#', $dsn);
                        list($header, $parts['target_name']) = preg_split('#/#', $options);
                        list($parts['option'], $parts['message']) = preg_split('#:#', $header);
                        
                        if (preg_match('/&/', $parts['target_name']))
                        {
                            $parts['target_array'] = preg_split('/&/', $parts['target_name']);
                        }

                        $this->errors[$err_group][$key . '_' . $class_method] = $this->$class_method($params, $parts, $label);
                    }
                }
            }
        }
    }
    
    /**
     * Normalization
     */
    private function normalization()
    {
        foreach ($this->errors as $group => $line)
        {
            foreach ($line as $k => $v)
            {
                if (strlen($this->errors[$group][$k]) === 0)
                {
                    unset($this->errors[$group][$k]);
                }
            }
        }
    }
    
    /**
     * Check All Required
     * @return string error message
     */
    protected function entered(array $params, array $o = [], array $label = [])
    {
        if (isset($o['target_array']) && is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]) === 0)
                {
                    return $o['message'] . $this->message[$o['option']];
                }
            }
        }
        else
        {
            if (is_array($params[$o['target_name']]))
            {
                if(count($params[$o['target_name']]) === 0)
                {
                    return $o['message'] . $this->message[$o['option']];
                }
            }
            elseif (strlen($params[$o['target_name']]) === 0)
            {
                return $o['message'] . $this->message[$o['option']];
            }
        }
    }
    
    /**
     * Check a Single Required
     * @return string error message
     */
    protected function enteredSingle(array $params, array $o = [], array $label = [])
    {
        $name_list = [];
        
        if (preg_match('/&/', $o['target_name']))
        {
            $name_list = preg_split('/&/', $o['target_name']);
            
            foreach ($name_list as $key => $value)
            {
                if (strlen($params[$value]) !== 0)
                {
                    return;
                }
            }
            return $o['message'] . $this->message[$o['option']];
        }
        elseif (is_array($params[$o['target_name']]))
        {
            foreach ($params[$o['target_name']] as $key => $value)
            {
                if (strlen($value) !== 0)
                {
                    return;
                }
            }
            return $o['message'] . $this->message[$o['option']];
        }
        else
        {
            if (strlen($params[$o['target_name']]) === 0)
            {
                return $o['message'] . $this->message[$o['option']];
            }
        }
    }
    
    /**
     * Check 2 are same
     * @return string  error message.
     */
    protected function compare(array $params, array $o = [], array $label = [])
    {
        if ($params[$o['target_array'][0]] !== $params[$o['target_array'][1]])
        {
            return $o['message'] . $this->message['compare'];
        }
    }
    
    /**
     * Only half-size number
     * @return string error message
     */
    protected function numeric(array $params, array $o = [], array $label = [])
    {
        if (is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]) && !preg_match('/^[0-9]+$/', $params[$value]))
                {
                    return $o['message'] . $this->message['numeric'];
                }
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]) && !preg_match('/^[0-9]+$/', $params[$o['target_name']]))
            {
                return $o['message'] . $this->message['numeric'];
            }
        }
    }
    
    /**
     * Only Alphabet
     * @return string error message
     */
    protected function alpha(array $params, array $o = [], array $label = [])
    {
        if (is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]) && !preg_match('/^[a-zA-Z]+$/', $value))
                {
                    return $o['message'] . $this->message['alpha'];
                }
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]) && !preg_match('/^[a-zA-Z]+$/', $params[$o['target_name']]))
            {
                return $o['message'] . $this->message['alpha'];
            }
        }
    }
    
    /**
     * Only Number and Alphabet
     * @return string error message
     */
    protected function alphaNumeric(array $params, array $o = [], array $label = [])
    {
        if (is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]) && !preg_match('/^[a-zA-Z0-9]+$/', $value))
                {
                    return $o['message'] . $this->message['alphanum'];
                }
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]) && !preg_match('/^[a-zA-Z0-9]+$/', $params[$o['target_name']]))
            {
                return $o['message'] . $this->message['alphanum'];
            }
        }
    }
    
    /**
     * ASCII Code
     * @return string error message
     */
    protected function ascii(array $params, array $o = [], array $label = [])
    {
        if (is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]) && !preg_match('/^[\x20-\x7E]+$/', $params[$value]))
                {
                    return $o['message'] . $this->message['ascii'];
                }
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]) && !preg_match('/^[\x20-\x7E]+$/', $params[$o['target_name']]))
            {
                return $o['message'] . $this->message['ascii'];
            }
        }
    }
    
    /**
     * Address 5 Column
     * @todo
     * @return string error message
     */
    protected function address5Column(array $params, array $o = [], array $label = [])
    {
        $address = $params[$o['target_array'][0]] . $params[$o['target_array'][1]] . $params[$o['target_array'][2]] . $params[$o['target_array'][3]] . $params[$o['target_array'][4]];
        
        if (strlen($address))
        {
            for ($i = 0; $i <= 4; $i ++)
            {
                if (!strlen($params[$o['target_array'][$i]]))
                {
                    return $o['message'] . $this->message['address'];
                }
            }
        }
    }
    
    /**
     * Phone 1column
     * @return string error message
     */
    protected function phone(array $params, array $o = [], array $label = [])
    {
        $regex = ['/^[0-9]{2,4}\-[0-9]{2,4}\-[0-9]{2,4}$/', '/^[0-9]{10,12}$/'];
        
        if (is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (preg_match('/-/', $params[$value]))
                {
                    if (strlen($params[$value]) && !preg_match($regex[0], $params[$value]))
                    {
                        return $o['message'] . $this->message['phone'];
                    }
                }
                else
                {
                    if (strlen($params[$value]) && !preg_match($regex[1], $params[$value]))
                    {
                        return $o['message'] . $this->message['phone'];
                    }
                }
            }
        }
        else
        {
            if (preg_match('/-/', $params[$o['target_name']]))
            {
                if (strlen($params[$o['target_name']]) && !preg_match($regex[0], $params[$o['target_name']]))
                {
                    return $o['message'] . $this->message['phone'];
                }
            }
            else
            {
                if (strlen($params[$o['target_name']]) && !preg_match($regex[1], $params[$o['target_name']]))
                {
                    return $o['message'] . $this->message['phone'];
                }
            }
        }
    }

    /**
     * Phone 2column
     * @return string error message
     */
    protected function phone2Column(array $params, array $o = [], array $label = [])
    {
        // 2 numbers
        if (strlen($params[$o['target_array'][0]]) && !preg_match('/^[0-9]{3}$/', $params[$o['target_array'][0]]))
        {
            return $o['message'] . $this->message['phone'];
        }
        
        // 7 numbers without space
        if (strlen($params[$o['target_array'][1]]) && !preg_match('/^[0-9]{7}$/', $params[$o['target_array'][1]]))
        {
            return $o['message'] . $this->message['phone'];
        }
    }
    
    /**
     * Phone 3column
     * @access  protected
     * @param   array
     * @return string error message
     */
    protected function phone3Column(array $params, array $o = [], array $label = [])
    {
        $phone = $params[$o['target_array'][0]] . $params[$o['target_array'][1]] . $params[$o['target_array'][2]];
        
        if (strlen($phone))
        {
            for ($i = 0; $i <= 2; $i ++)
            {
                if (strlen($params[$o['target_array'][$i]]) && !preg_match('/^[0-9]{2,6}$/', $params[$o['target_array'][$i]]))
                {
                    return $o['message'] . $this->message['phone'];
                }
            }
        }
    }

    /**
     * Postal Code 2column
     * @return string error message
     */
    protected function postal2Column(array $params, array $o = [], array $label = [])
    {
        if (strlen($params[$o['target_array'][0]]) && !preg_match('/^[0-9]{3}$/', $params[$o['target_array'][0]]))
        {
            return $o['message'] . $this->message['postal'];
        }
        
        if (strlen($params[$o['target_array'][1]]) && !preg_match('/^[0-9]{4}$/', $params[$o['target_array'][1]]))
        {
            return $o['message'] . $this->message['postal'];
        }
    }
    
    /**
     * Postal Code 1column
     * @return string error message
     */
    protected function postal(array $params, array $o = [], array $label = [])
    {
        if (preg_match('/-/', $params[$o['target_name']]))
        {
            if (strlen($params[$o['target_name']]) && !preg_match('/^[0-9]{3}\-[0-9]{4}$/', $params[$o['target_name']]))
            {
                return $o['message'] . $this->message['postal'];
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]) && !preg_match('/^[0-9]{7}$/', $params[$o['target_name']]))
            {
                return $o['message'] . $this->message['postal'];
            }
        }
    }
    
    /**
     * Check if all value are empty
     * @return string error message
     */
    protected function emptyAll(array $params, array $o = [], array $label = [])
    {
        if (is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]))
                {
                    return;
                }
            }
            return $o['message'] . $this->message[$o['option']];
        }
    }
    
    /**
     * Length
     * @access  protected
     * @return string error message
     */
    protected function length(array $params, array $o = [], array $label = [])
    {
        if (isset($o['target_array']) && is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]) && mb_strlen($params[$value]) > $o['option'])
                {
                    return $o['message'] . str_replace('[length]', $o['option'], $this->message['length']);
                }
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]) && mb_strlen($params[$o['target_name']]) > $o['option'])
            {
                return $o['message'] . str_replace('[length]', $o['option'], $this->message['length']);
            }
        }
    }
    
    /**
     * URL format.
     * @return string error message
     */
    protected function url(array $params, array $o = [], array $label = [])
    {
        $regex = '^https?+://';
        
        if (is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]))
                {
                    if (filter_var($params[$value], FILTER_VALIDATE_URL) === false && preg_match('#' . $regex . '#i', $params[$value]))
                    {
                        return $o['message'] . $this->message['url'];
                    }
                }
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]))
            {
                if (filter_var($params[$o['target_name']], FILTER_VALIDATE_URL) === false && preg_match('#' . $regex . '#i', $params[$o['target_name']]))
                {
                    return $o['message'] . $this->message['url'];
                }
            }
        }
    }
    
    /**
     * mail format.
     * @return string error message
     */
    protected function mail(array $params, array $o = [], array $label = [])
    {
        if (is_array($params[$o['target_name']]))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]) && filter_var($params[$value], FILTER_VALIDATE_EMAIL) === false)
                {
                    return $o['message'] . $this->message['mail'];
                }
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]) && filter_var($params[$o['target_name']], FILTER_VALIDATE_EMAIL) === false)
            {
                return $o['message'] . $this->message['mail'];
            }
        }
    }
    
    /**
     * Katakana
     * @return string error message
     */
    protected function katakana(array $params, array $o = [], array $label = [])
    {
        $regex = [
            'utf-8' => '^(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6])+$',
            'euc'   => '^(¥xa5[¥xa1-¥xf6]|¥xa1[¥xb3¥xb4¥xbc])+$'
        ];
        
        if (is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]) && !preg_match('/' . $regex[strtolower($o['option'])] . '/', $params[$value]))
                {
                    return $o['message'] . $this->message['katakana'];
                }
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]) && !preg_match('/' . $regex[strtolower($o['option'])] . '/', $params[$o['target_name']]))
            {
                return $o['message'] . $this->message['katakana'];
            }
        }
    }
    
    /**
     * Hiragana
     * @return string error message
     */
    protected function hiragana(array $params, array $o = [], array $label = [])
    {
        $regex = [
            'utf-8' => '^(?:\xE3\x81[\x81-\xBF]|\xE3\x82[\x80-\x93])+$',
            'euc'   => '^(¥xA4[¥xA1-¥xF3]|¥xA1[¥xB5¥xB6¥xAB])+$'
        ];
        
        if (is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$value]) && !preg_match('/' . $regex[strtolower($o['option'])] . '/', $params[$value]))
                {
                    return $o['message'] . $this->message['hiragana'];
                }
            }
        }
        else
        {
            if (strlen($params[$o['target_name']]) && !preg_match('/' . $regex[strtolower($o['option'])] . '/', $params[$o['target_name']]))
            {
                return $o['message'] . $this->message['hiragana'];
            }
        }
    }
    
    /**
     * Falsification
     * @return string error message
     */
    protected function falsification(array $params, array $o = [], array $label = [])
    {
        if (isset($o['target_array']) && is_array($o['target_array']))
        {
            foreach ($o['target_array'] as $key => $value)
            {
                if (strlen($params[$o['option']]) && !in_array($params[$o['option']], array_keys($label[$value], true)))
                {
                    return $o['message'] . $this->message['value'];
                }
            }
        }
        else
        {
            if (strlen($params[$o['option']]) && !in_array($params[$o['option']], array_keys($label[$o['target_name']], true)))
            {
                return $o['message'] . $this->message['value'];
            }
        }
    }
    
    /**
     * Get all error
     * @return array
     */
    public function getAllError()
    {
        $this->normalization();
        
        return $this->errors;
    }
    
    /**
     * Get all error list
     * @return array
     */
    public function getAllErrorList()
    {
        $error = [];
        
        foreach ($this->errors as $group => $line)
        {
            foreach ($line as $k => $v)
            {
                $error[] = $this->errors[$group][$k];
            }
        }
        return $error;
    }
    
    /**
     * Get error message
     * @return string error message.
     */
    public function getErrorMessage(string $error_group, string $class_method)
    {
        return $this->errors[$error_group][$class_method];
    }
    
    /**
     * Set Error Message
     */
    public function setErrorMessage(string $error_group, string $class_method, string $message)
    {
        $this->errors[$error_group][$class_method] = $message;
    }
    
    /**
     * Return integer of true/false
     * @return integer
     */
    public function isError()
    {
        return count(array_filter($this->getAllError()));
    }
}
