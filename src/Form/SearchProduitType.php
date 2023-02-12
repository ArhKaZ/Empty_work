<?php


namespace App\Form;


use App\Data\SearchProduit;
use App\Entity\Article;
use App\Entity\CollectionArticle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher une ref'
                ]
            ])
            ->add('collections', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => CollectionArticle::class,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('articles', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Article::class,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('dans_catalogue', CheckboxType::class, [
                'required' => false
            ])
            ->add('reset',ResetType::class, [
                'label' => false,
                'attr' => ['class' => 'bi bi-dash-circle-dotted']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchProduit::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}