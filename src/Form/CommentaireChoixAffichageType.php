<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireChoixAffichageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Commentaire')
            ])
            ->add('numeroCommentaire',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Numéro du commentaire')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
