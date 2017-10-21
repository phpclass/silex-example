<?php
/**
 * Created by PhpStorm.
 * User: oleksandr
 * Date: 21.10.17
 * Time: 10:46
 */

namespace App\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestRelationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('TestRelation', ChoiceType::class, [
            'choices' => $this->loadTestRelations($options['test_relations'])
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['test_relations' => [],]); # custom form option
    }

    private function loadTestRelations($collection)
    {
        # custom logic here (if any)
        $result = [];
        foreach ($collection as $record){
            $result[$record->getName()]=$record->getId();
        }
        return $result;
    }
}