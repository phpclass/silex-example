<?php

namespace App\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use App\Form\TestForm;
use App\Form\TestRelationForm;
use Symfony\Component\Form\Form;
use App\Entities\Test;
use App\Entities\TestRelation;
use Doctrine\ORM\EntityManager;

class IndexControllerProvider implements ControllerProviderInterface
{
    private $app;

    public function formAction(Request $request)
    {
        /* @var $twig Twig_Environment */
        $twig = $this->app['twig'];
        /* @var $em EntityManager */
        $em = $this->app['orm.em'];
        $test_relation_repository = $em->getRepository(TestRelation::class);
        $formOptions = ['test_relations' => $test_relation_repository->findAll()];
        $form = new TestForm($this->app, $formOptions);
        /* @var  $builded_form Form */
        $builded_form = $form->buildForm();
        $builded_form->handleRequest($request);
        $is_submited = $builded_form->isSubmitted();
        $is_valid = $builded_form->isValid();

        if ($is_valid) {


            $record = new Test();
            $arr_form = $builded_form->getData();

            $record->setName($arr_form['name']);
            $record->setEmail($arr_form['email']);
            $em->persist($record);
            $em->flush();
        }
        $twig_params = [
            'title' => "Наша тестовая форма",
            'form' => $form->buildForm()->createView()
        ];

        $response = $twig->render('form.html.twig', $twig_params);
        return Response::create($response, 200);

    }

    public function form2Action(Request $request)
    {
        /* @var $twig Twig_Environment */
        $twig = $this->app['twig'];

        $form = new TestRelationForm($this->app);
        /* @var  $builded_form Form */
        $builded_form = $form->buildForm();
        $builded_form->handleRequest($request);
//        $is_submited = $builded_form->isSubmitted();
        $is_valid = $builded_form->isValid();
        if ($is_valid) {
            /* @var $em EntityManager */
            $em = $this->app['orm.em'];
            $record = new TestRelation();
            $arr_form = $builded_form->getData();

            $record->setName($arr_form['name']);
            $em->persist($record);
            $em->flush();
        }
        $twig_params = [
            'title' => "Наша тестовая форма связей",
            'form' => $builded_form->createView()
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

        $controllers->match('/form/add', function (Application $app) {
            return $this->getAction();
        });

        return $controllers;
    }
}