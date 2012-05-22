<?php
class AppApi
{
    private static $_apiPath;
    
    private $_apikey;
    private $_secretKey;
    private $_format = 'json';
    private $_methods;
    private $_sig;
    private $_args;
    
    private $_class;
    private $_function;
    
    /**
     * 构造函数
     * @param string $apiUrl ApiBaseUrl
     * @param array $args
     */
    public function __construct($args)
    {
        $this->_args = $args;
    	$this->init();
    	
        if (empty($this->_apikey))
            $this->setApiPath(dirname(__FILE__));
        
        $this->parseArgs($args);
    }
    
    private function init()
    {
//        sleep(3);
        set_error_handler(array($this, 'errorHandler'), E_ERROR);
    	set_exception_handler(array($this, 'exceptionHandler'));
    }
    
    /**
     * 设置api类所在的路径
     * @param string $path
     * @throws ApiException
     * @return AppApi
     */
    public function setApiPath($path)
    {
        if (file_exists(realpath($path)))
            self::$_apiPath = rtrim($path, '\/') . DIRECTORY_SEPARATOR;
        else
            throw new ApiException('$path 不存在', ApiError::APIPATH_NO_EXIST);
            
        return $this;
    }
    
    /**
     * 运行AppApi
     */
    public function run()
    {
        $this->checkArgs()->execute();
        exit(0);
    }
    
    /**
     * 检查参数
     * @return AppApi
     */
    private function checkArgs()
    {
        $this->checkFormat()->checkApiKey();
        // @todo 暂时未检查签名
//         $this->checkSignature();
            
        return $this;
    }
    
    /**
     * 执行methods对应的命令
     * @throws ApiException
     */
    private function execute()
    {
        $result = call_user_func($this->parsekMethods());
        if (false === $result)
            throw new ApiException('$class->$method 执行错误', ApiError::CLASS_METHOD_EXECUTE_ERROR);
        else
            self::output($result, $this->_format);
    }
    
    /**
     * 分析用户提交的参数
     * @param array $args
     * @return AppApi
     */
    private function parseArgs($args)
    {
        $this->checkRequiredArgs();
        
        foreach ($args as $key => $value)
            $args[$key] = strip_tags(trim($value));
            
        $args['apikey'] && $this->_apikey = $args['apikey'];
        $args['format'] && $this->_format = $args['format'];
        $args['methods'] && $this->_methods = $args['methods'];
        $args['signature'] && $this->_sig = $args['signature'];
        
        return $this;
    }
    
    /**
     * 检查必需的参数
     * apikey, signature, methods 为必须有的参数
     * @throws ApiException
     * @return AppApi
     */
    private function checkRequiredArgs()
    {
        $params = array('apikey', 'methods');
        $keys = array_keys($this->_args);
        $diff = array_diff($params, $keys);
        if ($diff) {
            throw new ApiException('缺少必须的参数: ' . join(',', $diff), ApiError::ARGS_NOT_COMPLETE);
        }
        return $this;
    }

    /**
     * 检查apikey
     * @throws ApiException
     * @return AppApi
     */
    private function checkApiKey()
    {
        $keys = (array)require(dirname(__FILE__) . DS . 'keys.php');
        if (array_key_exists($this->_apikey, $keys)) {
            $this->_secretKey = $keys[$this->_apikey];
        }
        else
            throw new ApiException('apikey不存在', ApiError::APIKEY_INVALID);
        return $this;
    }
    
    /**
     * 检查format参数
     * @throws ApiException
     * @return AppApi
     */
    private function checkFormat()
    {
        if (!in_array(strtolower($this->_format), array('json', 'xml', 'jsonp'))) {
            throw new ApiException('format 参数错误', ApiError::FORMAT_INVALID);
        }
        return $this;
    }
    
    /**
     * 解析method参数
     * @throws ApiException
     * @return array 0=>object, 1=>method
     */
    private function parsekMethods()
    {
        list($class, $method) = explode('.', $this->_methods);
        if (empty($class) || empty($method)) {
            throw new ApiException('methods参数格式不正确', ApiError::METHOD_FORMAT_ERROR);
        }
        
        $class = 'Api_' . ucfirst(strtolower($class));
        if (!class_exists($class, false))
            self::importClass($class);

        if (!class_exists($class, false))
            throw new ApiException('$class 类定义不存在', ApiError::CLASS_FILE_NOT_EXIST);
            
        $object = new $class($this->_args);
        $method = strtolower($method);
        if (!method_exists($object, $method))
            throw new ApiException('$method 方法不存在', ApiError::CLASS_METHOD_NOT_EXIST);
        
        return array($object, $method);
    }
    
    /**
     * 导入api类
     * @param string $class
     * @throws ApiException
     */
    private static function importClass($class)
    {
        try {
            require self::$_apiPath . ucfirst($class) . '.php';
        }
        catch (Exception $e) {
            throw new ApiException('$class 文件导入错误', ApiError::CLASS_FILE_NOT_EXIST);
        }
    }
    
    /**
     * 验证用户提交签名是否正确
     * @throws ApiException
     * @return AppApi
     */
    private function checkSignature()
    {
        $sig1 = $this->_sig;
        $sig2 = $this->makeSignature();
        if ($sig1 != $sig2) {
            throw new ApiException('$sig 签名不正确', ApiError::SIGNATURE_ERROR);
        }
        return $this;
    }
    
    /**
     * 计算签名
     * @return string 签名
     */
    private function makeSignature()
    {
        // @todo 签名方法未实现
        $signature = md5($this->_apikey . $this->_secretKey);
        return $signature;
    }
    
    private static function output($data, $format = 'json')
    {
        $method = 'output' . ucfirst(strtolower($format));
        echo self::$method($data);
    }
    
    /**
     * 返回json编码数据
     * @param mixed $data
     * @return string json编码后的数据
     */
    private static function outputJson($data)
    {
        return CJSON::encode($data);
    }
    
    /**
     * 返回xml格式数据
     * @param mixed $data
     * @return string xml数据
     */
    private static function outputXml($data)
    {
        return 'xml';
    }
    
    private static function outputJsonp($data)
    {
        return $this->_args['callback'] . '(' . json_encode($data) . ')';
    }
    
    
    public function errorHandler($errno, $message, $file, $line)
    {
        if (isset($this->_args[debug]) && $this->_args[debug])
            $error = array('errno'=>$errno, 'message'=>$error, 'line'=>$line, 'file'=>$file);
        else
            $error = 'ERROR';
    	echo json_encode($error);
    	exit(0);
    }
    
    public function exceptionHandler($e)
    {
    	if (isset($this->_args['debug']) && $this->_args['debug'])
    		$error = array('errno'=>$e->getCode(), 'message'=>$e->getMessage());
    	else
    		$error = 'ERROR';
        echo json_encode($error);
    	exit(0);
    }
    
}