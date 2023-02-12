<?php

namespace App\Form;

use App\Entity\MatierePremiere;
use App\Entity\UtiliseMP;
use App\Repository\MatierePremiereRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtiliseMPType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('produit')*/
            ->add('matiere_premiere', EntityType::class, [
                'class' => MatierePremiere::class,
                'query_builder' => function (MatierePremiereRepository $repository) {
                    return $repository->getQueryFourniture();
                }
            ])
            ->add('quantitee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UtiliseMP::class,
        ]);
    }
}
