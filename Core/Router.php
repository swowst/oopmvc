<?php

namespace Core;

class Router
{
    public const TYPE_GET = 'get';
    public const TYPE_POST = 'post';

    protected static array $get = [];
    protected static array $post = [];

    private string $path;
    private string $method;
    private function parseurl(){
        $this->path = strtolower(str_replace('path=', '', $_SERVER['QUERY_STRING']));
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);

    }

    public function __construct()
    {
        $this->parseurl();
    }


    public static function get(string $path,array|callable $action): void{
        self::addRoute(self::TYPE_GET, $path, $action);
    }

    public static function post(string $path,array|callable $action): void{
        self::addRoute(self::TYPE_POST, $path, $action);
    }


    private static function generateRouteRegex($path): string{
        $segments = explode('/', rtrim($path, '/'));

        $regexRoute = '';
        foreach ($segments as $segment){
            if (preg_match('/^{[a-zA-Z-]+}$/', $segment)){
                $regexRoute .= '\/([a-z-A-Z-\d]+)';

            }else{
                $regexRoute .= "\/". $segment;
            }
        }
       return ltrim($regexRoute, '\/');
    }




    private static function addRoute(string $type, $path, array|callable $action): void{

        $regexRoute = self::generateRouteRegex($path);



        if ($type == self::TYPE_GET){
            self::$get[$path] = [
                'action' => $action,
                'path' => $path,
                'regex' => $regexRoute
            ];
        }else if ($type == self::TYPE_POST){
            self::$post[$path] =[
                'action' => $action,
                'path' => $path,
                'regex' => $regexRoute
            ];
        }
    }
    public function handleRoute(): void {
        echo '<pre>';
        foreach (self::${$this->method} as $route){

            if (preg_match("/^".$route['regex']."$/",$this->path, $params)){
                array_shift($params);


               if (is_callable($route['action'])){
                    call_user_func_array($route['action'], $params);
                    die();
               }else{
                   $class = $route['action'][0];
                   $method = $route['action'][1];
                   call_user_func([new $class(), $method], ...$params);
                   die();

               }


            }

        }
        print_r("Hec bir rut tapilmadi");
    }
}