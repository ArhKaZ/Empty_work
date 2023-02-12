<?php

namespace App\Form;

use App\Entity\CollectionArticle;
use App\Entity\MatierePremiere;
use App\Entity\Taille;
use App\Form\Type\ArticlesType;
use App\Repository\MatierePremiereRepository;
use App\Repository\TailleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CollectionArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mb = ['attr' => ['class' => 'mb-3']];
        $builder
            ->add('nom')
            ->add('commentaire')
            ->add('motifFile', FileType::class, [
                'mapped' => false,
                'constraints' => [new Image()],
                'label' => 'Motif',
                'attr' => [
                    'class' => 'form-control',
                    'onchange' => 'updateImage(this);'
                ],
                'required' => false,
            ])
            ->add('tissu', EntityType::class, [
                'class' => MatierePremiere::class,
                'attr' => ['required' => true],
                'query_builder' => function (MatierePremiereRepository $repository) {
                    return $repository->getQueryTissu();
                }
            ])
            ->add('couleurNoeud',EntityType::class, [
                'class' => MatierePremiere::class,
                'query_builder' => function (MatierePremiereRepository $repository) {
                    return $repository->getQueryNoeud();
                }
            ])
            ->add('addToCatalog', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Ajouter au catalogue',
                'attr' => ['checked' => true],
                'required' => false,
            ])
            ->add('tailles', EntityType::class, [
                'class' => Taille::class,
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'attending_' . strtolower($key)];
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CollectionArticle::class,
        ]);
    }
}
