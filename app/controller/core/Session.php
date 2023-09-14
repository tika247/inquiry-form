<?php

namespace controller\core;

/**
 * セッション管理
 *
 * @access public
 */
class Session
{
    protected $session_id;
    
    protected $session_name;
    
    private $__gc_max_lifetime;
    
    private $__cookie_lifetime;
    
    const SESSION_LIFE_TIME_NAME = '__session_life_time__';
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->session_id = md5(uniqid(rand(), true));
        
        $this->session_name = session_name();
        
        $this->gc_maxlifetime = ini_get('session.gc_maxlifetime');
        
        $this->cookie_lifetime = ini_get('session.cookie_lifetime');
    }
    
    /**
     * @access public
     * @see session_start()
     * @param string $session_name  session_name()
     * @param string $session_id    session id()
     * @param array $params         ini_set overrideする値
     * @return void
     */
    public function start($session_name = null)
    {
        if (!is_null($session_name))
        {
            $this->session_name = $session_name;
            
            session_name($this->session_name);
        }
        session_start();
        
        $current_time = time();
        
        // session_life_time が 0 じゃないなら
        if ($this->__cookie_lifetime > 0)
        {
            // 時間切れ
            if ($current_time - $this->get(self::SESSION_LIFE_TIME_NAME) > $this->__gc_maxlifetime)
            {
                $this->destroy();
            }
            else
            {
                $this->set(self::SESSION_LIFE_TIME_NAME, $current_time);
            }
        }
    }
    
    /**
     * セッションに格納する
     * セッションの値を破棄するには、nullを設定する
     *
     * @access public
     * @param mixed $key   セッションと値の配列もしくは単一ネームのみ
     * @param mixed $param セッションに入れる値。非配列の場合使用
     * @return void
     */
    public function set($keys, $params)
    {
        if (is_array($keys) && is_array($params))
        {
            foreach ($keys as $key)
            {
                if (isset($params[$key]) && is_null($params[$key]))
                {
                    unset($_SESSION[$key]);
                }
                else
                {
                    if(isset($params[$key])) {
                        $_SESSION[$key] = $params[$key];
                    }
                }
            }
        }
        else 
        {
            if (is_null($params))
            {
                unset($_SESSION[$keys]);
            }
            else
            {
                $_SESSION[$keys] = $params;
            }
        }
    }
    
    /**
     * セッション取得
     *
     * @access public
     * @param mixed $params ネームの配列もしくは単一ネーム
     * @return mixed セッションの値
     */
    public function get($params)
    {
        $session = [];

        if (is_array($params)&& count($params))
        {
            foreach ($params as $key)
            {
                if(isset($_SESSION[$key])) {
                    $session[$key] = $_SESSION[$key];
                }
            }
            return $session;
        }
        else
        {
            return $_SESSION[$params];
        }
    }
    
    /**
     * @return $_SESSION
     */
    public function getAll()
    {
        return $_SESSION;
    }
    
    /**
     * @see session_regenerate_id
     */
    public function regenerate()
    {
        session_regenerate_id(true);
    }
    
    /**
     * sessionを破棄する
     * @return void
     */
    public function destroy()
    {
        $cookie = session_get_cookie_params();
        
        $_SESSION = [];
        
        setcookie($this->session_name, '', time() - 42000, $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);
        
        session_destroy();
    }
    
    /**
     * ワンタイムチケット発行
     */
    public function setToken($token_name = 'token')
    {
        $token = openssl_random_pseudo_bytes(16);
        
        $this->set($token_name, bin2hex($token));
        
        return $this->get($token_name);
    }
    
    /**
     * 比較
     */
    public function verifyToken($post_token, $token_name = 'token')
    {
        $sess_token = $this->get($token_name);
        
        $this->set($token_name, null);
        
        if (!preg_match( '/^[0-9a-f]{32}$/', $post_token) || !preg_match( '/^[0-9a-f]{32}$/', $sess_token))
        {
            return false;
        }
        
        if ($sess_token === $post_token)
        {
            return true;
        }
        return false;
    }
    
    /**
     * 
     */
    public function setName($session_name = null)
    {
        if (!is_null($session_name))
        {
            $this->session_name = $session_name;
        }
    }
    
    /**
     *
     */
    public function getName()
    {
        return $this->session_name;
    }
    
    /**
     *
     */
    public function getId()
    {
        return $this->session_id;
    }
}
