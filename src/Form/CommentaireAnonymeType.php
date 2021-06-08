<?php

namespace App\Form;

use App\Entity\CommentaireAnonyme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireAnonymeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Nom')
            ])
            ->add('prenom',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Prénom')
            ])
            ->add('dateSeance')
            ->add('noPrestation',null,[
                'label'=>false,
                'placeholder'=>'Prestation'
            ])
            //->add('numeroCommentaire')
            ->add('commentaire',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Commentaire')
            ])
            ->add('imageFile',FileType::class,[
                'label'=>false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommentaireAnonyme::class,
        ]);
    }
}
