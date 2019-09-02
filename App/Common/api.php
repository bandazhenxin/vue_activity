<?php
Vendor('Api.Response');

/**
 * API输出
 * @param $code
 * @param $message
 * @param array $data
 * @param string $type
 */
function response($code, $message, $data = array(), $type = 'json'){
    Response::show($code, $message, $data, $type);
}

/**
 * 获取请求方式
 * @return string
 */
function getMethod(){
    return strtolower($_SERVER['REQUEST_METHOD']);
}

/**
 * 获取当前路由
 * @return array|string
 */
function getRoute(){
    $url       = $_SERVER['REQUEST_URI'];
    $url_info  = parse_url($url);
    $url_path  = $url_info['path'];
    $url_route = array();
    foreach(explode('/', $url_path) as $path){
        if('index.php' != $path) $url_route[] = $path;
    }
    $url_route = implode('/', $url_route);
    return $url_route;
}

/**
 * 获取header信息
 * @return array
 */
function getHeader(){
    // 忽略获取的header数据。这个函数后面会用到。主要是起过滤作用
    $ignore  = array('host','accept','content-length','content-type');
    $headers = array();

    foreach($_SERVER as $key=>$value){
        if(substr($key, 0, 5)==='HTTP_'){
            //这里取到的都是'http_'开头的数据。
            $key = substr($key, 5);
            $key = str_replace('_', ' ', $key);
            $key = str_replace(' ', '-', $key);
            $key = strtolower($key);

            //这里主要是过滤上面写的$ignore数组中的数据
            if(!in_array($key, $ignore))
                $headers[$key] = $value;
        }
    }

    return $headers;
}

/**
 * 获取post请求参数
 * @return mixed
 */
function getPost(){
    $postdata = file_get_contents("php://input");
    if($postdata){
        parse_str(urldecode($postdata), $data);
        json_decode($data, true) && $data = json_decode($data, true);
    }else{
        $data = !empty($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : $_POST;
    }

    return $data;
}

/**
 * 获取get请求参数
 * @return mixed
 */
function getGet(){
    return $_GET;
}

/**
 * 获取所有请求参数
 * @return array
 */
function getRequest(){
    return array_merge(getGet(), getPost());
}

/**
 * 获取token请求参数
 */
function getRequestToken(){
    $header  = getHeader();
    $request = getRequest();
    $res_token = !empty($request['token']) ? $request['token'] : false;
    return $header['Authorizatio'] ? $header['Authorizatio'] : $res_token;
}