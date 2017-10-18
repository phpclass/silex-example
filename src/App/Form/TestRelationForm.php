<?php

namespace App\Form;

use Silex\Application;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
//            ->add('phonenumbers', EntityType::class, [
//                'class'=>'AppBundle:Test',
//                'choice_label' => 'phonenumbers',
//            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Add',
            ])
            ->getForm();


        return $form;
    }

}