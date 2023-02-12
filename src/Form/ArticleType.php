<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Fournisseur;
use App\Form\Type\TaillesType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mb = ['attr' => ['class' => 'mb-3']];
        $builder
            ->add('nom', null, $mb)
            ->add('refCompta', null, $mb)
            ->add('nbNoeud', null, [
                'label' => 'Nombre de noeuds',
                'attr' => ['class' => 'mb-3'],
                'required' => true,
            ])
            ->add('commentaire', null, $mb)
            ->add('tailles', TaillesType::class, [
                'required' => false,
            ])
            ->add('lieux_coupes', EntityType::class, [
                'attr' => ['class' => 'mb-3'],
                'class' => Fournisseur::class,
                'multiple' => true,
            ])
            ->add('lieux_assemblages', EntityType::class, [
                'attr' => ['class' => 'mb-3'],
                'class' => Fournisseur::class,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
