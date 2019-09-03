<?php
Vendor('Api.Jwt');
import('App.Services.NavListService');

class TestAction extends Action {
    public function index(){
        var_dump(Service('NavList'));
    }

    public function getToken(){
        $nav = D('NavList');
        $nav->find(1);
        response(200, 'ok',array($nav->title));
    }
}