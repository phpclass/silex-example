<?php

namespace App\Form;

use Silex\Application;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\Type\TestRelationType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

//use TextT


class TestForm
{
    private $app;
    private $formOptions;

    /*
     * @return TestForm
     */
    public function __construct(Application $app, $formOptions)
    {
        $this->app = $app;
        $this->formOptions = $formOptions;
        return $this;
    }

    public function buildForm()
    {
        /* @var $form_factory FormFactory */
        $form_factory = $this->app['form.factory'];
        $form = $form_factory->createBuilder(FormType::class)
            ->add("name")
            ->add('email')
            ->add('testRelation', TestRelationType::class, [
                'test_relations' => $this->formOptions['test_relations']
            ]);

        return $form->getForm();
    }

}