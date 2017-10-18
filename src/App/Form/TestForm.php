<?php

namespace App\Form;

use Silex\Application;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use TextT


class TestForm
{
    private $app;

    /*
     * @return TestForm
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        return $this;
    }

    public function buildForm()
    {
        /* @var $form_factory FormFactory */
        $form_factory = $this->app['form.factory'];
        $form = $form_factory->createBuilder()
            ->add("name")
            ->add('email');
        $form->add('testRelation', EntityType::class, [
            'class' => 'App:TestRelation',
            'choice_label' => 'tratata',
        ]);
        $form->getForm();


        return $form;
    }

}