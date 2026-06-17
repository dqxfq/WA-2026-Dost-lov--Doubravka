<?php

class App {

    protected $controller = 'Místacontroller';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {

        $url = $this->parseUrl();

        if (isset($url[0])) {

            if ($url[0] === 'auth') {
                $this->controller = 'AuthController';
                require_once '../APP/Controller/authcontroller.php';
                unset($url[0]);

            } elseif ($url[0] === 'mista' || $url[0] === 'místa') {
                $this->controller = 'Místacontroller';
                require_once '../APP/Controller/místacontroller.php';
                unset($url[0]);

            } elseif ($url[0] === 'komenty') {
                $this->controller = 'KomentyController';
                require_once '../APP/Controller/komentycontroller.php';
                unset($url[0]);

            } else {
                require_once '../APP/Controller/místacontroller.php';
                unset($url[0]);
            }

        } else {
            require_once '../APP/Controller/místacontroller.php';
        }

        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', trim($_GET['url'], '/'));
        }

        return [];
    }
}