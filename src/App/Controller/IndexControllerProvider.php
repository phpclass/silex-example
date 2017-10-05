<?php

namespace App\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexControllerProvider implements ControllerProviderInterface
{
    private $app;
    public function indexAction(Request $request){
        $name = $request->get('name' , '!');
        $id = $request->get('id' );
        return Response::create('hello world ' . $name . $id, 200);
    }

    public function getAction(Request $request){
        $name = $request->get('name' , '!');
        $id = $request->get('id' );
        return Response::create('get action!!!! ' . $name . $id, 200);
    }
    private function routing(Request $request){
        $action = $request->get('id' ).'Action';
        return $this->$action($request);
    }

    public function __call($name, $arguments)
    {
        $name = str_replace('Action', '',  $name);
        return Response::create('no route '.$name, 404);
    }

    public function connect(Application $app)
    {
        $this->app = $app;
        /* @var $controllers ControllerCollection*/
        $controllers = $app['controllers_factory'];
        /* @todo добавить роут */
        $controllers->match('{id}{trailing_slash}', function (Application $app) {
            return $this->routing($app['request']);
        })
            ->value('id', 'index')
            ->value('trailing_slash', '')
            ->assert('trailing_slash', '/');


        return $controllers;
    }
}