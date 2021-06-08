<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Nom')
            ])
            ->add('prenom',null,[
                "label"=>false,
                'attr'=> array('placeholder'=> 'Prénom')
            ])
            ->add('dateNaissance',BirthdayType::class,[
                "label"=>false
            ])

            ->add('telephone',null,[
                "label"=>false,
                'attr'=> array('placeholder'=> 'N° de téléphone')
            ])
            ->add('mail',EmailType::class,[
                "label"=>false,
                'attr'=> array('placeholder'=> 'Mail')
            ])
            ->add('rue',null,[
                "label"=>false,
                'attr'=> array('placeholder'=> 'Rue')
            ])
            ->add('codePostal',null,[
                "label"=>false,
                'attr'=> array('placeholder'=> 'Code Postal')
            ])
            ->add('ville',null,[
                "label"=>false,
                'attr'=> array('placeholder'=> 'Ville')
            ])
            ->add('motPasse',RepeatedType::class,[
                "type"=>PasswordType::class,
                'first_options'  => array('label'=>false, 'attr'=>array('placeholder'=>'Mot de passe')),
                'second_options' => array('label'=>false, 'attr'=>array('placeholder'=>'Répéter le Mot de passe')),
                'invalid_message' => 'Your passwords do not match!'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
