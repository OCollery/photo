<?php

namespace App\Form;

use App\Entity\Formule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('noPrestation',null,[
                'label'=>false,
                'placeholder'=>'Prestation'
            ])
            ->add('noFormule',null,[
                'label'=>false,
                'placeholder'=>'Formule'
            ])
            ->add('prix',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Prix formule')
            ])
            ->add('detail',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Détail formule')
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formule::class,
        ]);
    }
}
