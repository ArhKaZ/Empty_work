<?php

namespace App\Form\Type;

use App\Entity\Article;
use App\Form\DataTransformer\TaillesTransformer;
use App\Repository\TailleRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaillesType extends AbstractType
{
    private $repository;

    public function __construct(TailleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new TaillesTransformer($this->repository), true)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('attr', [
            'class' => 'taille-input',
        ]);

        /* Permet de laisser la Tailles vide */
        // $resolver->setDefault('required', false);
    }

    public function getParent()
    {
        return TextType::class;
    }
}