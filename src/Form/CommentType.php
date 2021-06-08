<?php

namespace App\Form;

use App\Entity\Commentaire;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire',null,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Commentaire')
            ])
            ->add('imageFile', FileType::class,[
                'label'=>false,
                'attr'=> array('placeholder'=> 'Insérer photo')
            ])
            //->add('rendezVous',null)
            //->add('noUtilisateur',null)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
