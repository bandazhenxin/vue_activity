<?php
Vendor('Route.Router');
Vendor('Api.Jwt');

function setRoute($route_ruler){
    //init
    $type_range = array('get', 'post', 'put', 'delete', 'head', 'patch');
    if(!is_array($route_ruler)) response(500, 'params error', array());
    $url_route  = getRoute();
    $request    = getMethod();

    //set route
    $router = new Router();
    $ruler  = array();
    foreach ($route_ruler as $route){
        //validate
        if(!is_array($route) || 3 > count($route) || !is_string($route[0]) || !is_string($route[1]))
            response(500, 'params error', array());
        if(!is_string($route[2]) || !in_array(strtolower($route[2]), $type_range))
            response(500, 'route error', array());

        //action
        $method           = strtolower($route[2]);
        $ruler[$route[0]] = $route[1];
        $self_route       = '/' . ltrim($route[0], '/');
        $router->$method($self_route, $route[1]);
        #validate jwt
        if($self_route == $url_route && $method == $request && !empty($route[3])){
            if(false === Jwt::verifyToken(getRequestToken()))
                response(401, 'token error', array());
        }
    }

    //get
    if(!$match = $router->match($url_route,$request))
        response(404, 'route error', array());
    $_GET = array_merge($_GET, $match->getParams() ? $match->getParams() : array());

    return array('URL_ROUTE_RULES' => $ruler);
}
