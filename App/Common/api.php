<?php
Vendor('Api.Response');

/**
 * API???
 * @param $code
 * @param $message
 * @param array $data
 * @param string $type
 */
function response($code, $message, $data = array(), $type = 'json'){
    Response::show($code, $message, $data, $type);
}

/**
 * ????????
 * @return string
 */
function getMethod(){
    return strtolower($_SERVER['REQUEST_METHOD']);
}

/**
 * ?????????
 * @return array|string
 */
function getRoute(){
    $url       = $_SERVER['REQUEST_URI'];
    $url_info  = parse_url($url);
    $url_path  = $url_info['path'];
    $url_route = end(explode('index.php', $url_path));
    return $url_route;
}

/**
 * ???header???
 * @return array
 */
function getHeader(){
    // ????????header????????????????????????????????????
    $ignore  = array('host','accept','content-length','content-type');
    $headers = array();

    foreach($_SERVER as $key=>$value){
        if(substr($key, 0, 5)==='HTTP_'){
            //????????????'http_'??????????
            $key = substr($key, 5);
            $key = str_replace('_', ' ', $key);
            $key = str_replace(' ', '-', $key);
            $key = strtolower($key);

            //????????????????§Õ??$ignore?????§Ö?????
            if(!in_array($key, $ignore))
                $headers[$key] = $value;
        }
    }

    return $headers;
}

/**
 * ???post???????
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
 * ???get???????
 * @return mixed
 */
function getGet(){
    return $_GET;
}

/**
 * ??????????????
 * @return array
 */
function getRequest(){
    return array_merge(getGet(), getPost());
}

/**
 * ???token???????
 */
function getRequestToken(){
    $header  = getHeader();
    $request = getRequest();
    $res_token = !empty($request['token']) ? $request['token'] : false;
    return $header['Authorizatio'] ? $header['Authorizatio'] : $res_token;
}

/**
 * ?????service
 * @param $service_name
 * @return mixed
 */
function Service($service_name){
    if(!is_string($service_name))
        response(500, 'service error');

    $service_name = str_replace('Service', '', $service_name) . 'Service';
    if(import('App.Services.' . $service_name))
        return new $service_name();

    response(500, 'service error');
}