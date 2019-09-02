<?php
class Route{
    /**
     * �ṩƥ���uri
     * @var String
     */
    private $pattern = null;

    /**
     * �ṩƥ��uri��������ʽ
     * @var String
     */
    private $pattern_arr = null;

    /**
     * �洢�ڱ�Route������
     * @var array
     */
    private $storage = array();

    /**
     * �ɽ��ܵķ���HTTP����
     * @var array
     */
    private $methods = array(
        'GET', 'POST', 'PUT', 'DELETE', 'PATCH'
    );

    /**
     * ����ƥ���õĲ���
     * @var array
     */
    private $params;

    /**
     * ���캯��
     * @param $pattern  string  ƥ���·�ɹ��� eg: /users/:id/edit
     * @param $storage    array   ��·�ɴ洢����Ϣ
     * @param null $methods array   ��·�ɿɽ��ܵ�HTTP����
     */
    public function __construct($pattern, $storage, $methods = null)
    {
        $this->pattern = $pattern;
        $this->storage = $storage;
        if (!is_null($methods)) {
            $this->methods = (array)$methods;
        }
    }

    /**
     * �������ñ�·�ɽ��ܵ�HTTP����
     */
    public function via()
    {
        $methods = (array)func_get_args();
        if(count($methods) === 1 and is_array($methods[0])){
            $methods = $methods[0];
        }
        $this->methods = array_map('strtoupper',$methods);
    }

    /**
     * ��URIת���ɿ��õ�������ʽ
     */
    private function uri_to_array($uri)
    {
        // reg = '/+'
        return preg_split('|(?mi-Us)/+|', trim($uri, '/'));
    }
    /**
     * ����Route RUI��ƥ��õ��Ĳ�������
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
    /**
     * ��ȡ���뱾Route����Ϣ
     * @return array
     */
    public function getStorage()
    {
        return $this->storage;
    }
    /**
     * ��ȡ��·�ɵ�����ƥ���URI
     * @return String
     */
    public function getUri()
    {
        return $this->pattern;
    }
    /**
     * ��ȡ��·�������Method����
     * @return array
     */
    public function getMethods()
    {
        return array_unique($this->methods);
    }
    /**
     * �ж�uri�Ƿ��뱾·��ƥ��
     * @param $request_uri string �����URI    e.g: /user/1/edit
     * @param $request_method
     * @return boolean
     */
    public function match($request_uri, $request_method)
    {
        // �������·�ɿɽ��ܵ�HTTP����
        if(!$this->allow_method($request_method)) return false;
        if ($this->pattern_arr === null) {
            $this->pattern_arr = $this->uri_to_array($this->pattern);
        }
        $uri_arr = $this->uri_to_array($request_uri); //���˴�Request��uriת����array
        $maximum = count($this->pattern_arr); //��ǰpattern�ɽ������ڵ���
        //��ǰ����Ľڵ�����������patter�ɽ��ܵ����ڵ������ֱ�ӷ��ز�ƥ��
        if ( count($uri_arr) > $maximum) return false;
        //���ҳ�uri�еĲ����ڵ� regular =  :\w+\??
        preg_match_all('|(?mi-Us):\\w+\\??|', $this->pattern, $rxMatches);
        foreach ($this->pattern_arr as $key => $value) {
            //�����ǰ�ڵ��ǲ����ڵ�
            if (in_array($value, $rxMatches[0])) {
                $param_name = trim($value, ':?'); //�����ڵ���
                // ��ѡ�����ڵ�
                if (substr($value, -1) == '?') {
                    if (array_key_exists($key, $uri_arr)) {
                        $this->params[$param_name] = $uri_arr[$key];
                        continue;
                    }
                    else return true;
                }
                // ��ͨ�����ڵ�
                else {
                    if (array_key_exists($key, $uri_arr)) {
                        $this->params[$param_name] = $uri_arr[$key];
                        continue;
                    }
                    else return false;
                }
            }
            //��ͨ�޲����ڵ�
            $uri_value = array_key_exists($key, $uri_arr) ? $uri_arr[$key] : null;
            if ($value != $uri_value) return false;
        }
        return true;
    }
    /**
     * �жϲ��������Ƿ��Ǳ�·�ɿɽ��ܵ�
     * @param $methods string/array HTTP����
     * @return bool
     */
    public function allow_method($methods){
        $methods = array_map('strtoupper',(array)$methods);
        foreach((array)$methods as $method){
            if($method == 'HEAD'){
                $method = 'GET';
            }
            if(in_array($method, $this->methods)){
                return true;
            }
        }
        return false;
    }
}
