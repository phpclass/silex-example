<?php

namespace App\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use App\Form\TestForm;

class IndexControllerProvider implements ControllerProviderInterface
{
    private $app;

    public function formAction(Request $request)
    {
        /* @var $twig Twig_Environment */
        $twig = $this->app['twig'];

        $form = new TestForm($this->app);

        $twig_params = [
            'title' => "Наша тестовая форма",
            'form' => $form->buildForm()->createView()
        ];

        $response = $twig->render('form.html.twig', $twig_params);
        return Response::create($response, 200);

    }

    public function indexAction(Request $request)
    {
        $name = $request->get('name', '!');
        $id = $request->get('id');
        return Response::create('hello world ' . $name . $id, 200);
    }

    public function getAction(Request $request)
    {
        $name = $request->get('name', '!');
        $id = $request->get('id');
        return Response::create('get action!!!! ' . $name . $id, 200);
    }

    private function routing(Request $request)
    {
        $action = $request->get('id') . 'Action';
        return $this->$action($request);
    }

    public function __call($name, $arguments)
    {
        $name = str_replace('Action', '', $name);
        return Response::create('no route ' . $name, 404);
    }

    public function connect(Application $app)
    {
        $this->app = $app;
        /* @var $controllers ControllerCollection */
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