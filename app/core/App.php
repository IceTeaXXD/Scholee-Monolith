<?php

class App
{
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parse_url();
        if (isset($url[0]) && $url[0] === 'profile/edit') {
            $url[0] = 'editprofile';
        }
        if (file_exists('app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        } else {
            $this->controller = 'home';
        }
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        if (isset($url[1])) {
            $currmethod = explode('=', $url[1]);
            if (method_exists($this->controller, $currmethod[0])) {
                $this->method = $currmethod[0];
                unset($currmethod[0]);
            }
        }
        if ($url) {
            $this->params = array_values($url);
        }
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parse_url()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = rtrim($_SERVER['REQUEST_URI'], '/');
            $url = ltrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $urlParts = explode('?', $url);
            if (isset($urlParts[1])) {
                parse_str($urlParts[1], $_GET);
            }
    
            return $urlParts;        
        }
    }
}
