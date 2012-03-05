<?php
/**
 * Api 基础类
 * @author Chris
 * @copyright cdcchen@gmail.com
 * @package api
 */
class ApiBase
{
    private $_appParams;
    
    public function __construct($params = array())
    {
        $this->_appParams = $params;
    }
    
    protected static function requirePost()
    {
        self::requireMethods('POST');
    }
    
    protected static function requireGet()
    {
        self::requireMethods('GET');
    }
    
    protected static function requireMethods($methods)
    {
        if (is_string($methods))
            $methods = array($methods);

        $methods = array_map('strtoupper', $methods);
        if (!isset($_SERVER['REQUEST_METHOD']) || !in_array($_SERVER['REQUEST_METHOD'], $methods, true)) {
            $methodString = join('|', $methods);
            throw new ApiException("此方法必须使用{$methodString}请求", ApiError::HTTP_METHOD_ERROR);
        }
    }
    
    protected function requiredParams($params)
    {
        if (is_string($params)) $params = array($params);
        
        $errno = false;
        if (request()->getIsPostRequest())
            $method = 'getPost';
        elseif (request()->getIsPutRequest())
            $method = 'getPut';
        elseif (request()->getIsDeleteRequest())
            $method = 'getDelete';
        else
            $method = 'getQuery';
        
        foreach ($params as $param) {
            $result = call_user_func(array($this, $method), $param);
            if ($result === false || $result === null) {
                $errno = true;
                break;
            }
        }
        if ($errno) {
            throw new ApiException("请求参数不完整，缺少必要参数", ApiError::ARGS_NOT_COMPLETE);
        }
    }
    
    
    protected function requireLogin()
    {
        // @todo not complete
        $token = $this->getParam('token');
    	if (empty($token))
    		throw new ApiException('此api需要用户登录', ApiError::USER_TOKEN_ERROR);
    }

    
    
    protected function getAppParam($name, $defaultValue = null)
    {
        if (array_key_exists($name, $this->_appParams))
            return $this->_appParams[$name];
        else
            return false;
    }
    
    protected function getParam($name, $defaultValue = null)
    {
        return request()->getParam($name, $defaultValue);
    }
    
    protected function getQuery($name, $defaultValue = null)
    {
        return request()->getQuery($name, $defaultValue);
    }
    
    protected function getPost($name, $defaultValue = null)
    {
        return request()->getPost($name, $defaultValue);
    }
    
    protected function getPut($name, $defaultValue = null)
    {
        return request()->getPut($name, $defaultValue);
    }
    
    protected function getDelete($name, $defaultValue = null)
    {
        return request()->getDelete($name, $defaultValue);
    }
    
}





