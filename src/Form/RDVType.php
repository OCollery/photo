<?php

namespace App\Form;

use App\Entity\Prestation;
use App\Entity\RendezVous;
use App\Entity\Utilisateur;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RDVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',null,[
                'label'=>false
            ])
            ->add('noPrestation',null,[
                'label'=>false,
                'placeholder'=>'Prestation'
            ])
            ->add('noFormuleIntitule',null,[
                'label'=>false,
                'placeholder'=>'Formule'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
