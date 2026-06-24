<?php

class App
{

    protected $controller = 'CarController'; 
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();


        if (isset($url[0])) {
            // Ubah format: 'booking' menjadi 'BookingController'
            $controllerName = ucfirst($url[0]) . 'Controller';
            

            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]); 
            }
        }


        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;


        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]); // Hapus nama method dari array URL
            }
        }

        if (!empty($url)) {
            $this->params = array_values($url);
        }


        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Fungsi pemecah URL
    public function parseURL()
    {
        if (isset($_GET['url'])) {
    
            $url = rtrim($_GET['url'], '/');
            
            $url = filter_var($url, FILTER_SANITIZE_URL);
            

            $url = explode('/', $url);
            
            return $url;
        }
        return []; 
    }
}