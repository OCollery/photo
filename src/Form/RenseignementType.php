<?php

namespace App\Form;

use App\Entity\Renseignement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class RenseignementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Nom')
            ])
            //->add('dateRenseignement')
            ->add('prenom',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Prénom')
            ])
            ->add('telephone',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Téléphone')
            ])
            ->add('mail',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Adresse mail')
            ])
            ->add('dateSeance',null,[
                'label'=>'Date souhaitée'
            ])
            ->add('noPrestation',null,[
                'label'=>false,
                'placeholder'=>'Prestation'
            ])
            ->add('noFormule',null,[
                'label'=>false,
                'placeholder'=>'Formule'
            ])
            ->add('detailProjet',null,[
                'label'=>'Détail projet*'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Renseignement::class,
        ]);
    }
}
