<?php

namespace Core;

class App
{

    public function configure(){
        require_once __DIR__.'/../App/config.php';
        require_once __DIR__.'/../App/router.php';
    }

    public function handleRequest(){
        (new Router())->handleRoute();
    }
}