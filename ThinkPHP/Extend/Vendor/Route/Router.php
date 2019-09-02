<?php
Vendor('Route.Route');

/**
 * Route��Ĺ�������
 */
class Router{
    private $routes = array();

    /**
     * ���մ���Ĺ������ӵ�·�����ҵ�ƥ��·��
     * @param  String $uri    Ҫƥ���URL
     * @param  String $method ƥ���HTTP����
     * @return \CutePHP\Route\Route or false
     */
    public function match($uri, $method){
        foreach($this->routes as $route){
            if($route->match($uri, $method)){ //����ÿ������Route��ѯ�Ƿ�ƥ��
                return $route;
            }
        }
        //û���ҵ�ƥ���·��
        return false;
    }

    /**
     * ����µ�·��ƥ��
     * @param $uri
     * @param $storage
     * @param null $name
     * @param null $methods
     * @return Route
     */
    public function add($uri, $storage, $name = null, $methods = null){
        $route = new Route($uri, $storage, $methods);
        if($name !== null){
            $this->routes[$name] = $route;
        }else{
            $this->routes[] = $route;
        }
        return $route;
    }

    /**
     * ͨ��·�����ֻ�ȡ·�ɶ���
     * @return \CutePHP\Route\Route or false
     */
    public function name($name){
        return isset($this->routes[$name]) ? $this->routes[$name] : false;
    }

    /**
     * ���get����·��
     *
     * @param  String $uri     ·��ƥ���URI
     * @param  [Mix] [Mix] $storage ��Ҫ�������������
     * @param  String $name    ·����
     * @return \CutePHP\Route\Route     ��ӵ�Route����
     */
    public function get($uri, $storage, $name = null){
        return $this->add($uri, $storage, $name, 'GET');
    }

    /**
     * ���head����·��
     *
     * @param  String $uri     ·��ƥ���URI
     * @param  [Mix] $storage ��Ҫ�������������
     * @param  String $name    ·����
     * @return \CutePHP\Route\Route     ��ӵ�Route����
     */
    public function head($uri, $storage, $name = null){
        return $this->add($uri, $storage, $name, 'HEAD');
    }

    /**
     * ���post����·��
     *
     * @param  String $uri     ·��ƥ���URI
     * @param  [Mix] $storage ��Ҫ�������������
     * @param  String $name    ·����
     * @return \CutePHP\Route\Route     ��ӵ�Route����
     */
    public function post($uri, $storage, $name = null){
        return $this->add($uri, $storage, $name, 'POST');
    }

    /**
     * ���delete����·��
     *
     * @param  String $uri     ·��ƥ���URI
     * @param  [Mix] $storage ��Ҫ�������������
     * @param  String $name    ·����
     * @return \CutePHP\Route\Route     ��ӵ�Route����
     */
    public function delete($uri, $storage, $name = null){
        return $this->add($uri, $storage, $name, 'DELETE');
    }

    /**
     * ���put����·��
     *
     * @param  String $uri     ·��ƥ���URI
     * @param  [Mix] $storage ��Ҫ�������������
     * @param  String $name    ·����
     * @return \CutePHP\Route\Route     ��ӵ�Route����
     */
    public function put($uri, $storage, $name = null){
        return $this->add($uri, $storage, $name, 'PUT');
    }

    /**
     * ���pathch����·��
     *
     * @param  String $uri     ·��ƥ���URI
     * @param  [Mix] $storage ��Ҫ�������������
     * @param  String $name    ·����
     * @return \CutePHP\Route\Route     ��ӵ�Route����
     */
    public function pathch($uri, $storage, $name = null){
        return $this->add($uri, $storage, $name, 'PATCH');
    }
}