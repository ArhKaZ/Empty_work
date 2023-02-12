<?php


namespace App\Form\Type;


use App\Entity\Taille;
use App\Repository\ArticleRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticlesType extends AbstractType
{
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tailles', EntityType::class, [
                'class' => Taille::class,
                'multiple' => true,
                'expanded' => true,
                /*'attr' => ['class' => 'badge bg-secondary'],*/
            ])
        ;
    }
}