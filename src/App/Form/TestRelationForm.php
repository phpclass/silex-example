<?php

namespace App\Form;

use Silex\Application;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TestRelationForm
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

            ->add('submit', SubmitType::class, [
                'label' => 'Add',
            ])
            ->getForm();


        return $form;
    }

}